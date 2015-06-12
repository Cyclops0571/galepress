<?php

class Reports_Controller extends Base_Controller {

	public $restful = true;
	public $page = '';
	public $route = '';
	public $caption = '';

	public function __construct() {
		parent::__construct();
		$this->page = 'reports';
		$this->route = __('route.' . $this->page);
		$this->caption = __('common.reports_caption');
	}

	public function get_index() {
		$report = (int) Input::get('r', '101');
		$reportName = __("common.menu_report_" . $report . "_detail")->get();

		$data = array(
			'caption' => $this->caption,
			'route' => $this->route,
			'report' => $report,
			'reportName' => $reportName
		);
		return View::make('pages.reports', $data)
						->nest('filterbar', 'sections.filterbar', $data);
	}

	public function get_show($id) {

		$reportFilter = new ReportFilter();
		$reportFilter->reportID = $id;
		$reportFilter->startDate = Input::get('sd', '') . ' 00:00:00';
		$reportFilter->endDate = Input::get('ed', '') . ' 00:00:00';
		$reportFilter->applicationID = (int) Input::get('applicationID', '0');
		$reportFilter->contentID = (int) Input::get('contentID', '0');
		$reportFilter->customerID = (int) Input::get('customerID', '0');
		$reportFilter->country = Input::get('country', '');
		$reportFilter->city = Input::get('city', '');
		$reportFilter->district = Input::get('district', '');
		$reportFilter->showAsXlsForm = (int) Input::get('xls', '0');
		$reportFilter->map = (int) Input::get('map', '0');
		$reportFilter->rowCount = (int) Config::get('custom.rowcount');
		$reportFilter->userTypeID = Auth::User()->UserTypeID == eUserTypes::Manager ? eUserTypes::Manager : eUserTypes::Customer;

		switch ($reportFilter->reportID) {
			case Report::customerTraficReport :
				$arrReport = Report::getCustomerTrafficReport();
				break;
			case Report::applicationTraficReport :
				$arrReport = Report::getApplicationTrafficReport();
				break;
			case Report::trafficReport :
				$arrReport = Report::getTrafficReport();
				if ((int) $reportFilter->userTypeID == eUserTypes::Customer && (int) $reportFilter->applicationID > 0) {
					array_shift($arrReport['fieldType']);
					array_shift($arrReport['fieldName']);
					array_shift($arrReport['fieldCaption']);
				}
				break;
			case Report::deviceReport :
				$arrReport = Report::getDeviceReport();
				break;
			case Report::downloadReport :
				$arrReport = Report::getDownloadReport();
				if ($reportFilter->userTypeID == eUserTypes::Manager) {
					$arrReport['fieldType'] = array("String", "String", "String", "String", "Number");
					$arrReport['fieldName'] = array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "DownloadCount");
					$arrReport['fieldCaption'] = __("common.reports_columns_report1001_admin")->get();
				}

				//Uygulama secildiyse uygulama adini gosterme!
				if ((int) $reportFilter->userTypeID == eUserTypes::Customer && (int) $reportFilter->applicationID > 0) {
					array_shift($arrReport['fieldType']);
					array_shift($arrReport['fieldName']);
					array_shift($arrReport['fieldCaption']);
				}
				break;
			case Report::customerLocationReport :
				$arrReport = Report::getCostomerLocationReport();
				break;
			case Report::applicationLocationReport :
				$arrReport = Report::getApplicationLocationReport();
				break;
			case Report::locationReport :
				if ($reportFilter->userTypeID == eUserTypes::Manager) {
					$arrReport = array(
						'fieldType' => array("String", "String", "String", "String", "String", "String", "String", "Percent"),
						'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "Country", "City", "District", "Percent"),
						'fieldCaption' => __("common.reports_columns_report1301_admin")->get()
					);
				} else {
					$arrReport = Report::getLocationReport();
					//Uygulama secildiyse uygulama adini gosterme!
					if ((int) $reportFilter->applicationID > 0) {
						array_shift($arrReport['fieldType']);
						array_shift($arrReport['fieldName']);
						array_shift($arrReport['fieldCaption']);
					}
				}

				break;
			case Report::viewReport :
				$arrReport = Report::getViewReport();
				break;
		}

		$rows = $reportFilter->getRows();
//		var_dump($rows); exit;

		if ($reportFilter->map == 1) {
			$arr = array();
			foreach ($rows as $row) {
				array_push($arr, array('lat' => $row->Lat, 'lng' => $row->Long, 'description' => $row->Country));
				//array_push($arr, array('lat' => $row->Lat, 'lng' => $row->Long, 'description' => $row->DownloadCount));
			}
			$data = array(
				'json' => json_encode($arr)
			);
			return View::make('pages.reportmap', $data);
		}

		if ($reportFilter->showAsXlsForm == 1) {
			header("Content-Type: application/octet-stream");
			header("Content-Transfer-Encoding: binary");
			header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			header('Content-Disposition: attachment; filename = "Export ' . date("Y-m-d") . '.xls"');
			header('Pragma: no-cache');

			$schema_insert = "";
			$sep = "\t";
			$arrFieldCaption = $arrReport['fieldCaption'];
			$arrFieldType = $arrReport['fieldType'];
			$arrFieldName = $arrReport['fieldName'];

			for ($i = 0; $i < count($arrFieldCaption); $i++) {
				$schema_insert .= $arrFieldCaption[$i] . $sep;
			}
			$schema_insert .= "\n";

			foreach ($rows as $row) {
				$row = get_object_vars($row);
				$r = "";
				for ($j = 0; $j < count($arrFieldName); $j++) {
					//$arrFieldType = array("String", "String", "String", "Date", "String", "Bit", "Number", "Number", "Number", "Size", "Number", "Size");

					if ($arrFieldType[$j] == 'Percent' || $arrFieldType[$j] == 'DateTime' || $arrFieldType[$j] == 'Date' || $arrFieldType[$j] == 'Bit') {
						$r .= Common::getFormattedData($row[$arrFieldName[$j]], $arrFieldType[$j]) . "" . $sep;
					} else {
						$fieldName = $arrFieldName[$j];
						if (!isset($row[$fieldName]))
							$r .= "NULL" . $sep;
						elseif ($row[$fieldName] != "")
							$r .= "$row[$fieldName]" . $sep;
						else
							$r .= "" . $sep;
					}
				}
				$r = str_replace($sep . "$", "", $r);
				$r = preg_replace("/\r\n|\n\r|\n|\r/", " ", $r);
				$r .= "\t";
				$r = trim($r);
				$r .= "\n";
				$schema_insert .= $r;
			}
			$schema_insert .= "\n";
			echo chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE//IGNORE", $schema_insert);
			return;
		}


		$data = array(
			'report' => $reportFilter->reportID,
			'sd' => $reportFilter->startDate,
			'ed' => $reportFilter->endDate,
			'arrFieldCaption' => $arrReport['fieldCaption'],
			'arrFieldType' => $arrReport['fieldType'],
			'arrFieldName' => $arrReport['fieldName'],
			'rows' => $rows
		);
		return View::make('pages.reportdetail', $data);
	}

	public function get_country() {
		$type = 'country';
		$customerID = (int) Input::get('customerID', '0');
		$applicationID = (int) Input::get('applicationID', '0');
		$contentID = (int) Input::get('contentID', '0');
		$rs = Common::getLocationData($type, $customerID, $applicationID, $contentID);
		$data = array(
			'rows' => $rs
		);
		return View::make('pages.location' . $type . 'optionlist', $data);
	}

	public function get_city() {
		$type = 'city';
		$customerID = (int) Input::get('customerID', '0');
		$applicationID = (int) Input::get('applicationID', '0');
		$contentID = (int) Input::get('contentID', '0');
		$country = Input::get('country', '');
		$rs = Common::getLocationData($type, $customerID, $applicationID, $contentID, $country);
		$data = array(
			'rows' => $rs
		);
		return View::make('pages.location' . $type . 'optionlist', $data);
	}

	public function get_district() {
		$type = 'district';
		$customerID = (int) Input::get('customerID', '0');
		$applicationID = (int) Input::get('applicationID', '0');
		$contentID = (int) Input::get('contentID', '0');
		$country = Input::get('country', '');
		$city = Input::get('city', '');
		$rs = Common::getLocationData($type, $customerID, $applicationID, $contentID, $country, $city);
		$data = array(
			'rows' => $rs
		);
		return View::make('pages.location' . $type . 'optionlist', $data);
	}

}
