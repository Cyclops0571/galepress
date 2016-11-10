<?php

class Ws_v102_Contents_Controller extends Base_Controller
{
    const serviceVersion = 102;
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
			$content = Ws::getContent($contentID, Ws_v102_Contents_Controller::serviceVersion);
            return Response::json($content->getServiceDataDetailed(Ws_v102_Contents_Controller::serviceVersion));
		});
	}

	public function get_coverImage($contentID)
	{
		return Ws::render(function() use ($contentID)
		{

			$height = (int)Input::get('height', '0');
			$width = (int)Input::get('width', '0');
			$requestTypeID = ((int)Input::get('size', '0')) == 1 ? eRequestType::SMALL_IMAGE_FILE : eRequestType::NORMAL_IMAGE_FILE;
			$content = Ws::getContent($contentID);
			$urlPatern = Config::get('custom.url') . "/tr/icerikler/talep?W=%s&H=%s&RequestTypeID=%s&ContentID=%s";
			$url = sprintf($urlPatern, $height, $width, $requestTypeID, (int)$content->ContentID);
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'ContentID' => (int)$content->ContentID,
				'Url' => $url
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