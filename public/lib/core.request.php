<?php
////////////////////////////////////////////////////////////////////////////////////////////////
// Request
////////////////////////////////////////////////////////////////////////////////////////////////
function request($url, $default, $post = false, $postData = array()) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, WS_URL.$url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	if($post) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));	
	}
	$data = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($data);
	if((int)$json->status !== 0) {
		throw new Exception($json->error, $json->status);
	}
	$ret = json_decode($data, true);

	//Add item to array if doesnt exist
	foreach ($default as $k => $v) {
		if(!array_key_exists($k, $ret)) {
			$ret[$k] = $v;
		}
	}
	//Remove item if doesnt exist in default values
	foreach ($ret as $k => $v) {
		if(!array_key_exists($k, $default)) {
			unset($ret[$k]);
		}
	}
	return $ret;
}

function getApplicationID($categoryID) {
	$result = "";
	$rc = 0;
	$applicationID = 0;
	$sql = "SELECT `ApplicationID` FROM `Category` WHERE `CategoryID`=".mysql_real_escape_string((int)$categoryID);
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$applicationID = (int)$row["ApplicationID"];
	}
	return $applicationID;
}

/*
function request_GetAppVersion($cApplicationID) {

	$result = "";
	$rc = 0;
	
	$Customer_ID = "";
	$Customer_Name = "";
	
	$Application_ID = "";
	$Application_Name = "";
	$Application_Detail = "";
	$Application_ExpirationDate = "";
	$Application_Blocked = "";
	$Application_Status = "";
	$Application_Version = "";
	
	$sql = "SELECT * FROM `Customer` WHERE `CustomerID` IN (SELECT `CustomerID` FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1) AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Customer_ID = $row["CustomerID"];
		$Customer_Name = $row["CustomerName"];
	}
	else {
		throw new Exception("Müşteri bulunamadı.", "120");
	}
	
	$sql = "SELECT * FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Application_ID = $row["ApplicationID"];
		$Application_Name = $row["Name"];
		$Application_Detail = $row["Detail"];
		$Application_ExpirationDate = $row["ExpirationDate"];
		$Application_Blocked = $row["Blocked"];
		$Application_Status = $row["Status"];
		$Application_Version = $row["Version"];
	}
	else {
		throw new Exception("Uygulama bulunamadı.", "130");
	}
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	if($Application_ExpirationDate>=date("Y-m-d H:i:s") && (int)$Application_Blocked == 0 && (int)$Application_Status == 1) {
		
		$ret = array(
			'status' => 0,
			'error' => "",
			'ApplicationID' => (int)$Application_ID,
			'ApplicationBlocked' => ((int)$Application_Blocked == 1 ? true : false),
			'ApplicationStatus' => ((int)$Application_Status == 1 ? true : false),
			'ApplicationVersion' => (int)$Application_Version
		);
	}
	else {
		throw new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", "131");
	}
	return $ret;
}

function request_GetAppDetail($cApplicationID) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Customer_ID = "";
	$Customer_Name = "";
	
	$Application_ID = "";
	$Application_Name = "";
	$Application_Detail = "";
	$Application_ExpirationDate = "";
	$Application_Blocked = "";
	$Application_Status = "";
	$Application_Version = "";
	
	$sql = "SELECT * FROM `Customer` WHERE `CustomerID` IN (SELECT `CustomerID` FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1) AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Customer_ID = $row["CustomerID"];
		$Customer_Name = $row["CustomerName"];
	}
	else {
		throw new Exception("Müşteri bulunamadı.", "120");
	}
	
	$sql = "SELECT * FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Application_ID = $row["ApplicationID"];
		$Application_Name = $row["Name"];
		$Application_Detail = $row["Detail"];
		$Application_ExpirationDate = $row["ExpirationDate"];
		$Application_Blocked = $row["Blocked"];
		$Application_Status = $row["Status"];
		$Application_Version = $row["Version"];
	}
	else {
		throw new Exception("Uygulama bulunamadı.", "130");
	}
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	if($Application_ExpirationDate>=date("Y-m-d H:i:s") && (int)$Application_Blocked == 0 && (int)$Application_Status == 1) {
		
		$ret = array(
			'status' => 0,
			'error' => "",
			'CustomerID' => (int)$Customer_ID,
			'CustomerName' => $Customer_Name,
			'ApplicationID' => (int)$Application_ID,
			'ApplicationName' => $Application_Name,
			'ApplicationDetail' => $Application_Detail,
			'ApplicationExpirationDate' => $Application_ExpirationDate,
			'ApplicationBlocked' => ((int)$Application_Blocked == 1 ? true : false),
			'ApplicationStatus' => ((int)$Application_Status == 1 ? true : false),
			'ApplicationVersion' => (int)$Application_Version
		);
	}
	else {
		throw new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", "131");
	}
	return $ret;
}

function request_GetAppCategories($cApplicationID) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Customer_ID = "";
	$Customer_Name = "";
	
	$Application_ID = "";
	$Application_Name = "";
	$Application_Detail = "";
	$Application_ExpirationDate = "";
	$Application_Blocked = "";
	$Application_Status = "";
	$Application_Version = "";
	
	$sql = "SELECT * FROM `Customer` WHERE `CustomerID` IN (SELECT `CustomerID` FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1) AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Customer_ID = $row["CustomerID"];
		$Customer_Name = $row["CustomerName"];
	}
	else {
		throw new Exception("Müşteri bulunamadı.", "120");
	}
	
	$sql = "SELECT * FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Application_ID = $row["ApplicationID"];
		$Application_Name = $row["Name"];
		$Application_Detail = $row["Detail"];
		$Application_ExpirationDate = $row["ExpirationDate"];
		$Application_Blocked = $row["Blocked"];
		$Application_Status = $row["Status"];
		$Application_Version = $row["Version"];
	}
	else {
		throw new Exception("Uygulama bulunamadı.", "130");
	}
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	if($Application_ExpirationDate>=date("Y-m-d H:i:s") && (int)$Application_Blocked == 0 && (int)$Application_Status == 1) {
		
		$categories = array();
		
		//add general
		$category = array(
			'CategoryID' => 0,
			'CategoryName' => 'Genel'
		);
		array_push($categories, $category);
		
		$sql = "SELECT * FROM `Category` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1 ORDER BY `Name` ASC";
		execute_mysql_query($sql, $result, $rc);
		if($rc > 0) {
			while($row = mysql_fetch_array($result)) {
				
				$Category_ID = $row["CategoryID"];
				$Category_Name = $row["Name"];
				
				$category = array(
					'CategoryID' => (int)$Category_ID,
					'CategoryName' => $Category_Name
				);
				array_push($categories, $category);
			}
		}		
		$ret = array(
			'status' => 0,
			'error' => "",
			'Categories' => $categories
		);
	}
	else {
		throw new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", "131");
	}
	return $ret;
}

function request_GetCategoryDetail($cCategoryID) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Category_ID = "";
	$Category_Name = "";
	
	$sql = "SELECT * FROM `Category` WHERE `CategoryID`=".mysql_real_escape_string((int)$cCategoryID)." AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Category_ID = $row["CategoryID"];
		$Category_Name = $row["Name"];
		
		$ret = array(
			'status' => 0,
			'error' => "",
			'CategoryID' => (int)$Category_ID,
			'CategoryName' => $Category_Name
		);
	}
	else {
		throw new Exception("Kategori bulunamadı.", "140");
	}
	return $ret;
}

function request_GetAppContents($cApplicationID, $cApplicationToken, $cDeviceToken, $cUsername, $cPassword) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Customer_ID = "";
	$Customer_Name = "";
	
	$Application_ID = "";
	$Application_Name = "";
	$Application_Detail = "";
	$Application_ExpirationDate = "";
	$Application_Blocked = "";
	$Application_Status = "";
	$Application_Version = "";
	
	$sql = "SELECT * FROM `Customer` WHERE `CustomerID` IN (SELECT `CustomerID` FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1) AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Customer_ID = $row["CustomerID"];
		$Customer_Name = $row["CustomerName"];
	}
	else {
		throw new Exception("Müşteri bulunamadı.", "120");
	}
	
	if(strlen($cUsername) > 0)
	{
		//check user credential
		$sql = "SELECT * FROM `User` WHERE `CustomerID`=".mysql_real_escape_string((int)$Customer_ID)." AND `Username`='".mysql_real_escape_string($cUsername)."' AND `StatusID`=1";
		execute_mysql_query($sql, $result, $rc);
		if($rc > 0) {
			$row = mysql_fetch_array($result);
			
			$pass = $row["Password"];
			
			if(!(crypt($cPassword, $pass) === $pass))
			{
				throw new Exception("Hatalı kullanıcı bilgileri.", "140");
			}
		}
		else
		{
			throw new Exception("Hatalı kullanıcı bilgileri.", "140");
		}
	}
	
	$sql = "SELECT * FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Application_ID = $row["ApplicationID"];
		$Application_Name = $row["Name"];
		$Application_Detail = $row["Detail"];
		$Application_ExpirationDate = $row["ExpirationDate"];
		$Application_Blocked = $row["Blocked"];
		$Application_Status = $row["Status"];
		$Application_Version = $row["Version"];
	}
	else {
		throw new Exception("Uygulama bulunamadı.", "130");
	}
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	if($Application_ExpirationDate>=date("Y-m-d H:i:s") && (int)$Application_Blocked == 0 && (int)$Application_Status == 1) {
		
		//save tokens
		if(strlen($cApplicationToken) > 0 && strlen($cDeviceToken) > 0)
		{
			token_Save($Customer_ID, $cApplicationID, $cApplicationToken, $cDeviceToken);
		}
		
		$contents = array();
		
		//$sql = "SELECT * FROM (SELECT c.*, (SELECT `Name` FROM `Category` WHERE `CategoryID`=c.`CategoryID` AND `StatusID`=1) AS CategoryName, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND c.`StatusID`=1) t ORDER BY `CategoryName` ASC, `MonthlyName` ASC, `Name` ASC";
		$sql = "SELECT * FROM (SELECT c.*, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND c.`StatusID`=1) t ORDER BY `MonthlyName` ASC, `Name` ASC";
		execute_mysql_query($sql, $result, $rc);
		if($rc > 0) {
			while($row = mysql_fetch_array($result)) {
				
				$Content_ID = $row["ContentID"];
				$Content_Name = $row["Name"];
				$Content_Detail = $row["Detail"];
				//$Content_CategoryID = $row["CategoryID"];
				//$Content_CategoryName = $row["CategoryName"];
				$Content_MonthlyName = $row["MonthlyName"];
				$Content_IsProtected = $row["IsProtected"];
				$Content_IsBuyable = $row["IsBuyable"];
				$Content_Price = $row["Price"];
				$Content_Currency = $row["Currency"];
				$Content_Identifier = $row["Identifier"];
				$Content_AutoDownload = $row["AutoDownload"];
				$Content_Blocked = $row["Blocked"];
				$Content_Status = $row["Status"];
				$Content_Version = $row["Version"];
				
				$content = array(
					'ContentID' => (int)$Content_ID,
					'ContentName' => $Content_Name,
					'ContentMonthlyName' => $Content_MonthlyName,
					'ContentBlocked' => ((int)$Content_Blocked == 1 ? true : false),
					'ContentStatus' => ((int)$Content_Status == 1 ? true : false),
					'ContentVersion' => (int)$Content_Version
				);
				array_push($contents, $content);
			}
		}
		else {
			throw new Exception("İçerik bulunamadı.", "102");
		}
		$ret = array(
			'status' => 0,
			'error' => "",
			'Contents' => $contents
		);
	}
	else {
		throw new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", "131");
	}
	return $ret;
}

function request_GetAppContentsWithCategories($cApplicationID, $cApplicationToken, $cDeviceToken, $cUsername, $cPassword, $cCategoryID) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Customer_ID = "";
	$Customer_Name = "";
	
	$Application_ID = "";
	$Application_Name = "";
	$Application_Detail = "";
	$Application_ExpirationDate = "";
	$Application_Blocked = "";
	$Application_Status = "";
	$Application_Version = "";
	
	$sql = "SELECT * FROM `Customer` WHERE `CustomerID` IN (SELECT `CustomerID` FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1) AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Customer_ID = $row["CustomerID"];
		$Customer_Name = $row["CustomerName"];
	}
	else {
		throw new Exception("Müşteri bulunamadı.", "120");
	}
	
	if(strlen($cUsername) > 0)
	{
		//check user credential
		$sql = "SELECT * FROM `User` WHERE `CustomerID`=".mysql_real_escape_string((int)$Customer_ID)." AND `Username`='".mysql_real_escape_string($cUsername)."' AND `StatusID`=1";
		execute_mysql_query($sql, $result, $rc);
		if($rc > 0) {
			$row = mysql_fetch_array($result);
			
			$pass = $row["Password"];
			
			if(!(crypt($cPassword, $pass) === $pass))
			{
				throw new Exception("Hatalı kullanıcı bilgileri.", "140");
			}
		}
		else
		{
			throw new Exception("Hatalı kullanıcı bilgileri.", "140");
		}
	}
	
	$sql = "SELECT * FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Application_ID = $row["ApplicationID"];
		$Application_Name = $row["Name"];
		$Application_Detail = $row["Detail"];
		$Application_ExpirationDate = $row["ExpirationDate"];
		$Application_Blocked = $row["Blocked"];
		$Application_Status = $row["Status"];
		$Application_Version = $row["Version"];
	}
	else {
		throw new Exception("Uygulama bulunamadı.", "130");
	}
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	if($Application_ExpirationDate>=date("Y-m-d H:i:s") && (int)$Application_Blocked == 0 && (int)$Application_Status == 1) {
		
		//save tokens
		if(strlen($cApplicationToken) > 0 && strlen($cDeviceToken) > 0)
		{
			token_Save($Customer_ID, $cApplicationID, $cApplicationToken, $cDeviceToken);
		}
		
		$contents = array();
		
		//$sql = "SELECT * FROM (SELECT c.*, (SELECT `Name` FROM `Category` WHERE `CategoryID`=c.`CategoryID` AND `StatusID`=1) AS CategoryName, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND ".((int)$cCategoryID !== -1 ? "c.`ContentID` IN (SELECT ContentID FROM `ContentCategory` WHERE CategoryID = ".mysql_real_escape_string((int)$cCategoryID).") AND " : "")."c.`StatusID`=1) t ORDER BY `CategoryName` ASC, `MonthlyName` ASC, `Name` ASC";
		$sql = "SELECT * FROM (SELECT c.*, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ApplicationID`=".mysql_real_escape_string((int)$cApplicationID)." AND ".((int)$cCategoryID !== -1 ? "c.`ContentID` IN (SELECT ContentID FROM `ContentCategory` WHERE CategoryID = ".mysql_real_escape_string((int)$cCategoryID).") AND " : "")."c.`StatusID`=1) t ORDER BY `MonthlyName` ASC, `Name` ASC";
		execute_mysql_query($sql, $result, $rc);
		if($rc > 0) {
			while($row = mysql_fetch_array($result)) {
				
				$Content_ID = $row["ContentID"];
				$Content_Name = $row["Name"];
				$Content_Detail = $row["Detail"];
				//$Content_CategoryID = $row["CategoryID"];
				//$Content_CategoryName = $row["CategoryName"];
				$Content_MonthlyName = $row["MonthlyName"];
				$Content_IsProtected = $row["IsProtected"];
				$Content_IsBuyable = $row["IsBuyable"];
				$Content_Price = $row["Price"];
				$Content_Currency = $row["Currency"];
				$Content_Identifier = $row["Identifier"];
				$Content_AutoDownload = $row["AutoDownload"];
				$Content_Blocked = $row["Blocked"];
				$Content_Status = $row["Status"];
				$Content_Version = $row["Version"];
				
				$content = array(
					'ContentID' => (int)$Content_ID,
					'ContentName' => $Content_Name,
					'ContentMonthlyName' => $Content_MonthlyName,
					'ContentBlocked' => ((int)$Content_Blocked == 1 ? true : false),
					'ContentStatus' => ((int)$Content_Status == 1 ? true : false),
					'ContentVersion' => (int)$Content_Version
				);
				array_push($contents, $content);
			}
		}
		else {
			throw new Exception("İçerik bulunamadı.", "102");
		}
		$ret = array(
			'status' => 0,
			'error' => "",
			'Contents' => $contents
		);
	}
	else {
		throw new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", "131");
	}
	return $ret;
}

function request_GetContentVersion($cContentID) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Content_ID = "";
	$Content_Name = "";
	$Content_Detail = "";
	//$Content_CategoryID = "";
	//$Content_CategoryName = "";
	$Content_MonthlyName = "";
	$Content_IsProtected = "";
	$Content_IsBuyable = "";
	$Content_Price = "";
	$Content_Currency = "";
	$Content_Identifier = "";
	$Content_AutoDownload = "";
	$Content_Blocked = "";
	$Content_Status = "";
	$Content_Version = "";
	
	//$sql = "SELECT c.*, (SELECT `Name` FROM `Category` WHERE `CategoryID`=c.`CategoryID` AND `StatusID`=1) AS CategoryName, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	$sql = "SELECT c.*, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);

		$Content_ID = $row["ContentID"];
		$Content_ApplicationID = $row["ApplicationID"];
		$Content_Name = $row["Name"];
		$Content_Detail = $row["Detail"];
		//$Content_CategoryID = $row["CategoryID"];
		//$Content_CategoryName = $row["CategoryName"];
		$Content_MonthlyName = $row["MonthlyName"];
		$Content_IsProtected = $row["IsProtected"];
		$Content_IsBuyable = $row["IsBuyable"];
		$Content_Price = $row["Price"];
		$Content_Currency = $row["Currency"];
		$Content_Identifier = $row["Identifier"];
		$Content_AutoDownload = $row["AutoDownload"];
		$Content_Blocked = $row["Blocked"];
		$Content_Status = $row["Status"];
		$Content_Version = $row["Version"];

		check_Application($Content_ApplicationID);
	}
	else {
		throw new Exception("İçerik bulunamadı.", "102");
	}
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	//if((int)$Content_Blocked == 0 && (int)$Content_Status == 1) {
	if((int)$Content_Blocked == 0) {
		$ret = array(
			'status' => 0,
			'error' => "",
			'ContentID' => (int)$Content_ID,
			'ContentBlocked' => ((int)$Content_Blocked == 1 ? true : false),
			'ContentStatus' => ((int)$Content_Status == 1 ? true : false),
			'ContentVersion' => (int)$Content_Version
		);
	}
	else {
		//throw new Exception("İçerik aktif değil. İçerik engellenmiş veya pasifleştirilmiş olabilir.", "103");
		throw new Exception("İçerik engellenmiş.", "103");
	}
	return $ret;
}

function request_GetContentDetail($cContentID) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Content_ID = "";
	$Content_Name = "";
	$Content_Detail = "";
	//$Content_CategoryID = "";
	//$Content_CategoryName = "";
	$Content_MonthlyName = "";
	$Content_IsProtected = "";
	$Content_IsBuyable = "";
	$Content_Price = "";
	$Content_Currency = "";
	$Content_Identifier = "";
	$Content_AutoDownload = "";
	$Content_Blocked = "";
	$Content_Status = "";
	$Content_Version = "";
	$Content_PdfVersion = "";
	$Content_CoverImageVersion = "";
	
	//(SELECT COUNT(*) FROM `ContentCoverImageFile` WHERE `ContentID`=c.`ContentID` AND `StatusID`=1) AS CoverImageVersion, 
	//$sql = "SELECT c.*, (SELECT COUNT(*) FROM `ContentFile` WHERE `ContentID`=c.`ContentID` AND `StatusID`=1) AS PdfVersion, (SELECT COUNT(*) FROM `ContentCoverImageFile` WHERE `ContentFileID` IN (SELECT MAX(`ContentFileID`) FROM `ContentFile` WHERE `ContentID`=c.`ContentID` AND `StatusID`=1) AND `StatusID`=1) AS CoverImageVersion, (SELECT `Name` FROM `Category` WHERE `CategoryID`=c.`CategoryID` AND `StatusID`=1) AS CategoryName, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	//$sql = "SELECT c.*, IFNULL(c.PdfVersion, 1) AS PdfVersion1, IFNULL(c.CoverImageVersion, 1) AS CoverImageVersion1, (SELECT `Name` FROM `Category` WHERE `CategoryID`=c.`CategoryID` AND `StatusID`=1) AS CategoryName, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	$sql = "SELECT c.*, IFNULL(c.PdfVersion, 1) AS PdfVersion1, IFNULL(c.CoverImageVersion, 1) AS CoverImageVersion1, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);

		$Content_ID = $row["ContentID"];
		$Content_ApplicationID = $row["ApplicationID"];
		$Content_Name = $row["Name"];
		$Content_Detail = $row["Detail"];
		//$Content_CategoryID = $row["CategoryID"];
		//$Content_CategoryName = $row["CategoryName"];
		$Content_MonthlyName = $row["MonthlyName"];
		$Content_IsProtected = $row["IsProtected"];
		$Content_IsBuyable = $row["IsBuyable"];
		$Content_Price = $row["Price"];
		$Content_Currency = $row["Currency"];
		$Content_Identifier = $row["Identifier"];
		$Content_AutoDownload = $row["AutoDownload"];
		$Content_Blocked = $row["Blocked"];
		$Content_Status = $row["Status"];
		$Content_Version = $row["Version"];
		//$Content_PdfVersion = (int)$row["Version"] + (int)$row["PdfVersion"];
		//$Content_CoverImageVersion = (int)$row["Version"] + (int)$row["PdfVersion"] + (int)$row["CoverImageVersion"];
		$Content_PdfVersion = 1000 + (int)$row["PdfVersion1"];
		$Content_CoverImageVersion = 1000 + (int)$row["CoverImageVersion1"];

		check_Application($Content_ApplicationID);
	}
	else {
		throw new Exception("İçerik bulunamadı.", "102");
	}
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	//if((int)$Content_Blocked == 0 && (int)$Content_Status == 1) {
	if((int)$Content_Blocked == 0) {	
		$ret = array(
			'status' => 0,
			'error' => "",
			'ContentID' => (int)$Content_ID,
			'ContentName' => $Content_Name,
			'ContentDetail' => $Content_Detail,
			//'ContentCategoryID' => (int)$Content_CategoryID,
			//'ContentCategoryName' => $Content_CategoryName,
			'ContentCategoryID' => 0,
			'ContentCategoryName' => '',
			'ContentMonthlyName' => $Content_MonthlyName,
			'ContentIsProtected' => ((int)$Content_IsProtected == 1 ? true : false),
			'ContentIsBuyable' => ((int)$Content_IsBuyable == 1 ? true : false),
			'ContentPrice' => $Content_Price,
			'ContentCurrency' => $Content_Currency,
			'ContentIdentifier' => $Content_Identifier,
			'ContentAutoDownload' => ((int)$Content_AutoDownload == 1 ? true : false),
			'ContentBlocked' => ((int)$Content_Blocked == 1 ? true : false),
			'ContentStatus' => ((int)$Content_Status == 1 ? true : false),
			'ContentVersion' => (int)$Content_Version,
			'ContentPdfVersion' => (int)$Content_PdfVersion,
			'ContentCoverImageVersion' => (int)$Content_CoverImageVersion
		);
	}
	else {
		//throw new Exception("İçerik aktif değil. İçerik engellenmiş veya pasifleştirilmiş olabilir.", "103");
		throw new Exception("İçerik engellenmiş.", "103");
	}
	return $ret;
}

function request_GetContentDetailWithCategories($cContentID) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Content_ID = "";
	$Content_Name = "";
	$Content_Detail = "";
	//$Content_CategoryID = "";
	//$Content_CategoryName = "";
	$Content_MonthlyName = "";
	$Content_IsProtected = "";
	$Content_IsBuyable = "";
	$Content_Price = "";
	$Content_Currency = "";
	$Content_Identifier = "";
	$Content_AutoDownload = "";
	$Content_Blocked = "";
	$Content_Status = "";
	$Content_Version = "";
	$Content_PdfVersion = "";
	$Content_CoverImageVersion = "";
	
	//(SELECT COUNT(*) FROM `ContentCoverImageFile` WHERE `ContentID`=c.`ContentID` AND `StatusID`=1) AS CoverImageVersion, 
	//$sql = "SELECT c.*, (SELECT COUNT(*) FROM `ContentFile` WHERE `ContentID`=c.`ContentID` AND `StatusID`=1) AS PdfVersion, (SELECT COUNT(*) FROM `ContentCoverImageFile` WHERE `ContentFileID` IN (SELECT MAX(`ContentFileID`) FROM `ContentFile` WHERE `ContentID`=c.`ContentID` AND `StatusID`=1) AND `StatusID`=1) AS CoverImageVersion, (SELECT `Name` FROM `Category` WHERE `CategoryID`=c.`CategoryID` AND `StatusID`=1) AS CategoryName, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	//$sql = "SELECT c.*, IFNULL(c.PdfVersion, 1) AS PdfVersion1, IFNULL(c.CoverImageVersion, 1) AS CoverImageVersion1, (SELECT `Name` FROM `Category` WHERE `CategoryID`=c.`CategoryID` AND `StatusID`=1) AS CategoryName, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	$sql = "SELECT c.*, IFNULL(c.PdfVersion, 1) AS PdfVersion1, IFNULL(c.CoverImageVersion, 1) AS CoverImageVersion1, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);

		$Content_ID = $row["ContentID"];
		$Content_ApplicationID = $row["ApplicationID"];
		$Content_Name = $row["Name"];
		$Content_Detail = $row["Detail"];
		//$Content_CategoryID = $row["CategoryID"];
		//$Content_CategoryName = $row["CategoryName"];
		$Content_MonthlyName = $row["MonthlyName"];
		$Content_IsProtected = $row["IsProtected"];
		$Content_IsBuyable = $row["IsBuyable"];
		$Content_Price = $row["Price"];
		$Content_Currency = $row["Currency"];
		$Content_Identifier = $row["Identifier"];
		$Content_AutoDownload = $row["AutoDownload"];
		$Content_Blocked = $row["Blocked"];
		$Content_Status = $row["Status"];
		$Content_Version = $row["Version"];
		//$Content_PdfVersion = (int)$row["Version"] + (int)$row["PdfVersion"];
		//$Content_CoverImageVersion = (int)$row["Version"] + (int)$row["PdfVersion"] + (int)$row["CoverImageVersion"];
		$Content_PdfVersion = 1000 + (int)$row["PdfVersion1"];
		$Content_CoverImageVersion = 1000 + (int)$row["CoverImageVersion1"];

		check_Application($Content_ApplicationID);
	}
	else {
		throw new Exception("İçerik bulunamadı.", "102");
	}
	
	$categories = array();
	
	$sql = "SELECT ct.CategoryID, ct.Name FROM `ContentCategory` cc LEFT OUTER JOIN `Category` ct ON cc.`CategoryID` = ct.`CategoryID` AND ct.`StatusID` = 1 WHERE cc.`ContentID`=".mysql_real_escape_string((int)$cContentID)." ORDER BY ct.`Name` ASC";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		while($row = mysql_fetch_array($result)) {
			
			$Category_ID = $row["CategoryID"];
			$Category_Name = $row["Name"];
			
			if((int)$Category_ID == 0) {
				$Category_Name = 'Genel';
			}
			
			$category = array(
				'CategoryID' => (int)$Category_ID,
				'CategoryName' => $Category_Name
			);
			array_push($categories, $category);
		}
	}		
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	//if((int)$Content_Blocked == 0 && (int)$Content_Status == 1) {
	if((int)$Content_Blocked == 0) {	
		$ret = array(
			'status' => 0,
			'error' => "",
			'ContentID' => (int)$Content_ID,
			'ContentName' => $Content_Name,
			'ContentDetail' => $Content_Detail,
			//'ContentCategoryID' => (int)$Content_CategoryID,
			//'ContentCategoryName' => $Content_CategoryName,
			'ContentCategories' => $categories,
			'ContentMonthlyName' => $Content_MonthlyName,
			'ContentIsProtected' => ((int)$Content_IsProtected == 1 ? true : false),
			'ContentIsBuyable' => ((int)$Content_IsBuyable == 1 ? true : false),
			'ContentPrice' => $Content_Price,
			'ContentCurrency' => $Content_Currency,
			'ContentIdentifier' => $Content_Identifier,
			'ContentAutoDownload' => ((int)$Content_AutoDownload == 1 ? true : false),
			'ContentBlocked' => ((int)$Content_Blocked == 1 ? true : false),
			'ContentStatus' => ((int)$Content_Status == 1 ? true : false),
			'ContentVersion' => (int)$Content_Version,
			'ContentPdfVersion' => (int)$Content_PdfVersion,
			'ContentCoverImageVersion' => (int)$Content_CoverImageVersion
		);
	}
	else {
		//throw new Exception("İçerik aktif değil. İçerik engellenmiş veya pasifleştirilmiş olabilir.", "103");
		throw new Exception("İçerik engellenmiş.", "103");
	}
	return $ret;
}

function request_GetContentCoverImage($cContentID, $cSize) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Content_ID = "";
	$Content_Name = "";
	$Content_Detail = "";
	//$Content_CategoryID = "";
	//$Content_CategoryName = "";
	$Content_MonthlyName = "";
	$Content_IsProtected = "";
	$Content_IsBuyable = "";
	$Content_Price = "";
	$Content_Currency = "";
	$Content_Identifier = "";
	$Content_AutoDownload = "";
	$Content_Blocked = "";
	$Content_Status = "";
	$Content_Version = "";
	
	//$sql = "SELECT c.*, (SELECT `Name` FROM `Category` WHERE `CategoryID`=c.`CategoryID` AND `StatusID`=1) AS CategoryName, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	$sql = "SELECT c.*, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);

		$Content_ID = $row["ContentID"];
		$Content_ApplicationID = $row["ApplicationID"];
		$Content_Name = $row["Name"];
		$Content_Detail = $row["Detail"];
		//$Content_CategoryID = $row["CategoryID"];
		//$Content_CategoryName = $row["CategoryName"];
		$Content_MonthlyName = $row["MonthlyName"];
		$Content_IsProtected = $row["IsProtected"];
		$Content_IsBuyable = $row["IsBuyable"];
		$Content_Price = $row["Price"];
		$Content_Currency = $row["Currency"];
		$Content_Identifier = $row["Identifier"];
		$Content_AutoDownload = $row["AutoDownload"];
		$Content_Blocked = $row["Blocked"];
		$Content_Status = $row["Status"];
		$Content_Version = $row["Version"];

		check_Application($Content_ApplicationID);
	}
	else {
		throw new Exception("İçerik bulunamadı.", "102");
	}
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	//if((int)$Content_Blocked == 0 && (int)$Content_Status == 1) {
	if((int)$Content_Blocked == 0) {	
		if((int)$cSize == 0) {
			//normal
			$ret = array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$Content_ID,
				'Url' => "http://www.galepress.com/tr/icerikler/talep?RequestTypeID=1101&ContentID=".(int)$Content_ID
			);
		}
		else if((int)$cSize == 1) {
			//small
			$ret = array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$Content_ID,
				'Url' => "http://www.galepress.com/tr/icerikler/talep?RequestTypeID=1102&ContentID=".(int)$Content_ID
			);
		}
	}
	else {
		//throw new Exception("İçerik aktif değil. İçerik engellenmiş veya pasifleştirilmiş olabilir.", "103");
		throw new Exception("İçerik engellenmiş.", "103");
	}
	return $ret;
}

function request_GetContentFile($cContentID, $cPassword) {

	$ret = array();
	$result = "";
	$rc = 0;
	
	$Content_ID = "";
	$Content_Name = "";
	$Content_Detail = "";
	//$Content_CategoryID = "";
	//$Content_CategoryName = "";
	$Content_MonthlyName = "";
	$Content_IsProtected = "";
	$Content_IsBuyable = "";
	$Content_Price = "";
	$Content_Currency = "";
	$Content_Identifier = "";
	$Content_AutoDownload = "";
	$Content_Blocked = "";
	$Content_Status = "";
	$Content_Version = "";
	
	//$sql = "SELECT c.*, (SELECT `Name` FROM `Category` WHERE `CategoryID`=c.`CategoryID` AND `StatusID`=1) AS CategoryName, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	$sql = "SELECT c.*, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=c.`CurrencyID` AND `LanguageID`=1) AS Currency FROM `Content` c WHERE c.`ContentID`=".mysql_real_escape_string((int)$cContentID)." AND c.`StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);

		$Content_ID = $row["ContentID"];
		$Content_ApplicationID = $row["ApplicationID"];
		$Content_Name = $row["Name"];
		$Content_Detail = $row["Detail"];
		//$Content_CategoryID = $row["CategoryID"];
		//$Content_CategoryName = $row["CategoryName"];
		$Content_MonthlyName = $row["MonthlyName"];
		$Content_IsProtected = $row["IsProtected"];
		$Content_IsBuyable = $row["IsBuyable"];
		$Content_Price = $row["Price"];
		$Content_Currency = $row["Currency"];
		$Content_Identifier = $row["Identifier"];
		$Content_AutoDownload = $row["AutoDownload"];
		$Content_Blocked = $row["Blocked"];
		$Content_Status = $row["Status"];
		$Content_Version = $row["Version"];

		check_Application($Content_ApplicationID);
	}
	else {
		throw new Exception("İçerik bulunamadı.", "102");
	}
	
	//TODO:duzelt
	//$cRequestID = request_Save(0, 201, $Customer_CustomerID, $cApplicationID, 0, 0, 0, 0, 1, 0);
	
	//if((int)$Content_Blocked == 0 && (int)$Content_Status == 1) {
	if((int)$Content_Blocked == 0) {
		
		$ret = array(
			'status' => 0,
			'error' => "",
			'ContentID' => (int)$Content_ID,
			'Url' => "http://www.galepress.com/tr/icerikler/talep?RequestTypeID=1001&ContentID=".(int)$Content_ID."&Password=".$cPassword
		);
	}
	else {
		//throw new Exception("İçerik aktif değil. İçerik engellenmiş veya pasifleştirilmiş olabilir.", "103");
		throw new Exception("İçerik engellenmiş.", "103");
	}
	return $ret;
}

function check_Application($ApplicationID)
{
	$sql = "SELECT * FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$ApplicationID)." AND `StatusID`=1";
	execute_mysql_query($sql, $result, $rc);
	if($rc > 0) {
		$row = mysql_fetch_array($result);
		
		$Application_ExpirationDate = $row["ExpirationDate"];
		$Application_Blocked = $row["Blocked"];
		$Application_Status = $row["Status"];

		if(!($Application_ExpirationDate>=date("Y-m-d H:i:s") && (int)$Application_Blocked == 0 && (int)$Application_Status == 1)) {

			throw new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", "131");
		}
	}
	else {
		throw new Exception("Uygulama bulunamadı.", "130");
	}	
}

function token_Save($cCustomerID, $cApplicationID, $cApplicationToken, $cDeviceToken)
{
	$sql = "SELECT * FROM `Token` WHERE `ApplicationToken`='%s' AND `DeviceToken`='%s'";
	$sql = sprintf($sql,
		mysql_real_escape_string($cApplicationToken),
		mysql_real_escape_string($cDeviceToken)
	);
	execute_mysql_query($sql, $result, $rc);
	if($rc == 0) {
		
		$sql = "INSERT INTO `Token` (`CustomerID`, `ApplicationID`, `ApplicationToken`, `DeviceToken`) VALUES (%s, %s, '%s', '%s')";
		$sql = sprintf($sql,
			mysql_real_escape_string((int)$cCustomerID),
			mysql_real_escape_string((int)$cApplicationID),
			mysql_real_escape_string($cApplicationToken),
			mysql_real_escape_string($cDeviceToken)
		);
		$result = "";
		$rc = 0;
		execute_mysql_query($sql, $result, $rc);
	}
}

function request_SubmitStatistic($id, $type, $time, $lat, $long, $deviceID, $contentID, $page, $param5, $param6, $param7)
{
	$id = trim($id);
	$deviceID = trim($deviceID);
	$found = false;
	if(strlen($id) > 0 && strlen($deviceID) > 0) {

		$sql = "SELECT COUNT(*) AS cnt FROM `Statistic` WHERE `UID`='".mysql_real_escape_string($id)."' AND `DeviceID`='".mysql_real_escape_string($deviceID)."'";
		execute_mysql_query($sql, $result, $rc);
		if($rc > 0) {
			$row = mysql_fetch_array($result);
			$found = (int)$row["cnt"] > 0;
		}
	}
	if(!$found) 
	{
		$contentID = (int)$contentID;
		$applicationID = 'NULL';
		$customerID = 'NULL';

		if($contentID > 0) {
			$sql = "SELECT * FROM `Content` WHERE `ContentID`=".mysql_real_escape_string((int)$contentID);
			execute_mysql_query($sql, $result, $rc);
			if($rc > 0) {
				$row = mysql_fetch_array($result);

				$applicationID = (int)$row["ApplicationID"];

				$sql = "SELECT * FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$applicationID);
				execute_mysql_query($sql, $result, $rc);
				if($rc > 0) {
					$row = mysql_fetch_array($result);

					$customerID = (int)$row["CustomerID"];
				}
			}
		}
		else {
			$contentID = 'NULL';
		}

		$sql = "INSERT INTO `Statistic` (`UID`, `Type`, `Time`, `Lat`, `Long`, `DeviceID`, `CustomerID`, `ApplicationID`, `ContentID`, `Page`, `Param5`, `Param6`, `Param7`) VALUES ('%s', %s, '%s', '%s', '%s', '%s', %s, %s, %s, %s, '%s', '%s', '%s')";
		$sql = sprintf($sql,
			mysql_real_escape_string($id),
			mysql_real_escape_string((int)$type),
			mysql_real_escape_string($time),
			mysql_real_escape_string($lat),
			mysql_real_escape_string($long),
			mysql_real_escape_string($deviceID),
			mysql_real_escape_string($customerID),
			mysql_real_escape_string($applicationID),
			mysql_real_escape_string($contentID),
			mysql_real_escape_string((int)$page == 0 ? 'NULL' : (int)$page),
			mysql_real_escape_string($param5),
			mysql_real_escape_string($param6),
			mysql_real_escape_string($param7)
		);
		$result = "";
		$rc = 0;
		execute_mysql_query($sql, $result, $rc);
	}
	$ret = array(
		'status' => 0,
		'id' => $id,
		'error' => ""
	);
	return $ret;
}

function request_SubmitStatisticWithApplicationID($id, $type, $time, $lat, $long, $deviceID, $applicationID, $contentID, $page, $param5, $param6, $param7)
{
	$id = trim($id);
	$deviceID = trim($deviceID);
	$found = false;
	if(strlen($id) > 0 && strlen($deviceID) > 0) {

		$sql = "SELECT COUNT(*) AS cnt FROM `Statistic` WHERE `UID`='".mysql_real_escape_string($id)."' AND `DeviceID`='".mysql_real_escape_string($deviceID)."'";
		execute_mysql_query($sql, $result, $rc);
		if($rc > 0) {
			$row = mysql_fetch_array($result);
			$found = (int)$row["cnt"] > 0;
		}
	}
	if(!$found) 
	{
		$contentID = (int)$contentID;
		$applicationID = (int)$applicationID;
		$customerID = 'NULL';

		if($contentID > 0) {
			$sql = "SELECT * FROM `Content` WHERE `ContentID`=".mysql_real_escape_string((int)$contentID);
			execute_mysql_query($sql, $result, $rc);
			if($rc > 0) {
				$row = mysql_fetch_array($result);

				$applicationID = (int)$row["ApplicationID"];

				$sql = "SELECT * FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$applicationID);
				execute_mysql_query($sql, $result, $rc);
				if($rc > 0) {
					$row = mysql_fetch_array($result);

					$customerID = (int)$row["CustomerID"];
				}
			}	
		}
		elseif($applicationID > 0) {
			$sql = "SELECT * FROM `Application` WHERE `ApplicationID`=".mysql_real_escape_string((int)$applicationID);
			execute_mysql_query($sql, $result, $rc);
			if($rc > 0) {
				$row = mysql_fetch_array($result);

				$customerID = (int)$row["CustomerID"];
			}
		}
		else {
			$contentID = 'NULL';
			$applicationID = 'NULL';
		}

		$sql = "INSERT INTO `Statistic` (`UID`, `Type`, `Time`, `Lat`, `Long`, `DeviceID`, `CustomerID`, `ApplicationID`, `ContentID`, `Page`, `Param5`, `Param6`, `Param7`) VALUES ('%s', %s, '%s', '%s', '%s', '%s', %s, %s, %s, %s, '%s', '%s', '%s')";
		$sql = sprintf($sql,
			mysql_real_escape_string($id),
			mysql_real_escape_string((int)$type),
			mysql_real_escape_string($time),
			mysql_real_escape_string($lat),
			mysql_real_escape_string($long),
			mysql_real_escape_string($deviceID),
			mysql_real_escape_string($customerID),
			mysql_real_escape_string($applicationID),
			mysql_real_escape_string($contentID),
			mysql_real_escape_string((int)$page == 0 ? 'NULL' : (int)$page),
			mysql_real_escape_string($param5),
			mysql_real_escape_string($param6),
			mysql_real_escape_string($param7)
		);
		$result = "";
		$rc = 0;
		execute_mysql_query($sql, $result, $rc);	
	}
	$ret = array(
		'status' => 0,
		'id' => $id,
		'error' => ""
	);
	return $ret;
}
*/
?>