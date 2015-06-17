<?php

class Ws_v101_Statistics_Controller extends Base_Controller
{
	public $restful = true;
	
	public function post_create()
	{
		return Ws::render(function()
		{
			//$id, $type, $time, $lat, $long, $deviceID, $applicationID, $contentID, $page, $param5, $param6, $param7
			$found = false;
			$id = Input::get('id', '');
			$deviceID = Input::get('deviceID', '');

			if(strlen($id) > 0 && strlen($deviceID) > 0) {

				$cnt = Statistic::where('UID', '=', $id)->where('DeviceID', '=', $deviceID)->count();
				if($cnt > 0) {
					$found = true;
				}
			}
			
			if(!$found) 
			{
				$page = (int)Input::get('page', '0');
				$contentID = (int)Input::get('contentID', '0');
				$applicationID = (int)Input::get('applicationID', '0');
				$customerID = 0;

				if($contentID > 0) {
					$content = Content::where('ContentID', '=', $contentID)->first();
					if($content) {
						$applicationID = (int)$content->ApplicationID;
						$application = Application::where('ApplicationID', '=', $applicationID)->first();
						if($application) {
							$customerID = (int)$application->CustomerID;
						}
					}
				}
				elseif($applicationID > 0) {
					$application = Application::where('ApplicationID', '=', $applicationID)->first();
					if($application) {
						$customerID = (int)$application->CustomerID;
					}
				}
				
				$s = new Statistic();
				$s->UID = $id;
				$s->Type = (int)Input::get('type', '0');
				$s->Time = Input::get('time', '');
				$s->RequestDate = date("Y-m-d", strtotime($s->Time));
				$s->Lat = Input::get('lat', '');
				$s->Long = Input::get('long', '');
				$s->DeviceID = $deviceID;
				if($customerID > 0) $s->CustomerID = $customerID;
				if($applicationID > 0) $s->ApplicationID = $applicationID;
				if($contentID > 0) $s->ContentID = $contentID;
				if($page > 0) $s->Page = $page;
				$s->Param5 = Input::get('param5', '');
				$s->Param6 = Input::get('param6', '');
				$s->Param7 = Input::get('param7', '');
				$s->save();
			}
			return Response::json(array(
				'status' => 0,
				'error' => "",
				'id' => $id
			));
		});
	}
}