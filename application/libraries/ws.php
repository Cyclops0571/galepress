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
				->order_by('MonthlyName', 'ASC')
				->order_by('Name', 'ASC')
				->get();
		}
		
		if($rs) {
			$contents = array();
			foreach($rs as $r)
			{
				if($r->PublishDate === '0000-00-00 00:00:00' || $r->PublishDate <= date("Y-m-d H:i:s"))
				{
					array_push($contents, array(
						'ContentID' => (int)$r->ContentID,
						'ContentName' => $r->Name,
						'ContentMonthlyName' => $r->MonthlyName,
						'ContentBlocked' => ((int)$r->Blocked == 1 ? true : false),
						'ContentStatus' => ((int)$r->Status == 1 ? true : false),
						'ContentVersion' => (int)$r->Version
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
		$deviceType = Input::get('deviceType', 'ios');
		$applicationToken = Input::get('applicationToken', '');
		$deviceToken = Input::get('deviceToken', '');

		//if(strlen($applicationToken) > 0 && strlen($deviceToken) > 0)
		if(strlen($deviceToken) > 0)
		{
			$cnt = Token::where('ApplicationToken', '=', $applicationToken)->where('DeviceToken', '=', $deviceToken)->count();
			if($cnt == 0) {
				$s = new Token();
				$s->CustomerID = (int)$customerID;
				$s->ApplicationID = (int)$applicationID;
				$s->ApplicationToken = $applicationToken;
				$s->DeviceToken = $deviceToken;
				$s->DeviceType = $deviceType;
				$s->save();
			}
		}
	}
}