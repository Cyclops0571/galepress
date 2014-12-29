<?php

class Ws_v101_Contents_Controller extends Base_Controller
{
	public $restful = true;
	
	public function get_version($contentID)
	{
		return Ws::render(function() use ($contentID)
		{
			$content = Ws::getContent($contentID);
			$application = Ws::getApplication($content->ApplicationID);
			$customer = Ws::getCustomer($application->CustomerID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$content->ContentID,
				'ContentBlocked' => ((int)$content->Blocked == 1 ? true : false),
				'ContentStatus' => ((int)$content->Status == 1 ? true : false),
				'ContentVersion' => (int)$content->Version
			));
		});
	}

	public function get_detail($contentID)
	{
		return Ws::render(function() use ($contentID)
		{
			$content = Ws::getContent($contentID);
			$application = Ws::getApplication($content->ApplicationID);
			$customer = Ws::getCustomer($application->CustomerID);
			$categories = Ws::getContentCategories($contentID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$content->ContentID,
				'ContentName' => $content->Name,
				'ContentDetail' => $content->Detail,
				'ContentCategories' => $categories,
				'ContentMonthlyName' => $content->MonthlyName,
				'ContentIsProtected' => ((int)$content->IsProtected == 1 ? true : false),
				'ContentIsBuyable' => ((int)$content->IsBuyable == 1 ? true : false),
				'ContentPrice' => $content->Price,
				'ContentCurrency' => $content->Currency(1),
				'ContentIdentifier' => $content->Identifier,
				'ContentAutoDownload' => ((int)$content->AutoDownload == 1 ? true : false),
				'ContentBlocked' => ((int)$content->Blocked == 1 ? true : false),
				'ContentStatus' => ((int)$content->Status == 1 ? true : false),
				'ContentVersion' => (int)$content->Version,
				'ContentPdfVersion' => (1000 + ($content->PdfVersion === null ? 1 : (int)$content->PdfVersion)),
				'ContentCoverImageVersion' => (1000 + ($content->CoverImageVersion === null ? 1 : (int)$content->CoverImageVersion))
			));
			/*
			$arr = array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$content->ContentID,
				'ContentName' => $content->Name,
				'ContentDetail' => $content->Detail
			);

			$withCategories = Input::get('withCategories', 'false');
			if($withCategories === 'true') {
				$categories = Ws::getContentCategories($contentID);
				$arr = array_merge($arr, array(
					'ContentCategories' => $categories
				));
			}
			else {
				$arr = array_merge($arr, array(
					'ContentCategoryID' => 0,
					'ContentCategoryName' => ""
				));
			}
			
			$arr = array_merge($arr, array(
				'ContentMonthlyName' => $content->MonthlyName,
				'ContentIsProtected' => ((int)$content->IsProtected == 1 ? true : false),
				'ContentIsBuyable' => ((int)$content->IsBuyable == 1 ? true : false),
				'ContentPrice' => $content->Price,
				'ContentCurrency' => $content->Currency(1),
				'ContentIdentifier' => $content->Identifier,
				'ContentAutoDownload' => ((int)$content->AutoDownload == 1 ? true : false),
				'ContentBlocked' => ((int)$content->Blocked == 1 ? true : false),
				'ContentStatus' => ((int)$content->Status == 1 ? true : false),
				'ContentVersion' => (int)$content->Version,
				'ContentPdfVersion' => (1000 + ($content->PdfVersion === null ? 1 : (int)$content->PdfVersion)),
				'ContentCoverImageVersion' => (1000 + ($content->CoverImageVersion === null ? 1 : (int)$content->CoverImageVersion))
			));
			*/
		});
	}

	public function get_coverImage($contentID)
	{
		return Ws::render(function() use ($contentID)
		{
			$size = (int)Input::get('size', '0');
			//size = 0 Normal
			//size = 1 Small
			$requestTypeID = '1101';
			if($size == 1) {
				$requestTypeID = '1102';
			}
			$content = Ws::getContent($contentID);
			$application = Ws::getApplication($content->ApplicationID);
			$customer = Ws::getCustomer($application->CustomerID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$content->ContentID,
				'Url' => "http://www.galepress.com/tr/icerikler/talep?RequestTypeID=".$requestTypeID."&ContentID=".(int)$content->ContentID
			));
		});
	}

	public function get_file($contentID)
	{
		return Ws::render(function() use ($contentID)
		{
			$content = Ws::getContent($contentID);
			$application = Ws::getApplication($content->ApplicationID);
			$customer = Ws::getCustomer($application->CustomerID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$content->ContentID,
				'Url' => "http://www.galepress.com/tr/icerikler/talep?RequestTypeID=1001&ContentID=".(int)$content->ContentID."&Password=".Input::get('password', '')
			));
		});
	}
}