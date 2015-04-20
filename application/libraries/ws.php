<?php

class Ws
{
	// Global
	public static function render(Closure $cb)
	{
		try {
			//return $cb();
			return call_user_func($cb);
		}
		catch (Exception $e) {
			return Response::json(array(
				'status' => $e->getCode(),
				'error' => $e->getMessage()
			));
		}
	}

	// Customer
	public static function getCustomer($customerID)
	{
		$customer = Customer::where('CustomerID', '=', $customerID)->where('StatusID', '=', eStatus::Active)->first();
		if(!$customer) {
			throw new Exception("Müşteri bulunamadı.", "120");
		}
		return $customer;
	}

	// Application
	public static function getApplication($applicationID)
	{
		$application = Application::where('ApplicationID', '=', $applicationID)->where('StatusID', '=', eStatus::Active)->first();
		if(!$application) {
			throw new Exception("Uygulama bulunamadı.", "130");
		}
		if(!($application->ExpirationDate >= date("Y-m-d H:i:s") && (int)$application->Blocked == 0 && (int)$application->Status == 1)) {
			throw new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", "131");
		}
		return $application;
	}

	public static function getApplicationCategories($applicationID)
	{
		$categories = array();
		//add general
		array_push($categories, array(
			'CategoryID' => 0,
			'CategoryName' => 'Genel'
		));
		$rs = Category::where('ApplicationID', '=', $applicationID)->where('StatusID', '=', eStatus::Active)->order_by('Name', 'ASC')->get();
		foreach($rs as $r) {
			array_push($categories, array(
				'CategoryID' => (int)$r->CategoryID,
				'CategoryName' => $r->Name
			));
		}
		return $categories;
	}

	public static function getApplicationCategoryDetail($applicationID, $categoryID)
	{
		$category = Category::where('CategoryID', '=', $categoryID)->where('ApplicationID', '=', $applicationID)->where('StatusID', '=', eStatus::Active)->first();
		if(!$category) {
			throw new Exception("Kategori bulunamadı.", "140");
		}
		return $category;
	}

	public static function getApplicationContents($applicationID)
	{
		$rs = Content::where('ApplicationID', '=', $applicationID)->where('StatusID', '=', eStatus::Active)->order_by('MonthlyName', 'ASC')->order_by('Name', 'ASC')->get();
		
		$categoryID = (int)Input::get('categoryID', '-1');
		if($categoryID !== -1) {
			$rs = Content::where('ApplicationID', '=', $applicationID)
				->where('ContentID', 'IN', DB::raw('(SELECT ContentID FROM ContentCategory WHERE CategoryID='.(int)$categoryID.')'))
				->where('StatusID', '=', eStatus::Active)
				->order_by('OrderNo', 'DESC')
				->order_by('MonthlyName', 'ASC')
				->order_by('Name', 'ASC')
				->get();
		}
		
		if($rs) {
			$contents = array();
			foreach($rs as $r)
			{
				$serveContent = $r->PublishDate <= date("Y-m-d H:i:s");
				$serveContent = $serveContent && ($r->IsUnpublishActive ==0 || $r->UnpublishDate > date("Y-m-d"));
				if($serveContent)
				{
					array_push($contents, array(
						'ContentID' => (int)$r->ContentID,
						'ContentName' => $r->Name,
						'ContentMonthlyName' => $r->MonthlyName,
						'ContentIsMaster' => ((int)$r->IsMaster == 1 ? true : false),
						'ContentOrientation' => (int)$r->Orientation,
						'ContentBlocked' => ((int)$r->Blocked == 1 ? true : false),
						'ContentStatus' => ((int)$r->Status == 1 ? true : false),
						'ContentVersion' => (int)$r->Version,
						'ContentOrderNo' => (int) $r->OrderNo
					));
				}
			}
			return $contents;
		}
		throw new Exception("İçerik bulunamadı.", "102");
	}

	// Content
	public static function getContent($contentID)
	{
		$content = Content::where('ContentID', '=', $contentID)->where('StatusID', '=', eStatus::Active)->first();
		if(!$content) {
			throw new Exception("İçerik bulunamadı.", "102");
		}
		if(!((int)$content->Blocked == 0)) {
			throw new Exception("İçerik engellenmiş.", "103");
		}
		return $content;
	}

	public static function getContentCategories($contentID)
	{
		$categories = array();
		$sql = ''.
			'SELECT ct.CategoryID, ct.Name '.
			'FROM `ContentCategory` cc '.
				'LEFT OUTER JOIN `Category` ct ON cc.`CategoryID` = ct.`CategoryID` AND ct.`StatusID` = 1 '.
			'WHERE cc.`ContentID`='.(int)$contentID.' '.
			'ORDER BY ct.`Name` ASC';
		$rs = DB::query($sql);
		foreach($rs as $r) {
			array_push($categories, array(
				'CategoryID' => (int)$r->CategoryID,
				'CategoryName' => ((int)$r->CategoryID === 0 ? 'Genel' : $r->Name)
			));
		}
		return $categories;
	}

	// Check User credential
	public static function checkUserCredential($customerID) 
	{
		$username = Input::get('username', '');
		$password = Input::get('password', '');

		if(strlen($username) > 0)
		{
			$user = User::where('CustomerID', '=', (int)$customerID)->where('Username', '=', $username)->where('StatusID', '=', eStatus::Active)->first();
			if(!$user) {
				throw new Exception("Hatalı kullanıcı bilgileri.", "140");
			}

			if(!(crypt($password, $user->Password) === $user->Password))
			{
				throw new Exception("Hatalı kullanıcı bilgileri.", "140");
			}
		}
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
		if(strlen($deviceToken) > 0)
		{
			if($deviceType == eDeviceType::android && !empty($UDID)) {
				$token = Token::where('ApplicationID', '=', $applicationID)
						->where('UDID', '=', $UDID)
						->first();
				if($token) {
					//eski android uygulamasi tekrardan geldi deviceTokeni guncelleyelim.
					$token->DeviceToken = $deviceToken;
				} 				
			} else {
				$token = Token::where('ApplicationToken', '=', $applicationToken)->where('DeviceToken', '=', $deviceToken)->first();
				if($token) {
					//INFO:Added due to https://github.com/galepress/gp/issues/2
					//Emre, Eger token tablosuna getAppDetail'den gelen bir deviceToken kaydedildiyse ayni deviceToken'ile baska insert yapilmiyor. 
					//Fakat soyle bir durum soz konusu. Benim deviceToken'im kaydedildi ama daha sonra yeni update ile udid'lerde geliyor. 
					//deviceToken tabloda varsa udid'sini update etmesi lazim. Yoksa udid eklemememizin bir manasi olmayacak. 
					//bir cihaza uygualma bir kez kurulduysa hic udid'sini alamayiz.
					$token->UDID = $UDID;
					
				}
			}
			if(empty($token)) {
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
}