<?php
require($_SERVER["DOCUMENT_ROOT"]."/lib/nusoap-0.9.5/nusoap.php");
require($_SERVER["DOCUMENT_ROOT"]."/lib/common.php");
require($_SERVER["DOCUMENT_ROOT"]."/lib/ws.php");

$server = new soap_server();
$server->configureWSDL("WSDL", "urn:WSDL");

//getAppVersion
$server->wsdl->addComplexType(
	'ctGetAppVersion',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'ApplicationID' => array('name'=>'ApplicationID', 'type'=>'xsd:int'),
		'ApplicationBlocked' => array('name'=>'ApplicationBlocked', 'type'=>'xsd:boolean'),
		'ApplicationStatus' => array('name'=>'ApplicationStatus', 'type'=>'xsd:boolean'),
		'ApplicationVersion' => array('name'=>'ApplicationVersion', 'type'=>'xsd:int')
	)
);
$server->register("getAppVersion", array("applicationID" => "xsd:int"), array("return" => "tns:ctGetAppVersion"), "urn:AppVersion", "urn:AppVersion#getAppVersion");

//getAppDetail
$server->wsdl->addComplexType(
	'ctGetAppDetail',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'CustomerID' => array('name'=>'CustomerID', 'type'=>'xsd:int'),
		'CustomerName' => array('name'=>'CustomerName', 'type'=>'xsd:string'),
		'ApplicationID' => array('name'=>'ApplicationID', 'type'=>'xsd:int'),
		'ApplicationName' => array('name'=>'ApplicationName', 'type'=>'xsd:string'),
		'ApplicationDetail' => array('name'=>'ApplicationDetail', 'type'=>'xsd:string'),
		'ApplicationExpirationDate' => array('name'=>'ApplicationExpirationDate', 'type'=>'xsd:string'),
		'ApplicationBlocked' => array('name'=>'ApplicationBlocked', 'type'=>'xsd:boolean'),
		'ApplicationStatus' => array('name'=>'ApplicationStatus', 'type'=>'xsd:boolean'),
		'ApplicationVersion' => array('name'=>'ApplicationVersion', 'type'=>'xsd:int')
	)
);
$server->register("getAppDetail", array("applicationID" => "xsd:int"), array("return" => "tns:ctGetAppDetail"), "urn:AppDetail", "urn:AppDetail#getAppDetail");

//getAppCategories
$server->wsdl->addComplexType(
	'Category',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'CategoryID' => array('name'=>'CategoryID', 'type'=>'xsd:int'),
		'CategoryName' => array('name'=>'CategoryName', 'type'=>'xsd:string')
	)
);
$server->wsdl->addComplexType(
	'CategoryArray',
	'complexType',
	'array',
	'',
	'SOAP-ENC:Array',
	array(),
	array(
		array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Category[]')
	),
	'tns:Category'
);
$server->wsdl->addComplexType(
	'ctGetAppCategories',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'Categories' => array('name'=>'Categories', 'type'=>'tns:CategoryArray')
	)
);
$server->register("getAppCategories", array("applicationID" => "xsd:int"), array("return" => "tns:ctGetAppCategories"), "urn:AppCategories", "urn:AppCategories#getAppCategories");

//getCategoryDetail
$server->wsdl->addComplexType(
	'ctGetCategoryDetail',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'CategoryID' => array('name'=>'CategoryID', 'type'=>'xsd:int'),
		'CategoryName' => array('name'=>'CategoryName', 'type'=>'xsd:string')
	)
);
$server->register("getCategoryDetail", array("categoryID" => "xsd:int"), array("return" => "tns:ctGetCategoryDetail"), "urn:CategoryDetail", "urn:CategoryDetail#getCategoryDetail");

//getAppContents
$server->wsdl->addComplexType(
	'Content',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'ContentID' => array('name'=>'ContentID', 'type'=>'xsd:int'),
		'ContentName' => array('name'=>'ContentName', 'type'=>'xsd:string'),
		'ContentMonthlyName' => array('name'=>'ContentMonthlyName', 'type'=>'xsd:string'),
		'ContentBlocked' => array('name'=>'ContentBlocked', 'type'=>'xsd:boolean'),
		'ContentStatus' => array('name'=>'ContentStatus', 'type'=>'xsd:boolean'),
		'ContentVersion' => array('name'=>'ContentVersion', 'type'=>'xsd:int')
	)
);
$server->wsdl->addComplexType(
	'ContentArray',
	'complexType',
	'array',
	'',
	'SOAP-ENC:Array',
	array(),
	array(
		array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Content[]')
	),
	'tns:Content'
);
$server->wsdl->addComplexType(
	'ctGetAppContents',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'Contents' => array('name'=>'Contents', 'type'=>'tns:ContentArray')
	)
);
$server->register("getAppContents", array("applicationID" => "xsd:int", "applicationToken" => "xsd:string", "deviceToken" => "xsd:string", "username" => "xsd:string", "password" => "xsd:string"), array("return" => "tns:ctGetAppContents"), "urn:AppContents", "urn:AppContents#getAppContents");

//getAppContentsWithCategories
$server->register("getAppContentsWithCategories", array("applicationID" => "xsd:int", "applicationToken" => "xsd:string", "deviceToken" => "xsd:string", "username" => "xsd:string", "password" => "xsd:string", "categoryID" => "xsd:int"), array("return" => "tns:ctGetAppContents"), "urn:AppContentsWithCategories", "urn:AppContents#getAppContentsWithCategories");

//getContentVersion
$server->wsdl->addComplexType(
	'ctGetContentVersion',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'ContentID' => array('name'=>'ContentID', 'type'=>'xsd:int'),
		'ContentBlocked' => array('name'=>'ContentBlocked', 'type'=>'xsd:boolean'),
		'ContentStatus' => array('name'=>'ContentStatus', 'type'=>'xsd:boolean'),
		'ContentVersion' => array('name'=>'ContentVersion', 'type'=>'xsd:int')
	)
);
$server->register("getContentVersion", array("contentID" => "xsd:int"), array("return" => "tns:ctGetContentVersion"), "urn:ContentVersion", "urn:ContentVersion#getContentVersion");

//getContentDetail
$server->wsdl->addComplexType(
	'ctGetContentDetail',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'ContentID' => array('name'=>'ContentID', 'type'=>'xsd:int'),
		'ContentName' => array('name'=>'ContentName', 'type'=>'xsd:string'),
		'ContentDetail' => array('name'=>'ContentDetail', 'type'=>'xsd:string'),
		'ContentCategoryID' => array('name'=>'ContentCategoryID', 'type'=>'xsd:int'),
		'ContentCategoryName' => array('name'=>'ContentCategoryName', 'type'=>'xsd:string'),
		'ContentMonthlyName' => array('name'=>'ContentMonthlyName', 'type'=>'xsd:string'),
		'ContentIsProtected' => array('name'=>'ContentIsProtected', 'type'=>'xsd:boolean'),
		'ContentIsBuyable' => array('name'=>'ContentIsBuyable', 'type'=>'xsd:boolean'),
		'ContentPrice' => array('name'=>'ContentPrice', 'type'=>'xsd:string'),
		'ContentCurrency' => array('name'=>'ContentCurrency', 'type'=>'xsd:string'),
		'ContentIdentifier' => array('name'=>'ContentIdentifier', 'type'=>'xsd:string'),
		'ContentAutoDownload' => array('name'=>'ContentAutoDownload', 'type'=>'xsd:boolean'),
		'ContentBlocked' => array('name'=>'ContentBlocked', 'type'=>'xsd:boolean'),
		'ContentStatus' => array('name'=>'ContentStatus', 'type'=>'xsd:boolean'),
		'ContentVersion' => array('name'=>'ContentVersion', 'type'=>'xsd:int'),
		'ContentPdfVersion' => array('name'=>'ContentPdfVersion', 'type'=>'xsd:int'),
		'ContentCoverImageVersion' => array('name'=>'ContentCoverImageVersion', 'type'=>'xsd:int')
	)
);
$server->register("getContentDetail", array("contentID" => "xsd:int"), array("return" => "tns:ctGetContentDetail"), "urn:ContentDetail", "urn:ContentDetail#getContentDetail");

//getContentDetailWithCategories
$server->wsdl->addComplexType(
	'ctGetContentDetailWithCategories',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'ContentID' => array('name'=>'ContentID', 'type'=>'xsd:int'),
		'ContentName' => array('name'=>'ContentName', 'type'=>'xsd:string'),
		'ContentDetail' => array('name'=>'ContentDetail', 'type'=>'xsd:string'),
		'ContentCategories' => array('name'=>'ContentCategories', 'type'=>'tns:CategoryArray'),
		'ContentMonthlyName' => array('name'=>'ContentMonthlyName', 'type'=>'xsd:string'),
		'ContentIsProtected' => array('name'=>'ContentIsProtected', 'type'=>'xsd:boolean'),
		'ContentIsBuyable' => array('name'=>'ContentIsBuyable', 'type'=>'xsd:boolean'),
		'ContentPrice' => array('name'=>'ContentPrice', 'type'=>'xsd:string'),
		'ContentCurrency' => array('name'=>'ContentCurrency', 'type'=>'xsd:string'),
		'ContentIdentifier' => array('name'=>'ContentIdentifier', 'type'=>'xsd:string'),
		'ContentAutoDownload' => array('name'=>'ContentAutoDownload', 'type'=>'xsd:boolean'),
		'ContentBlocked' => array('name'=>'ContentBlocked', 'type'=>'xsd:boolean'),
		'ContentStatus' => array('name'=>'ContentStatus', 'type'=>'xsd:boolean'),
		'ContentVersion' => array('name'=>'ContentVersion', 'type'=>'xsd:int'),
		'ContentPdfVersion' => array('name'=>'ContentPdfVersion', 'type'=>'xsd:int'),
		'ContentCoverImageVersion' => array('name'=>'ContentCoverImageVersion', 'type'=>'xsd:int')
	)
);
$server->register("getContentDetailWithCategories", array("contentID" => "xsd:int"), array("return" => "tns:ctGetContentDetailWithCategories"), "urn:ContentDetailWithCategories", "urn:ContentDetailWithCategories#getContentDetailWithCategories");

//getContentCoverImage
$server->wsdl->addComplexType(
	'ctGetContentCoverImage',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'ContentID' => array('name'=>'ContentID', 'type'=>'xsd:int'),
		'Url' => array('name'=>'Url', 'type'=>'xsd:string')
	)
);
$server->register("getContentCoverImage", array("contentID" => "xsd:int", "size" => "xsd:int"), array("return" => "tns:ctGetContentCoverImage"), "urn:ContentCoverImage", "urn:ContentCoverImage#getContentCoverImage");

//getContentFile
$server->wsdl->addComplexType(
	'ctGetContentFile',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'error' => array('name'=>'error', 'type'=>'xsd:string'),
		'ContentID' => array('name'=>'ContentID', 'type'=>'xsd:int'),
		'Url' => array('name'=>'Url', 'type'=>'xsd:string')
	)
);
$server->register("getContentFile", array("contentID" => "xsd:int", "password" => "xsd:string"), array("return" => "tns:ctGetContentFile"), "urn:ContentFile", "urn:ContentFile#getContentFile");

//submitStatistic
$server->wsdl->addComplexType(
	'ctSubmitStatistic',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'id' => array('name'=>'id', 'type'=>'xsd:string'),
		'error' => array('name'=>'error', 'type'=>'xsd:string')
	)
);
$server->register("submitStatistic", array("id" => "xsd:string", "type" => "xsd:string", "time" => "xsd:string", "lat" => "xsd:string", "long" => "xsd:string", "deviceID" => "xsd:string", "contentID" => "xsd:string", "page" => "xsd:string", "param5" => "xsd:string", "param6" => "xsd:string", "param7" => "xsd:string"), array("return" => "tns:ctSubmitStatistic"), "urn:SubmitStatistic", "urn:SubmitStatistic#submitStatistic");

//submitStatisticWithApplicationID
$server->wsdl->addComplexType(
	'ctSubmitStatisticWithApplicationID',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'status' => array('name'=>'status', 'type'=>'xsd:int'),
		'id' => array('name'=>'id', 'type'=>'xsd:string'),
		'error' => array('name'=>'error', 'type'=>'xsd:string')
	)
);
$server->register("submitStatisticWithApplicationID", array("id" => "xsd:string", "type" => "xsd:string", "time" => "xsd:string", "lat" => "xsd:string", "long" => "xsd:string", "deviceID" => "xsd:string", "applicationID" => "xsd:string", "contentID" => "xsd:string", "page" => "xsd:string", "param5" => "xsd:string", "param6" => "xsd:string", "param7" => "xsd:string"), array("return" => "tns:ctSubmitStatisticWithApplicationID"), "urn:SubmitStatisticWithApplicationID", "urn:SubmitStatisticWithApplicationID#submitStatisticWithApplicationID");

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

require($_SERVER["DOCUMENT_ROOT"]."/lib/common.end.php");
?>