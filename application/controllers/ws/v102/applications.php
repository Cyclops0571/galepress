<?php

class Ws_v102_Applications_Controller extends Base_Controller
{
	public $restful = true;

	public function get_version($applicationID)
	{
		return Ws::render(function() use ($applicationID)
		{
			$application = Ws::getApplication($applicationID);
			$customer = Ws::getCustomer($application->CustomerID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'ApplicationID' => (int)$application->ApplicationID,
				'ApplicationBlocked' => ((int)$application->Blocked == 1 ? true : false),
				'ApplicationStatus' => ((int)$application->Status == 1 ? true : false),
				'ApplicationVersion' => (int)$application->Version
			));
		});
	}

	public function get_detail($applicationID)
	{
		return Ws::render(function() use ($applicationID)
		{
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
				'CustomerID' => (int)$customer->CustomerID,
				'CustomerName' => $customer->CustomerName,
				'ApplicationID' => (int)$application->ApplicationID,
				'ApplicationName' => $application->Name,
				'ApplicationDetail' => $application->Detail,
				'ApplicationExpirationDate' => $application->ExpirationDate,
				'IOSVersion' => $application->IOSVersion,
				'IOSLink' => $application->IOSLink,
				'AndroidVersion' => $application->AndroidVersion,
				'AndroidLink' => $application->AndroidLink,
				'PackageID' => $application->PackageID,
				'ApplicationBlocked' => ((int)$application->Blocked == 1 ? true : false),
				'ApplicationStatus' => ((int)$application->Status == 1 ? true : false),
				'ApplicationVersion' => (int)$application->Version,
				'Force' => (int)$application->Force,
				'MapService' => '/maps/webview/' . (int)$application->ApplicationID,
			));
		});
	}

	public function get_categories($applicationID)
	{
		return Ws::render(function() use ($applicationID)
		{
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
	public function get_categoryDetail($applicationID, $categoryID)
	{
		return Ws::render(function() use ($applicationID, $categoryID)
		{
			$application = Ws::getApplication($applicationID);
			$customer = Ws::getCustomer($application->CustomerID);
			$category = Ws::getApplicationCategoryDetail($applicationID, $categoryID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'CategoryID' => (int)$category->CategoryID,
				'CategoryName' => $category->Name
			));
		});
	}

	public function get_contents($applicationID)
	{
		return Ws::render(function() use ($applicationID)
		{
			$application = Ws::getApplication($applicationID);
			$customer = Ws::getCustomer($application->CustomerID);
			
			Ws::checkUserCredential($customer->CustomerID);
			//INFO:Save token method moved to get_detail
			//Ws::saveToken($customer->CustomerID, $applicationID);
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
			
			$contents = Ws::getApplicationContents($applicationID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'ThemeBackground' => $application->ThemeBackground,
				'ThemeForeground' => $hexadecimalColorCode,
				'Contents' => $contents
			));
		});
	}
}