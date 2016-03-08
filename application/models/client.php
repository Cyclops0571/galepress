<?php

/**
 * @property int $ClientID Description
 * @property int $ApplicationID Description
 * @property int $Username Description
 * @property int $Password Description
 * @property int $Email Description
 * @property int $Token Description
 * @property int $DeviceToken Description
 * @property int $Name Description
 * @property int $Surname Description
 * @property int $PaidUntil Description
 * @property int $SubscriptionChecked Description
 * @property string $ContentIDSet Description
 * @property int $LastLoginDate Description
 * @property int $InvalidPasswordAttempts Description
 * @property int $PWRecoveryCode Description
 * @property int $PWRecoveryDate Description
 * @property int Version
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $created_at Description
 * @property int $updated_at Description
 * @property Application $Application Description
 */
class Client extends Eloquent
{

    public static $table = 'Client';
    public static $key = 'ClientID';

    /**
     * @param $clientID
     * @param array $columns
     * @return Client
     */
    public static function find($clientID, $columns = array('*'))
    {
        return Client::where(self::$key, "=", $clientID)->first($columns);
    }

    public static function getSampleXmlUrl()
    {
        return "/files/sampleFiles/SampleClientExcel_" . Laravel\Config::get("application.language") . ".xls";
    }

    public static function updateDeviceToken($accessToken, $deviceToken)
    {
        if (!empty($deviceToken)) {
            /* @var $client Client */
            $client = Client::where("Token", "=", $accessToken)->where("StatusID", "=", eStatus::Active)->first();
            if ($client && $client->DeviceToken !== $deviceToken) {
                $client->DeviceToken = $deviceToken;
                $client->save();
            }
        }
    }

    public function save()
    {
        if (!$this->dirty()) {
            return true;
        }

        if ($this->PaidUntil > date('Y:m:d H:i:s')) {
            $this->SubscriptionChecked = 0;
        }

        $this->Version = (int)$this->Version + 1;
        parent::save();
    }



    /**
     *
     * @return Content
     */
    public function Contents()
    {
        $contents = array();
        $contentIDSet = explode(",", $this->ContentIDSet);
        foreach ($contentIDSet as $contentID) {
            $tmpContent = Content::find($contentID);
            if ($tmpContent) {
                $contents[] = $tmpContent;
            }
        }
        return $contents;
    }

    /**
     * @param ClientReceipt $receipt
     * @throws Exception
     */
    public function CheckReceipt($receipt)
    {
        /** @var ClientReceipt $clientReceipt */
        switch ($receipt->Platform) {
            case 'android':
                $this->checkReceiptGoogle($receipt);
                break;
            case 'ios':
                $this->checkReceiptIos($receipt);
                break;
        }
        $this->save();
    }

    /**
     * @param $clientReceipt
     * @throws Exception
     */
    private function checkReceiptGoogle($clientReceipt)
    {
        require_once path('bundle') . '/google/src/Google/autoload.php';
        $client = new Google_Client();
        // set Application Name to the name of the mobile app
        $client->setApplicationName($this->Application->Name);
        // get p12 key file
        $key = file_get_contents(path('app') . 'keys/GooglePlayAndroidDeveloper-74176ee02cd0.p12');

        // create assertion credentials class and pass in:
        // - service account email address
        // - query scope as an array (which APIs the call will access)
        // - the contents of the key file
        $cred = new Google_Auth_AssertionCredentials(
            '552236962262-compute@developer.gserviceaccount.com',
            array('https://www.googleapis.com/auth/androidpublisher'),
            $key
        );
        // add the credentials to the client
        $client->setAssertionCredentials($cred);
        // create a new Android Publisher service class
        $service = new Google_Service_AndroidPublisher($client);
        // use the purchase token to make a call to Google to get the subscription info
        /** @var Content $content */
        $content = Content::where("Identifier", '=', $clientReceipt->SubscriptionID)->where("ApplicationID", '=', $this->Application->ApplicationID)->first();
        if ($content) {
            //content ise valide edip contenti erişebilir content listesine koyacağız...
            $productPurchaseResponse = $service->purchases_products->get($clientReceipt->PackageName, $clientReceipt->SubscriptionID, $clientReceipt->Receipt);
            $clientReceipt->SubscriptionType = $productPurchaseResponse->getKind();
            $clientReceipt->MarketResponse = json_encode($productPurchaseResponse->toSimpleObject());
            $clientReceipt->save();

            if ($productPurchaseResponse->consumptionState == webService::GoogleConsumptionStatePurchased) {
                //Content bought so save content to clients purchased products
                $this->addPurchasedItem($content->ContentID);
            } else {
                throw eServiceError::getException(eServiceError::GenericError, 'Content Not Bought.');
            }

        } else {
            //applicationda $productID var mi kontrol edecegiz...
            $subscription = $service->purchases_subscriptions->get($clientReceipt->PackageName, $clientReceipt->SubscriptionID, $clientReceipt->Receipt);
            $clientReceipt->MarketResponse = json_encode($subscription->toSimpleObject());
            if (is_null($subscription) || !$subscription->getExpiryTimeMillis() > 0) {
                $clientReceipt->save();
                throw eServiceError::getException(eServiceError::GenericError, 'Error validating transaction.');
            }

            //validate oldu tekrar kaydedelim...
            $clientReceipt->SubscriptionType = $subscription->getKind();
            $clientReceipt->SubscriptionStartDate = date("Y-m-d H:i:s", $subscription->getStartTimeMillis() / 1000);
            $clientReceipt->SubscriptionEndDate = date("Y-m-d H:i:s", $subscription->getExpiryTimeMillis() / 1000);
            $clientReceipt->save();


            if (empty($this->PaidUntil) || $this->PaidUntil < $clientReceipt->SubscriptionEndDate) {
                $this->PaidUntil = $clientReceipt->SubscriptionEndDate;
            }
        }
    }

    public function addPurchasedItem($contentID)
    {
        $contentIDSet = $this->ContentIDSet;
        if (empty($contentIDSet)) {
            $contentIDSet = array($contentID);
        } else {
            $contentIDSet = explode(',', $this->ContentIDSet);
            array_push($contentIDSet, $contentID);
        }
        $contentIDSet = array_unique($contentIDSet);
        sort($contentIDSet);
        $this->ContentIDSet = trim(implode(",", $contentIDSet), ',');
    }

    /**
     * @param $clientReceipt
     * @throws Exception
     * @throws ServerErrorException
     */
    private function checkReceiptIos($clientReceipt)
    {
        //validate olursa $clientReceipt'i ona gore kaydedicegiz...

        $receiptObject = webService::buildAppleJSONReceiptObject($clientReceipt->Receipt, $this->Application->IOSHexPasswordForSubscription);
        $response = webService::makeAppleReceiptRequest('https://buy.itunes.apple.com/verifyReceipt', $receiptObject);
        $clientReceipt->MarketResponse = json_encode($response);
        if (isset($response["status"]) && $response["status"] == 21007) {
            //sandbox receipti geldi url sandboxa dönmeli...
            $response = webService::makeAppleReceiptRequest('https://sandbox.itunes.apple.com/verifyReceipt', $receiptObject);
            $clientReceipt->MarketResponse = json_encode($response);
        }

        $errorMsg = webService::checkIosResponse($response);
        if (!empty($errorMsg)) {
            $clientReceipt->save();
            throw eServiceError::getException(eServiceError::GenericError, $errorMsg);
        }

        //apple icin butun receiptleri donup direk restore edicem...
        foreach ($response["receipt"]["in_app"] as $key => $inApp) {
            if (!isset($inApp['expires_date_ms'])) {
                //expires_date_ms set edilmemis ise product satin almadir.
                if (isset($inApp["product_id"])) {
                    $content = Content::where("Identifier", '=', $clientReceipt->SubscriptionID)->where("ApplicationID", '=', $this->Application->ApplicationID)->first();
                    if (isset($content)) {
                        $this->addPurchasedItem($content->ContentID);
                    }
                }
            } else {
                //expires_date_ms set edilmis subscription satin alinmis.
                $clientReceipt->SubscriptionType = "iospublisher#subscriptionPurchase";
                $inAppExpiresDate = date("Y-m-d H:i:s", $inApp["expires_date_ms"] / 1000);
                if (empty($this->PaidUntil) || $this->PaidUntil < $inAppExpiresDate) {
                    $this->PaidUntil = $inAppExpiresDate;
                }

                if ($key == count($response["receipt"]["in_app"]) - 1) {
                    //en son alinmis receipti kaydedelim...
                    $clientReceipt->SubscriptionStartDate = date("Y-m-d H:i:s", $inApp["purchase_date_ms"] / 1000);
                    $clientReceipt->SubscriptionEndDate = $inAppExpiresDate;
                    $clientReceipt->save();
                }
            }
        }
    }

    public function CheckReceiptCLI()
    {
        /** @var ClientReceipt[] $clientReceipts */
        $clientReceipts = ClientReceipt::where('clientID', 'clientID')
            ->where_in('SubscriptionType', array('iospublisher#subscriptionPurchase', 'androidpublisher#subscriptionPurchase'))
            ->get();

        foreach ($clientReceipts as $clientReceipt) {
            try {
                switch ($clientReceipt->Platform) {
                    case 'android':
                        $this->checkReceiptGoogle($clientReceipt);
                        break;
                    case 'ios':
                        $this->checkReceiptIos($clientReceipt);
                        break;
                }
            } catch (Exception $e) {
                Log::error($e->getMessage() . ' - Receipt ID: ' . $clientReceipt->ClientReceiptID);
            }
        }
        $this->Version++;
        $this->save();
    }

    protected function Application()
    {
        return $this->belongs_to('Application', 'ApplicationID');
    }
}
