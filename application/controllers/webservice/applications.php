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
	return webService::render(function() use ($ServiceVersion, $applicationID) {
		    $isTest = Input::get('isTest', 0) ? TRUE : FALSE;
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


		    $contents = webService::getCheckApplicationContents($ServiceVersion, $applicationID, $isTest);

		    return Response::json(array(
				'status' => 0,
				'error' => "",
				'ThemeBackground' => $application->ThemeBackground,
				'ThemeForeground' => $hexadecimalColorCode,
				'BannerActive' => $application->BannerActive,
				'BannerPage' => $baseUrl . "/banners/service_view/" . $application->ApplicationID . "?ver=" . $application->Version,
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

}
