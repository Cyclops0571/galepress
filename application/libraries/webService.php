<?php

class webService
{

    const GoogleConsumptionStatePurchased = 0;
    const GoogleConsumptionStateCanceled = 1;
    const GoogleConsumptionStateRefunded = 2;

    /**
     * If there is a exception then catches it and returns a valid Response else returns what the Closure returns
     * @param Closure $cb
     * @return Laravel\Response
     */
    public static function render(Closure $cb)
    {
        try {
            //return $cb();
            return call_user_func($cb);
        } catch (Exception $e) {
            return Response::json(array(
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ));
        }
    }

    // Customer
    public static function getCheckCustomer($ServiceVersion, $customerID)
    {
        $customer = Customer::where('CustomerID', '=', $customerID)->where('StatusID', '=', eStatus::Active)->first();
        if (!$customer) {
            throw eServiceError::getException(eServiceError::UserNotFound);
        }
        return $customer;
    }

    /**
     *
     * @param int $ServiceVersion
     * @param int $applicationID
     * @return Application
     * @throws Exception
     */
    public static function getCheckApplication($ServiceVersion, $applicationID)
    {
        $application = Application::where('ApplicationID', '=', $applicationID)->where('StatusID', '=', eStatus::Active)->first();
        if (!$application) {
            throw eServiceError::getException(eServiceError::ApplicationNotFound);
        }
        if (!($application->ExpirationDate >= date("Y-m-d H:i:s") && (int)$application->Blocked == 0 && (int)$application->Status == 1)) {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }
        return $application;
    }

    public static function getCheckApplicationCategories($ServiceVersion, $applicationID)
    {
        $application = Application::find($applicationID);
        $categories = array();
        //add general
        array_push($categories, array(
            'CategoryID' => 0,
            'CategoryName' => (string)Lang::line('common.contents_category_list_general', array(), $application->ApplicationLanguage)
        ));
        $rs = Category::where('ApplicationID', '=', $applicationID)->where('StatusID', '=', eStatus::Active)->order_by('Name', 'ASC')->get();
        foreach ($rs as $r) {
            array_push($categories, array(
                'CategoryID' => (int)$r->CategoryID,
                'CategoryName' => $r->Name
            ));
        }
        return $categories;
    }

    public static function getCheckApplicationCategoryDetail($ServiceVersion, $applicationID, $categoryID)
    {
        $category = Category::where('CategoryID', '=', $categoryID)
            ->where('ApplicationID', '=', $applicationID)
            ->where('StatusID', '=', eStatus::Active)->first();
        if (!$category) {
            throw eServiceError::getException(eServiceError::CategoryNotFound);
        }
        return $category;
    }

    public static function getCheckApplicationContents($data = null)
    {
        $ServiceVersion = isset($data["ServiceVersion"]) ? $data["ServiceVersion"] : False;
        /** @var Application $application */
        $application = $data["application"];
        $accessToken = isset($data["accessToken"]) ? $data["accessToken"] : False;
        $isTest = isset($data["isTest"]) ? $data["isTest"] : False;

        $query = Content::where('ApplicationID', '=', $application->ApplicationID)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('OrderNo', 'DESC')
            ->order_by('MonthlyName', 'ASC')
            ->order_by('Name', 'ASC');
        if (!$isTest) {
            $query->where(function ($q) {
                $q->where('Status', '=', eStatus::Active);
                $q->or_where("RemoveFromMobile", "=", eRemoveFromMobile::Active);
            });
        }

        $categoryID = (int)Input::get('categoryID', '-1');
        if ($categoryID !== -1) {
            $rs = $query->where('ContentID', 'IN', DB::raw('(SELECT ContentID FROM ContentCategory WHERE CategoryID=' . (int)$categoryID . ')'));
        }

        /** @var Content[] $rs */
        $rs = $query->get();
        $contents = array();
        foreach ($rs as $r) {
            $serveContent = $r->PublishDate <= date("Y-m-d H:i:s");
            $serveContent = $serveContent && ($r->IsUnpublishActive == 0 || $r->UnpublishDate > date("Y-m-d"));
            $serveContent = $serveContent || ($r->RemoveFromMobile == eRemoveFromMobile::Active);
            if ($serveContent) {

                //check if client has an access to wanted content.
                $clientBoughtContent = FALSE;
                /* @var $client Client */
                $client = webService::getClientFromAccessToken($accessToken, $application->ApplicationID);
                if (!$client) {
                    $clientBoughtContent = FALSE;
                } else {
                    $boughtContentIDSet = explode(",", $client->ContentIDSet);
                    if (in_array($r->ContentID, $boughtContentIDSet)) {
                        $clientBoughtContent = TRUE;
                    }
                }

                array_push($contents, array(
                    'ContentID' => (int)$r->ContentID,
                    'ContentName' => $r->Name,
                    'ContentMonthlyName' => $r->MonthlyName,
                    'ContentIsMaster' => (bool)$r->IsMaster,
                    'ContentOrientation' => (int)$r->Orientation,
                    'ContentBlocked' => (bool)$r->Blocked,
                    'ContentStatus' => (bool)$r->Status,
                    'ContentVersion' => (int)$r->Version,
                    'ContentOrderNo' => (int)$r->OrderNo,
                    'RemoveFromMobile' => (bool)$r->RemoveFromMobile,
                    'ContentIsBuyable' => (bool)$r->IsBuyable,
                    'ContentPrice' => (string)$r->Price,
                    'ContentCurrency' => $r->Currency(1),
                    'ContentIdentifier' => $r->getIdentifier(),
                    'ContentBought' => $clientBoughtContent,
                ));
            }
        }
        return $contents;
    }

    /**
     * @param $accessToken
     * @param $applicationID
     * @return Client
     * @throws Exception
     */
    public static function getClientFromAccessToken($accessToken, $applicationID)
    {
        $client = Client::where("Token", "=", $accessToken)->where('ApplicationID', '=', $applicationID)->where("StatusID", "=", eStatus::Active)->first();
        if (!empty($accessToken) && !$client) {
            throw eServiceError::getException(eServiceError::ClientNotFound);
        }
        return $client;
    }

    // Check User credential

    /**
     * RemoveFromMobilei aktif olanlari veya StatusID eStatus::Active olanlari doner.
     * @param int $contentID
     * @return Content
     * @throws Exception
     */
    public static function getCheckContent($ServiceVersion, $contentID)
    {
        $content = Content::where('ContentID', '=', $contentID)
            ->where(function ($q) {
                $q->where('StatusID', '=', eStatus::Active);
                $q->or_where("RemoveFromMobile", "=", eRemoveFromMobile::Active);
            })
            ->first();

        if (!$content) {
            throw eServiceError::getException(eServiceError::ContentNotFound);
        }
        if (!((int)$content->Blocked == 0)) {
            throw eServiceError::getException(eServiceError::ContentBlocked);
        }
        return $content;
    }

    // Save token

    public static function checkUserCredential($ServiceVersion, $customerID)
    {
        $username = Input::get('username', '');
        $password = Input::get('password', '');
        $user = null;
        if (strlen($username) > 0) {
            $user = User::where('CustomerID', '=', (int)$customerID)->where('Username', '=', $username)->where('StatusID', '=', eStatus::Active)->first();
            if (!$user) {
                throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
            }

            if (!(crypt($password, $user->Password) === $user->Password)) {
                throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
            }
        }
        return $user;
    }

    public static function saveToken($ServiceVersion, $customerID, $applicationID)
    {
        $UDID = Input::get('udid', '');
        $applicationToken = Input::get('applicationToken', '');
        $deviceToken = Input::get('deviceToken', '');
        $deviceType = Input::get('deviceType', 'ios');
        $accessToken = \Laravel\Input::get('accessToken', '');

        //if(strlen($applicationToken) > 0 && strlen($deviceToken) > 0)
        $token = NULL;
        if (strlen($deviceToken) > 0) {
            if ($deviceType == eDeviceType::android && !empty($UDID)) {
                $token = Token::where('ApplicationID', '=', $applicationID)
                    ->where('UDID', '=', $UDID)
                    ->first();
                if ($token) {
                    //eski android uygulamasi tekrardan geldi deviceTokeni guncelleyelim.
                    $token->DeviceToken = $deviceToken;
                }
            } else {
                $token = Token::where('ApplicationToken', '=', $applicationToken)->where('DeviceToken', '=', $deviceToken)->first();
                if ($token) {
                    //INFO:Added due to https://github.com/galepress/gp/issues/2
                    //Emre, Eger token tablosuna getAppDetail'den gelen bir deviceToken kaydedildiyse ayni deviceToken'ile baska insert yapilmiyor.
                    //Fakat soyle bir durum soz konusu. Benim deviceToken'im kaydedildi ama daha sonra yeni update ile udid'lerde geliyor.
                    //deviceToken tabloda varsa udid'sini update etmesi lazim. Yoksa udid eklemememizin bir manasi olmayacak.
                    //bir cihaza uygualma bir kez kurulduysa hic udid'sini alamayiz.
                    $token->UDID = $UDID;
                }
            }
            if (empty($token)) {
                $token = new Token();
                $token->CustomerID = (int)$customerID;
                $token->ApplicationID = (int)$applicationID;
                $token->UDID = $UDID;
                $token->ApplicationToken = $applicationToken;
                $token->DeviceToken = $deviceToken;
                $token->DeviceType = $deviceType;
                $token->StatusID = eStatus::Active;
            }
            $token->save();
        }

        Client::updateDeviceToken($accessToken, $deviceToken);
    }

    /**
     *
     * @param type $serviceVersion
     * @param type $username
     * @param type $password
     * @param type $userFacebookID
     * @param type $userFbEmail
     * @return User
     * @throws Exception
     */
    public static function getCheckUser($ServiceVersion, $username, $password, $userFacebookID, $userFbEmail)
    {
        if (!empty($username) && !empty($password)) {
            //username ve password login
            $user = User::where('Username', '=', $username)->where('StatusID', '=', eStatus::Active)->first();
            if (!$user) {
                throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
            }

            if (!Hash::check($password, $user->Password)) {
                throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
            }
        } else if (!empty($userFacebookID) && !empty($userFbEmail)) {
            //facebook login
            $user = User::where('FbUsername', '=', $userFacebookID)
                ->where('FbEmail', '=', $userFbEmail)
                ->where('StatusID', '=', eStatus::Active)->first();
            if (!$user) {
                throw eServiceError::getException(eServiceError::CreateAccount);
            }
        } else {
            throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
        }

        if ($user->CustomerID == 0) {
            //Customer not exist
            throw eServiceError::getException(eServiceError::IncorrectUserCredentials);
        }

        return $user;
    }

    /**
     *
     * @param type $serviceVersion
     * @param type $applicationID
     * @param type $username
     * @param type $password
     * @return Client
     * @throws Exception
     */
    public static function getCheckClient($serviceVersion, $applicationID, $username, $password)
    {
        if (empty($username) || empty($password)) {
            throw eServiceError::getException(eServiceError::ClientNotFound);
        }

        /* @var $client Client */
        $client = Client::where('ApplicationID', '=', $applicationID)
            ->where('Username', '=', $username)
            ->where('StatusID', '=', eStatus::Active)->first();
        if (!$client) {
            throw eServiceError::getException(eServiceError::ClientNotFound);
        } else if ($client->Password != $password) {
            $client->InvalidPasswordAttempts++;
            $client->save();
            throw eServiceError::getException(eServiceError::ClientIncorrectPassword);
        } else if ($client->InvalidPasswordAttempts > 5 && (time() - strtotime($client->updated_at)) < 7200) {
            throw eServiceError::getException(eServiceError::ClientInvalidPasswordAttemptsLimit);
        }

        if (empty($client->Token)) {
            $client->Token = $client->Username . "_" . md5(uniqid());
            $client->save();
        }
        return $client;
    }

    public static function buildAppleJSONReceiptObject($receipt, $password = NULL)
    {
        $preObject['receipt-data'] = $receipt;
        if ($password) {
            $preObject['password'] = $password;
        }
        return json_encode($preObject);
    }

    public static function makeAppleReceiptRequest($endpoint, $receiptObject)
    {
        $options = array();
        $options['http'] = array(
            'header' => "Content-type: application/x-www-form-urlencoded",
            'method' => 'POST',
            'content' => $receiptObject
        );

        // see: http://php.net/manual/en/function.stream-context-create.php
        $context = stream_context_create($options);
        // see: http://php.net/manual/en/function.file-get-contents.php
        $result = file_get_contents($endpoint, FALSE, $context);
        if ($result === FALSE) {
            throw new ServerErrorException('Error validating transaction.', 560);
        }
        // Decode json object (TRUE variable decodes as an associative array)
        return json_decode($result, TRUE);
    }

    public static function checkIosResponse($response)
    {
        if (!isset($response["receipt"])) {
            if (isset($response["status"])) {
                switch ($response["status"]) {
                    case 21000:
                        return 'The App Store could not read the JSON object you provided.';
                    case 21002:
                        return 'The App Store could not read the JSON object you provided.';
                    case 21003:
                        return 'The receipt could not be authenticated.';
                    case 21004:
                        return 'The shared secret you provided does not match the shared secret on file for your account.Only returned for iOS 6 style transaction receipts for auto-renewable subscriptions.';
                    case 21005:
                        return 'The receipt server is not currently available.';
                    case 21006:
                        return 'This receipt is valid but the subscription has expired.';
                    case 21007:
                        return 'This receipt is a sandbox receipt, but it was sent to the production server.';
                    case 21008:
                        return 'This receipt is a production receipt, but it was sent to the sandbox server.';
                    default:
                        return 'Receipt not set.';
                }
            }
            return 'Receipt not set.';
        } elseif (!isset($response["receipt"]["in_app"])) {
            return 'In-app not set.';
        } elseif (!isset($response["status"])) {
            return 'Response status not set';
        } elseif ($response["status"] != 0) {
            return 'Provided Receipt not valid.';
        } else {
            return null;
        }
    }

}
