<?php

class Ws_v101_Contents_Controller extends Base_Controller
{
	public $restful = true;
	
	public function get_version($contentID)
	{
		return Ws::render(function() use ($contentID)
		{
			$content = Ws::getContent($contentID);
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
				'ContentPrice' => '',
				'ContentCurrency' => $content->Currency(1),
				'ContentIdentifier' => $content->Identifier,
				'ContentIsMaster' => ((int)$content->IsMaster == 1 ? true : false),
				'ContentOrientation' => (int)$content->Orientation,
				'ContentAutoDownload' => ((int)$content->AutoDownload == 1 ? true : false),
				'ContentBlocked' => ((int)$content->Blocked == 1 ? true : false),
				'ContentStatus' => ((int)$content->Status == 1 ? true : false),
				'ContentVersion' => (int)$content->Version,
				'ContentPdfVersion' => (1000 + ($content->PdfVersion === null ? 1 : (int)$content->PdfVersion)),
				'ContentCoverImageVersion' => (1000 + ($content->CoverImageVersion === null ? 1 : (int)$content->CoverImageVersion))
			));
		});
	}

	public function get_coverImage($contentID)
	{
		return Ws::render(function() use ($contentID)
		{
			$requestTypeID = ((int)Input::get('size', '0')) == 1 ? SMALL_IMAGE_FILE : NORMAL_IMAGE_FILE;
			$content = Ws::getContent($contentID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$content->ContentID,
				'Url' => Config::get('custom.url') . "/tr/icerikler/talep?RequestTypeID=".$requestTypeID."&ContentID=".(int)$content->ContentID
			));
		});
	}

	public function get_file($contentID)
	{
		return Ws::render(function() use ($contentID)
		{
			$content = Ws::getContent($contentID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$content->ContentID,
				'Url' => Config::get('custom.url') . "/tr/icerikler/talep?RequestTypeID=1001&ContentID=".(int)$content->ContentID."&Password=".Input::get('password', '')
			));
		});
	}
}