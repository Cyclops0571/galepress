<?php

class Ws_v102_Applications_Controller extends Base_Controller {

	public $restful = true;

	public function get_version($applicationID) {
		return Ws::render(function() use ($applicationID) {
					$application = Ws::getApplication($applicationID);
					$customer = Ws::getCustomer($application->CustomerID);
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

	public function get_detail($applicationID) {
		return Ws::render(function() use ($applicationID) {
					$deviceType = Input::get('deviceType', 'ios');
					$deviceDetail = '';
					$osVersion = '';
					$appBuildVersion = '';
					/*
					  INFO: Force | guncellemeye zorlanip zorlanmayacagini selimin tablosundan sorgula!
					  0: Zorlama
					  1: Uyari goster
					  2: Zorla
					  3: Sil ve zorla
					 */

					$application = Ws::getApplication($applicationID);
					$application instanceof Application;
					$customer = Ws::getCustomer($application->CustomerID);

					//INFO:Save token method come from get_contents
					Ws::saveToken($customer->CustomerID, $applicationID);

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

	public function get_categories($applicationID) {
		return Ws::render(function() use ($applicationID) {
					$application = Ws::getApplication($applicationID);
					$customer = Ws::getCustomer($application->CustomerID);
					$categories = Ws::getApplicationCategories($applicationID);
					return Response::json(array(
								'status' => 0,
								'error' => "",
								'Categories' => $categories
					));
				});
	}

	//categoryID
	public function get_categoryDetail($applicationID, $categoryID) {
		return Ws::render(function() use ($applicationID, $categoryID) {
					Ws::getApplication($applicationID);
					Ws::getCustomer($application->CustomerID);
					$category = Ws::getApplicationCategoryDetail($applicationID, $categoryID);
					return Response::json(array(
								'status' => 0,
								'error' => "",
								'CategoryID' => (int) $category->CategoryID,
								'CategoryName' => $category->Name
					));
				});
	}

	public function get_contents($applicationID) {
		return Ws::render(function() use ($applicationID) {
					$isTest = Input::get('isTest', 0) ? TRUE : FALSE;
					$application = Ws::getApplication($applicationID);

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
					$tabs[] = array("tabLogoUrl" => $baseUrl . "img/galeLogo.png", "tabUrl" => $baseUrl . "/maps/webview/" . (int) $application->ApplicationID);
					$tabs[] = array("tabLogoUrl" => $baseUrl . "img/bg-drop.png", "tabUrl" => "http://www.google.com/");
					

					$contents = Ws::getApplicationContents($applicationID, $isTest);
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

	public function post_authorized_application_list() {
		return Ws::render(function() {
					$username = Input::get('username');
					$password = Input::get('password');
					$applicationSet = array();
					$userFacebookID = Input::get('userFacebookID');
					$userFbEmail = Input::get('userFbEmail');
					$user = null;
					$responseSet = array();
					if (!empty($username) || !empty($password)) {
						//username ve password login
						$user = User::where('Username', '=', $username)->where('StatusID', '=', eStatus::Active)->first();
						if (!$user) {
							throw new Exception("Hatalı kullanıcı bilgileri.", "140");
						}

						if (!Hash::check($password, $user->Password)) {
							throw new Exception("Hatalı kullanıcı bilgileri.", "140");
						}
					} else if (!empty($userFacebookID) || !empty($userFbEmail)) {
						//facebook login
						$user = User::where('FbUsername', '=', $userFacebookID)
										->where('FbEmail', '=', $userFbEmail)
										->where('StatusID', '=', eStatus::Active)->first();
						if (!$user) {
							throw new Exception(Config::get('custom.url') . " adresinden Facebook ile hesap oluşturmalısınız.", "141");
						}
					} else {
						throw new Exception("Hatalı kullanıcı bilgileri.", "140");
					}

					//We have a user now...
					if ($user->UserTypeID == eUserTypes::Customer) {
						if ($user->CustomerID == 0) {
							//Customer not exist
							throw new Exception("Hatalı kullanıcı bilgileri.", "140");
						}

						$applicationSet = Application::where('CustomerID', '=', $user->CustomerID)
								->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
								->where('StatusID', '=', eStatus::Active)
								->get();
					} else {
						//admin
						$applicationSet = Application::where('ExpirationDate', '>=', DB::raw('CURDATE()'))
								->where('StatusID', '=', eStatus::Active)
								->get();
					}

					foreach ($applicationSet as $application) {
						$application instanceof Application;
						$responseSet[] = array(
							'ApplicationID' => $application->ApplicationID,
							'Name' => $application->Name
						);
					}

					return Response::json($responseSet);
				});
	}

}
