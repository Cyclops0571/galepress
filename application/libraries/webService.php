<?php

class webService {

    /**
     * If there is a exception then catches it and returns a valid Response else returns what the Closure returns
     * @param Closure $cb
     * @return Laravel\Response
     */
    public static function render(Closure $cb) {
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
    public static function getCheckCustomer($ServiceVersion, $customerID) {
	$customer = Customer::where('CustomerID', '=', $customerID)->where('StatusID', '=', eStatus::Active)->first();
	if (!$customer) {
	    throw eServiceError::getException(eServiceError::UserNotFound);
	}
	return $customer;
    }

    /**
     * 
     * @param type $ServiceVersion
     * @param type $applicationID
     * @return Application
     * @throws Exception
     */
    public static function getCheckApplication($ServiceVersion, $applicationID) {
	$application = Application::where('ApplicationID', '=', $applicationID)->where('StatusID', '=', eStatus::Active)->first();
	if (!$application) {
	    throw eServiceError::getException(eServiceError::ApplicationNotFound);
	}
	if (!($application->ExpirationDate >= date("Y-m-d H:i:s") && (int) $application->Blocked == 0 && (int) $application->Status == 1)) {
	    throw eServiceError::getException(eServiceError::PassiveApplication);
	}
	return $application;
    }

    public static function getCheckApplicationCategories($ServiceVersion, $applicationID) {
	$categories = array();
	//add general
	array_push($categories, array(
	    'CategoryID' => 0,
	    'CategoryName' => 'Genel'
	));
	$rs = Category::where('ApplicationID', '=', $applicationID)->where('StatusID', '=', eStatus::Active)->order_by('Name', 'ASC')->get();
	foreach ($rs as $r) {
	    array_push($categories, array(
		'CategoryID' => (int) $r->CategoryID,
		'CategoryName' => $r->Name
	    ));
	}
	return $categories;
    }

    public static function getCheckApplicationCategoryDetail($ServiceVersion, $applicationID, $categoryID) {
	$category = Category::where('CategoryID', '=', $categoryID)
			->where('ApplicationID', '=', $applicationID)
			->where('StatusID', '=', eStatus::Active)->first();
	if (!$category) {
	    throw eServiceError::getException(eServiceError::CategoryNotFound);
	}
	return $category;
    }

    public static function getCheckApplicationContents($ServiceVersion, $applicationID, $isTest = False) {
	$query = Content::where('ApplicationID', '=', $applicationID)
		->where('StatusID', '=', eStatus::Active)
		->order_by('OrderNo', 'DESC')
		->order_by('MonthlyName', 'ASC')
		->order_by('Name', 'ASC');
	if (!$isTest) {
	    $query->where(function($q) {
		$q->where('Status', '=', eStatus::Active);
		$q->or_where("RemoveFromMobile", "=", eRemoveFromMobile::Active);
	    });
	}

	$categoryID = (int) Input::get('categoryID', '-1');
	if ($categoryID !== -1) {
	    $rs = $query->where('ContentID', 'IN', DB::raw('(SELECT ContentID FROM ContentCategory WHERE CategoryID=' . (int) $categoryID . ')'));
	}

	$rs = $query->get();
//        var_dump(DB::last_query()) ; exit;
//        var_dump($rs); exit;
	if ($rs) {
	    $contents = array();
	    foreach ($rs as $r) {
		$r instanceof Content;
		$serveContent = $r->PublishDate <= date("Y-m-d H:i:s");
		$serveContent = $serveContent && ($r->IsUnpublishActive == 0 || $r->UnpublishDate > date("Y-m-d"));
		$serveContent = $serveContent || ($r->RemoveFromMobile == eRemoveFromMobile::Active);
		if ($serveContent) {
		    array_push($contents, array(
			'ContentID' => (int) $r->ContentID,
			'ContentName' => $r->Name,
			'ContentMonthlyName' => $r->MonthlyName,
			'ContentIsMaster' => (bool) $r->IsMaster,
			'ContentOrientation' => (int) $r->Orientation,
			'ContentBlocked' => (bool) $r->Blocked,
			'ContentStatus' => (bool) $r->Status,
			'ContentVersion' => (int) $r->Version,
			'ContentOrderNo' => (int) $r->OrderNo,
			'RemoveFromMobile' => (bool) $r->RemoveFromMobile,
			'ContentIsBuyable' => (bool) $r->IsBuyable,
			'ContentPrice' => $r->Price,
			'ContentCurrency' => $r->Currency(1),
			'ContentIdentifier' => $r->getIdentifier(),
		    ));
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
    public static function getCheckContent($ServiceVersion, $contentID) {
	$content = Content::where('ContentID', '=', $contentID)
		->where(function($q) {
		    $q->where('StatusID', '=', eStatus::Active);
		    $q->or_where("RemoveFromMobile", "=", eRemoveFromMobile::Active);
		})
		->first();

	if (!$content) {
	    throw eServiceError::getException(eServiceError::ContentNotFound);
	}
	if (!((int) $content->Blocked == 0)) {
	    throw eServiceError::getException(eServiceError::ContentBlocked);
	}
	return $content;
    }

    public static function getContentCategories($ServiceVersion, $contentID) {
	$categories = array();
	$sql = '' .
		'SELECT ct.CategoryID, ct.Name ' .
		'FROM `ContentCategory` cc ' .
		'LEFT OUTER JOIN `Category` ct ON cc.`CategoryID` = ct.`CategoryID` AND ct.`StatusID` = 1 ' .
		'WHERE cc.`ContentID`=' . (int) $contentID . ' ' .
		'ORDER BY ct.`Name` ASC';
	$rs = DB::query($sql);
	foreach ($rs as $r) {
	    array_push($categories, array(
		'CategoryID' => (int) $r->CategoryID,
		'CategoryName' => ((int) $r->CategoryID === 0 ? 'Genel' : $r->Name)
	    ));
	}
	return $categories;
    }

    // Check User credential
    public static function checkUserCredential($ServiceVersion, $customerID) {
	$username = Input::get('username', '');
	$password = Input::get('password', '');
	$user = null;
	if (strlen($username) > 0) {
	    $user = User::where('CustomerID', '=', (int) $customerID)->where('Username', '=', $username)->where('StatusID', '=', eStatus::Active)->first();
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
    public static function saveToken($ServiceVersion, $customerID, $applicationID) {
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
		$token->CustomerID = (int) $customerID;
		$token->ApplicationID = (int) $applicationID;
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
     * @param type $userFacebookID
     * @param type $userFbEmail
     * @return User
     * @throws Exception
     */
    public static function getCheckUser($ServiceVersion, $applicationID, $username, $password, $userFacebookID, $userFbEmail) {
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
    public static function getCheckClient($serviceVersion, $applicationID, $username, $password) {
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

	if(empty($client->Token)) {
	    $client->Token = $client->Username . "_" . md5(uniqid());
	    $client->save();
	}
	return $client;
    }

}
