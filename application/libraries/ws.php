<?php

class Ws
{

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

    /**
     *
     * @param int $customerID
     * @return Customer
     * @throws Exception
     */
    public static function getCustomer($customerID)
    {
        $customer = Customer::where('CustomerID', '=', $customerID)->where('StatusID', '=', eStatus::Active)->first();
        if (!$customer) {
            throw eServiceError::getException(eServiceError::UserNotFound);
        }
        return $customer;
    }

    /**
     *
     * @param int $applicationID
     * @return Application
     * @throws Exception
     */
    public static function getApplication($applicationID)
    {
        $application = Application::where('ApplicationID', '=', $applicationID)->where('StatusID', '=', eStatus::Active)->first();
        if (!$application) {
            throw eServiceError::getException(eServiceError::ApplicationNotFound);
        }
        if (!($application->ExpirationDate >= date("Y-m-d H:i:s") && (int)$application->Blocked == 0 && (int)$application->Status == eStatus::Active)) {
            throw eServiceError::getException(eServiceError::PassiveApplication);
        }
        return $application;
    }

    public static function getApplicationCategoryDetail($applicationID, $categoryID)
    {
        $categories = Category::where('CategoryID', '=', $categoryID)
            ->where('ApplicationID', '=', $applicationID)
            ->where('StatusID', '=', eStatus::Active)->first();
        if (!$categories) {
            throw eServiceError::getException(eServiceError::CategoryNotFound);
        }

        return $categories;
    }

    public static function getApplicationContents($applicationID, $isTest = False)
    {
        $query = Content::where('ApplicationID', '=', $applicationID)
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

        $rs = $query->get();
        /** @var Content[] $rs */
        if ($rs) {
            $contents = array();
            foreach ($rs as $r) {
                if ($r->serveContent()) {
                    array_push($contents, $r->getServiceData());
                }
            }
            return $contents;
        }
        throw eServiceError::getException(eServiceError::ContentNotFound);
    }

    /**
     * RemoveFromMobilei aktif olanlari veya StatusID eStatus::Active olanlari doner.
     * @param int $contentID
     * @return Content
     * @throws Exception
     */
    public static function getContent($contentID, $serviceVersion = 0)
    {
        if ($serviceVersion >= 102) {
            $content = Content::where('ContentID', '=', $contentID)
                ->where(function ($q) {
                    $q->where('StatusID', '=', eStatus::Active);
                    $q->or_where("RemoveFromMobile", "=", eRemoveFromMobile::Active);
                })
                ->first();
        } else {
            $content = Content::where('ContentID', '=', $contentID)
                ->where('StatusID', '=', eStatus::Active)
                ->first();
        }

        if (!$content) {
            throw eServiceError::getException(eServiceError::ContentNotFound);
        }
        if ((int)$content->Blocked != 0) {
            throw eServiceError::getException(eServiceError::ContentBlocked);
        }
        return $content;
    }

    // Check User credential
    public static function checkUserCredential($customerID)
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

    // Save token
    public static function saveToken($customerID, $applicationID)
    {
        $UDID = Input::get('udid', '');
        $applicationToken = Input::get('applicationToken', '');
        $deviceToken = Input::get('deviceToken', '');
        $deviceType = Input::get('deviceType', 'ios');

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
    }

    /**
     *
     * @param type $serviceVersion
     * @param type $applicationID
     * @param type $username
     * @param type $password
     * @return Client
     */
    public static function getClient($serviceVersion, $applicationID, $username, $password)
    {
        return Client::where("Username", '=', $username)
            ->where('Password', '=', $password)
            ->where('ApplicationID', '=', $applicationID)
            ->where('StatusID', '=', eStatus::Active)
            ->first();
    }

}
