<?php

class Ws_v101_Statistics_Controller extends Base_Controller {

    public $restful = true;

    public function post_create() {
	return Ws::render(function() {
		    //$id, $type, $time, $lat, $long, $deviceID, $applicationID, $contentID, $page, $param5, $param6, $param7
		    $found = false;
		    $id = Input::get('id', '');
		    $deviceID = Input::get('deviceID', '');

		    if (strlen($id) > 0 && strlen($deviceID) > 0) {

			$cnt = Statistic::where('UID', '=', $id)->where('DeviceID', '=', $deviceID)->count();
			if ($cnt > 0) {
			    $found = true;
			}
		    }

		    if (!$found) {
			$page = (int) Input::get('page', '0');
			$contentID = (int) Input::get('contentID', '0');
			$applicationID = (int) Input::get('applicationID', '0');
			$customerID = 0;

			if ($contentID > 0) {
			    $content = Content::where('ContentID', '=', $contentID)->first();
			    if ($content) {
				$applicationID = (int) $content->ApplicationID;
				$application = Application::where('ApplicationID', '=', $applicationID)->first();
				if ($application) {
				    $customerID = (int) $application->CustomerID;
				}
			    }
			} elseif ($applicationID > 0) {
			    $application = Application::where('ApplicationID', '=', $applicationID)->first();
			    if ($application) {
				$customerID = (int) $application->CustomerID;
			    }
			}

			$statistic = new Statistic();
			$statistic->UID = $id;
			$statistic->Type = (int) Input::get('type', '0');
			$statistic->Time = Input::get('time', '');
			$statistic->RequestDate = date("Y-m-d", strtotime($statistic->Time));
			$statistic->Lat = Input::get('lat', '');
			$statistic->Long = Input::get('lon', '');
			if (empty($statistic->Long)) {
			    $statistic->Long = Input::get('long', '');
			}
			$statistic->DeviceID = $deviceID;
			if ($customerID > 0) {
			    $statistic->CustomerID = $customerID;
			}
			if ($applicationID > 0) {
			    $statistic->ApplicationID = $applicationID;
			}
			if ($contentID > 0) {
			    $statistic->ContentID = $contentID;
			}
			if ($page > 0) {
			    $statistic->Page = $page;
			}
			$statistic->Param5 = Input::get('param5', '');
			$statistic->Param6 = Input::get('param6', '');
			$statistic->Param7 = Input::get('param7', '');
			$statistic->save();
		    }
		    return Response::json(array(
				'status' => 0,
				'error' => "",
				'id' => $id
		    ));
		});
    }

}
