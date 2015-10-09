<?php

class Webservice_Applications_Controller extends Base_Controller {

    public static $availableServices = array(103);
    public $restful = true;

    public static function checkServiceVersion($ServiceVersion) {
	if (!in_array($ServiceVersion, self::$availableServices)) {
	    throw eServiceError::getException(eServiceError::ServiceNotFound);
	}
    }

    /**
     * 
     * @param type $ServiceVersion
     * @param type $applicationID
     * @return Laravel\Response
     */
    public function get_version($ServiceVersion, $applicationID) {
	return webService::render(function() use ($ServiceVersion, $applicationID) {
		    Webservice_Applications_Controller::checkServiceVersion($ServiceVersion);
		    $application = webService::getCheckApplication($ServiceVersion, $applicationID);
		    return Response::json(array(
				'status' => 0,
				'error' => "",
				'ApplicationID' => (int) $application->ApplicationID,
				'ApplicationBlocked' => ((int) $application->Blocked == 1 ? true : false),
				'ApplicationStatus' => ((int) $application->Status == 1 ? true : false),
				'ApplicationVersion' => (int) $application->Version
		    ));
		});
    }

    /**
     * Control for force update of application
     * @param type $ServiceVersion
     * @param type $applicationID
     * @return Laravel\Response
     */
    public function get_detail($ServiceVersion, $applicationID) {
	return webService::render(function() use ($ServiceVersion, $applicationID) {
		    /*
		      INFO: Force | guncellemeye zorlanip zorlanmayacagini selimin tablosundan sorgula!
		      0: Zorlama
		      1: Uyari goster
		      2: Zorla
		      3: Sil ve zorla
		     */
		    Webservice_Applications_Controller::checkServiceVersion($ServiceVersion);
		    /* @var $application Application */
		    $application = webService::getCheckApplication($ServiceVersion, $applicationID);
		    $customer = webService::getCheckCustomer($ServiceVersion, $application->CustomerID);

		    //INFO:Save token method come from get_contents
		    webService::saveToken($ServiceVersion, $customer->CustomerID, $applicationID);

		    return Response::json(array(
				'status' => 0,
				'error' => "",
				'CustomerID' => (int) $customer->CustomerID,
				'CustomerName' => $customer->CustomerName,
				'ApplicationID' => (int) $application->ApplicationID,
				'ApplicationName' => $application->Name,
				'ApplicationDetail' => $application->Detail,
				'ApplicationExpirationDate' => $application->ExpirationDate,
				'IOSVersion' => $application->IOSVersion,
				'IOSLink' => $application->IOSLink,
				'AndroidVersion' => $application->AndroidVersion,
				'AndroidLink' => $application->AndroidLink,
				'PackageID' => $application->PackageID,
				'ApplicationBlocked' => ((int) $application->Blocked == 1 ? true : false),
				'ApplicationStatus' => ((int) $application->Status == 1 ? true : false),
				'ApplicationVersion' => (int) $application->Version,
				'Force' => (int) $application->Force,
				'SubscriptionWeekActive' => (int) $application->SubscriptionWeekActive,
				'SubscriptionWeekIdentifier' => $application->SubscriptionIdentifier(Subscription::week),
				'SubscriptionMonthActive' => (int) $application->SubscriptionMonthActive,
				'SubscriptionMonthIdentifier' => $application->SubscriptionIdentifier(Subscription::mounth),
				'SubscriptionYearActive' => (int) $application->SubscriptionYearActive,
				'SubscriptionYearIdentifier' => $application->SubscriptionIdentifier(Subscription::year),
		    ));
		});
    }

    /**
     * 
     * @param type $ServiceVersion
     * @param type $applicationID
     * @return Laravel\Response
     */
    public function get_categories($ServiceVersion, $applicationID) {
	return webService::render(function() use ($ServiceVersion, $applicationID) {
		    Webservice_Applications_Controller::checkServiceVersion($ServiceVersion);
		    webService::getCheckApplication($ServiceVersion, $applicationID);
		    $categories = webService::getCheckApplicationCategories($ServiceVersion, $applicationID);
		    return Response::json(array(
				'status' => 0,
				'error' => "",
				'Categories' => $categories
		    ));
		});
    }

    /**
     * 
     * @param type $ServiceVersion
     * @param type $applicationID
     * @param type $categoryID
     * @return Laravel\Response
     */
    public function get_categoryDetail($ServiceVersion, $applicationID, $categoryID) {
	return webService::render(function() use ($ServiceVersion, $applicationID, $categoryID) {
		    Webservice_Applications_Controller::checkServiceVersion($ServiceVersion);
		    webService::getCheckApplication($ServiceVersion, $applicationID);
		    $category = webService::getCheckApplicationCategoryDetail($ServiceVersion, $applicationID, $categoryID);
		    return Response::json(array(
				'status' => 0,
				'error' => "",
				'CategoryID' => (int) $category->CategoryID,
				'CategoryName' => $category->Name
		    ));
		});
    }

    /**
     * 
     * @param type $ServiceVersion
     * @param type $applicationID
     * @return Laravel\Response
     */
    public function get_contents($ServiceVersion, $applicationID) {
	//get user token here then return acourdin to this 571571
	return webService::render(function() use ($ServiceVersion, $applicationID) {
		    $isTest = Input::get('isTest', 0) ? TRUE : FALSE;
		    $accessToken = Input::get('accessToken', "");
		    Webservice_Applications_Controller::checkServiceVersion($ServiceVersion);
		    $application = webService::getCheckApplication($ServiceVersion, $applicationID);

		    switch ($application->ThemeForeground) {
			case 2:
			    $hexadecimalColorCode = "#00A388";
			    break;
			case 3:
			    $hexadecimalColorCode = "#E2B705";
			    break;
			case 4:
			    $hexadecimalColorCode = "#AB2626";
			    break;
			case 5:
			    $hexadecimalColorCode = "#E74C3C";
			    break;
			default:
			    $hexadecimalColorCode = "#2980B9";
		    }
		    $baseUrl = Config::get('custom.url');
		    $tabs = array();
		    $tabs[] = array("tabLogoUrl" => $baseUrl . "img/galeLogo.png", "tabUrl" => $baseUrl . "/maps/webview/" . $application->ApplicationID);
		    $tabs[] = array("tabLogoUrl" => $baseUrl . "img/bg-drop.png", "tabUrl" => "http://www.google.com/");

		    $serviceData = array();
		    $serviceData["ServiceVersion"] = $ServiceVersion;
		    $serviceData["applicationID"] = $applicationID;
		    $serviceData["isTest"] = $isTest;
		    $serviceData["accessToken"] = $accessToken;
		    $contents = webService::getCheckApplicationContents($serviceData);

		    return Response::json(array(
				'status' => 0,
				'error' => "",
				'ThemeBackground' => $application->ThemeBackground,
				'ThemeForeground' => $hexadecimalColorCode,
				'BannerActive' => $application->BannerActive,
				'BannerPage' => $application->BannerPage(),
				'Tabs' => $application->TabsForService(),
				'Contents' => $contents
		    ));
		});
    }

    /**
     * This function is used for Gp Viewer Application
     * Other Applications dont use this function
     * @param type $ServiceVersion
     * @return type
     */
    public function post_authorized_application_list($ServiceVersion) {
	return webService::render(function() use ($ServiceVersion) {
		    Webservice_Applications_Controller::checkServiceVersion($ServiceVersion);
		    $username = Input::get('username');
		    $password = Input::get('password');
		    $applicationSet = array();
		    $userFacebookID = Input::get('userFacebookID');
		    $userFbEmail = Input::get('userFbEmail');
		    $responseSet = array();
		    $user = webService::getCheckUser($ServiceVersion, $username, $password, $userFacebookID, $userFbEmail);

		    //We have a user now...
		    if ($user->UserTypeID == eUserTypes::Customer) {
			$applicationSet = Application::where('CustomerID', '=', $user->CustomerID)
				->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
				->where('StatusID', '=', eStatus::Active)
				->get();
		    } else if ($user->UserTypeID == eUserTypes::Manager) {
			//admin
			$applicationSet = Application::where('ExpirationDate', '>=', DB::raw('CURDATE()'))
				->where('StatusID', '=', eStatus::Active)
				->get();
		    }

		    foreach ($applicationSet as $application) {
			$responseSet[] = array(
			    'ApplicationID' => $application->ApplicationID,
			    'Name' => $application->Name
			);
		    }

		    return Response::json($responseSet);
		});
    }

    /**
     * Authenticate the client to the application
     * @param type $ServiceVersion
     * @return Laravel\Response
     */
    public function post_login_application($ServiceVersion) {
	return webService::render(function() use ($ServiceVersion) {
		    $applicationID = Laravel\Input::get("applicationID");
		    $username = Laravel\Input::get("username");
		    $password = Laravel\Input::get("password");

		    Webservice_Applications_Controller::checkServiceVersion($ServiceVersion);
		    webService::getCheckApplication($ServiceVersion, $applicationID);
		    $client = webService::getCheckClient($ServiceVersion, $applicationID, $username, $password);

		    if (!$client) {
			return FALSE;
		    }

		    $result = array();
		    $result['accessToken'] = $client->Token;
		    return Laravel\Response::json($result);
		}
	);
    }

    public function post_fblogin($ServiceVersion) {
	return webService::render(function() use ($ServiceVersion) {
		    /* @var $client Client */
		    $rules = array(
			'clientLanguage' => 'required|in:' . implode(",", Laravel\Config::get("application.languages")),
			'applicationID' => 'required|integer',
			'facebookToken' => 'required',
			'facebookUserId' => 'required',
			'facebookEmail' => 'required|email',
			'name' => 'required',
			'surname' => 'required',
		    );


		    $v = Laravel\Validator::make(\Laravel\Input::all(), $rules);
		    if ($v->invalid()) {
			throw eServiceError::getException(eServiceError::GenericError, $v->errors->first());
		    }

		    $applicationID = Laravel\Input::get("applicationID");
		    $facebookToken = Laravel\Input::get("facebookToken");
		    $facebookUserId = Laravel\Input::get("facebookUserId");
		    $facebookEmail = Laravel\Input::get("facebookEmail");
		    $name = Laravel\Input::get("name");
		    Laravel\Config::set("application.language", Laravel\Input::get("clientLanguage"));
		    $surname = Laravel\Input::get("surname");
		    Webservice_Applications_Controller::checkServiceVersion($ServiceVersion);
		    webService::getCheckApplication($ServiceVersion, $applicationID);
		    $client = Client::where("ApplicationID", "=", $applicationID)
				    ->where("StatusID", "=", eStatus::Active)
				    ->where("Email", "=", $facebookEmail)->first();
		    if ($client) {
			$result = array();
			$result['accessToken'] = $client->Token;
			return Laravel\Response::json($result);
		    }

		    $flag = TRUE;
		    $userNo = "";
		    do {

			$username = Laravel\Str::ascii($name . $surname . $userNo);
			$clientExists = Client::where("Username", "=", $username)
				->where("ApplicationID", "=", $applicationID)
				->first();
			if (!$clientExists) {
			    //register client
			    $flag = FALSE;
			    $password = Common::generatePassword();
			    $clientNew = new Client();
			    $clientNew->Password = $password;
			    $clientNew->Token = $username . "_" . md5(uniqid());
			    $clientNew->StatusID = eStatus::Active;
			    $clientNew->CreatorUserID = 0;
			    $clientNew->Username = $username;
			    $clientNew->Email = $facebookEmail;
			    $clientNew->ApplicationID = $applicationID;
			    $clientNew->Name = $name;
			    $clientNew->Surname = $surname;
			    $clientNew->save();
			    $application = Application::find($applicationID);
			    //send mail to client
			    $subject = __('clients.registered_email_subject', array('Application' => $application->Name));
			    $msg = __('clients.registered_email_message', array(
				'Application' => $application->Name,
				'firstname' => $clientNew->Name,
				'lastname' => $clientNew->Surname,
				'username' => $clientNew->Username,
				'pass' => $password
				    )
			    );
			    
			    Common::sendEmail($clientNew->Email, $clientNew->Name . ' ' . $clientNew->Surname, $subject, $msg);
			} else {
			    $userNo = 1 + (int) $userNo;
			}
		    } while ($flag);

		    $result = array();
		    $result['accessToken'] = $clientNew->Token;
		    return Laravel\Response::json($result);
		});
    }

}
