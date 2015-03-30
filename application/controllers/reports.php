<?php

class Reports_Controller extends Base_Controller
{
	public $restful = true;
	
	public $page = '';
	public $route = '';
	public $caption = '';
	
	public function __construct()
	{
		parent::__construct();
		$this->page = 'reports';
		$this->route = __('route.'.$this->page);
		$this->caption = __('common.reports_caption');
	}
	
	public function get_index()
    {
		$report = (int)Input::get('r', '101');
		$reportName = __("common.menu_report_".$report."_detail")->get();

		$data = array(
			'caption' => $this->caption,
			'route' => $this->route,
			'report' => $report,
			'reportName' => $reportName
		);
		return View::make('pages.reports', $data)
			->nest('filterbar', 'sections.filterbar', $data);
    }
	
	public function get_show($id)
    {
		$report = '101';
		$sd = Input::get('sd', '');
		$ed = Input::get('ed', '');
		$customerID = (int)Input::get('customerID', '0');
		$applicationID = (int)Input::get('applicationID', '0');
		$contentID = (int)Input::get('contentID', '0');
		$country = Input::get('country', '');
		$city = Input::get('city', '');
		$district = Input::get('district', '');
		$xls = (int)Input::get('xls', '0');
		$map = (int)Input::get('map', '0');
		$rowcount = (int)Config::get('custom.rowcount');
		//$page = (int)Input::get('page', '0');

		//if(strlen($sd) == 12)
		$sd = $sd.' 00:00:00';
		//if(strlen($ed) == 12) 
		$ed = $ed.' 23:59:59';
		//return 'sd: '.Common::dateWrite($sd).'-ed: '.Common::dateWrite($ed);
		$currentUser = Auth::User();

		if($map == 1) {

			if((int)$id == 1101) {
				$report = '1101';
				$sql = File::get(path('public').'files/report.sql/1101map.sql');
				$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
				$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
				$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
				$sql = str_replace('{COUNTRY}', (Str::length($country) > 0 ? "'$country'" : 'null'), $sql);
				$sql = str_replace('{CITY}', (Str::length($city) > 0 ? "'$city'" : 'null'), $sql);
				$sql = str_replace('{DISTRICT}', (Str::length($district) > 0 ? "'$district'" : 'null'), $sql);
				$rows = DB::table(DB::raw('('.$sql.') t'))->get();
			}
			elseif((int)$id == 1201) {
				$report = '1201';
				$sql = File::get(path('public').'files/report.sql/1201map.sql');
				$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
				$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
				$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
				$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? ''.$applicationID : 'null'), $sql);
				$sql = str_replace('{COUNTRY}', (Str::length($country) > 0 ? "'$country'" : 'null'), $sql);
				$sql = str_replace('{CITY}', (Str::length($city) > 0 ? "'$city'" : 'null'), $sql);
				$sql = str_replace('{DISTRICT}', (Str::length($district) > 0 ? "'$district'" : 'null'), $sql);
				$rows = DB::table(DB::raw('('.$sql.') t'))->get();
			}
			elseif((int)$id == 1301) {
				$report = '1301';
				$sql = File::get(path('public').'files/report.sql/1301map.sql');
				$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
				$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
				$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
				$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? ''.$applicationID : 'null'), $sql);
				$sql = str_replace('{CONTENTID}', ($contentID > 0 ? ''.$contentID : 'null'), $sql);
				$sql = str_replace('{COUNTRY}', (Str::length($country) > 0 ? "'$country'" : 'null'), $sql);
				$sql = str_replace('{CITY}', (Str::length($city) > 0 ? "'$city'" : 'null'), $sql);
				$sql = str_replace('{DISTRICT}', (Str::length($district) > 0 ? "'$district'" : 'null'), $sql);
				$rows = DB::table(DB::raw('('.$sql.') t'))->get();
			}

            $arr = array();
            foreach($rows as $row)
            {
            	array_push($arr, array('lat' => $row->Lat, 'lng' => $row->Long, 'description' => $row->Country));
            	//array_push($arr, array('lat' => $row->Lat, 'lng' => $row->Long, 'description' => $row->DownloadCount));
            }
			$data = array(
				'json' => json_encode($arr)
			);
			return View::make('pages.reportmap', $data);
		}

		if((int)$id == 101) {
			$report = '101';
			$arrReport = array(
				'customer' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "Number", "Number", "Number", "Number", "Number", "Size", "Number", "Size"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationCount", "ApplicationBlockedCount", "ContentCount", "ContentApprovalCount", "ContentBlockedCount", "AmountOfFileSize", "DownloadCount", "AmountOfTraffic"),
					'fieldCaption' => __("common.reports_columns_report101")->get()
				),
				'admin' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "Number", "Number", "Number", "Number", "Number", "Size", "Number", "Size"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationCount", "ApplicationBlockedCount", "ContentCount", "ContentApprovalCount", "ContentBlockedCount", "AmountOfFileSize", "DownloadCount", "AmountOfTraffic"),
					'fieldCaption' => __("common.reports_columns_report101")->get()
				)
			);
			$sql = File::get(path('public').'files/report.sql/101.sql');
			$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
			$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
			$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
			//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		}
		else if((int)$id == 201) {
			$report = '201';
			$arrReport = array(
				'customer' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "Date", "String", "Bit", "Number", "Number", "Number", "Size", "Number", "Size"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ExpirationDate", "ApplicationStatusName", "ApplicationBlocked", "ContentCount", "ContentApprovalCount", "ContentBlockedCount", "AmountOfFileSize", "DownloadCount", "AmountOfTraffic"),
					'fieldCaption' => __("common.reports_columns_report201")->get()
				),
				'admin' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "Date", "String", "Bit", "Number", "Number", "Number", "Size", "Number", "Size"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ExpirationDate", "ApplicationStatusName", "ApplicationBlocked", "ContentCount", "ContentApprovalCount", "ContentBlockedCount", "AmountOfFileSize", "DownloadCount", "AmountOfTraffic"),
					'fieldCaption' => __("common.reports_columns_report201")->get()
				)
			);
			$sql = File::get(path('public').'files/report.sql/201.sql');
			$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
			$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
			$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
			$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? ''.$applicationID : 'null'), $sql);
			//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		}
		else if((int)$id == 301) {
			$report = '301';
			$arrReport = array(
				'customer' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "Size", "Size"),
					'fieldName' => array("ApplicationName", "ContentName", "AmountOfFileSize", "AmountOfTraffic"),
					'fieldCaption' => __("common.reports_columns_report301")->get()
				),
				'admin' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "Date", "String", "Bit", "String", "Bit", "Bit", "Size", "Size"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ExpirationDate", "ApplicationStatusName", "ApplicationBlocked", "ContentName", "ContentApproval", "ContentBlocked", "AmountOfFileSize", "AmountOfTraffic"),
					'fieldCaption' => __("common.reports_columns_report301_admin")->get()
				)
			);
			//Uygulama secildiyse uygulama adini gosterme!
			if ((int)$currentUser->UserTypeID == eUserTypes::Customer && (int)$applicationID > 0) {
				array_shift($arrReport['customer']['columnWidth']);
				array_shift($arrReport['customer']['fieldType']);
				array_shift($arrReport['customer']['fieldName']);
				array_shift($arrReport['customer']['fieldCaption']);
			}
			$sql = File::get(path('public').'files/report.sql/301.sql');
			$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
			$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
			$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
			$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? ''.$applicationID : 'null'), $sql);
			$sql = str_replace('{CONTENTID}', ($contentID > 0 ? ''.$contentID : 'null'), $sql);
			//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
			//return $sql;
		}
		else if((int)$id == 302) {
			$report = '302';
			$arrReport = array(
				'customer' => array(
					'columnWidth' => array("100px", "100px"),
					'fieldType' => array("String", "Number"),
					'fieldName' => array("Device", "DownloadCount"),
					'fieldCaption' => __("common.reports_columns_report302")->get()
				),
				'admin' => array(
					'columnWidth' => array("100px", "100px"),
					'fieldType' => array("String", "Number"),
					'fieldName' => array("Device", "DownloadCount"),
					'fieldCaption' => __("common.reports_columns_report302")->get()
				)
			);
			$sql = File::get(path('public').'files/report.sql/302.sql');
			$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
			$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
			$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
			$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? ''.$applicationID : 'null'), $sql);
			$sql = str_replace('{CONTENTID}', ($contentID > 0 ? ''.$contentID : 'null'), $sql);
			//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		}
		else if((int)$id == 1001) {
			$report = '1001';
			$arrReport = array(
				'customer' => array(
					'columnWidth' => array("100px", "100px", "100px"),
					'fieldType' => array("String", "String", "Number"),
					'fieldName' => array("ApplicationName", "ContentName", "DownloadCount"),
					'fieldCaption' => __("common.reports_columns_report1001")->get()
				),
				'admin' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "String", "Number"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "DownloadCount"),
					'fieldCaption' => __("common.reports_columns_report1001_admin")->get()
				)
			);
			//Uygulama secildiyse uygulama adini gosterme!
			if ((int)$currentUser->UserTypeID == eUserTypes::Customer && (int)$applicationID > 0) {
				array_shift($arrReport['customer']['columnWidth']);
				array_shift($arrReport['customer']['fieldType']);
				array_shift($arrReport['customer']['fieldName']);
				array_shift($arrReport['customer']['fieldCaption']);
			}
			$sql = File::get(path('public').'files/report.sql/1001.sql');
			$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
			$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
			$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
			$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? ''.$applicationID : 'null'), $sql);
			$sql = str_replace('{CONTENTID}', ($contentID > 0 ? ''.$contentID : 'null'), $sql);
			//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		}
		elseif((int)$id == 1101) {
			$report = '1101';
			$arrReport = array(
				'customer' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "String", "String", "Number"),
					'fieldName' => array("CustomerNo", "CustomerName", "Country", "City", "District", "DownloadCount"),
					'fieldCaption' => __("common.reports_columns_report1101")->get()
				),
				'admin' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "String", "String", "Number"),
					'fieldName' => array("CustomerNo", "CustomerName", "Country", "City", "District", "DownloadCount"),
					'fieldCaption' => __("common.reports_columns_report1101")->get()
				)
			);
			$sql = File::get(path('public').'files/report.sql/1101.sql');
			$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
			$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
			$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
			$sql = str_replace('{COUNTRY}', (Str::length($country) > 0 ? "'$country'" : 'null'), $sql);
			$sql = str_replace('{CITY}', (Str::length($city) > 0 ? "'$city'" : 'null'), $sql);
			$sql = str_replace('{DISTRICT}', (Str::length($district) > 0 ? "'$district'" : 'null'), $sql);
			//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		}
		elseif((int)$id == 1201) {
			$report = '1201';
			$arrReport = array(
				'customer' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "String", "String", "String", "Number"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "Country", "City", "District", "DownloadCount"),
					'fieldCaption' => __("common.reports_columns_report1201")->get()
				),
				'admin' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "String", "String", "String", "Number"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "Country", "City", "District", "DownloadCount"),
					'fieldCaption' => __("common.reports_columns_report1201")->get()
				)
			);
			$sql = File::get(path('public').'files/report.sql/1201.sql');
			$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
			$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
			$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
			$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? ''.$applicationID : 'null'), $sql);
			$sql = str_replace('{COUNTRY}', (Str::length($country) > 0 ? "'$country'" : 'null'), $sql);
			$sql = str_replace('{CITY}', (Str::length($city) > 0 ? "'$city'" : 'null'), $sql);
			$sql = str_replace('{DISTRICT}', (Str::length($district) > 0 ? "'$district'" : 'null'), $sql);
			//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		}
		elseif((int)$id == 1301) {
			$report = '1301';
			$arrReport = array(
				'customer' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "String", "String", "Percent"),
					'fieldName' => array("ApplicationName", "ContentName", "Country", "City", "District", "Percent"),
					'fieldCaption' => __("common.reports_columns_report1301")->get()
				),
				'admin' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "String", "String", "String", "String", "Percent"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "Country", "City", "District", "Percent"),
					'fieldCaption' => __("common.reports_columns_report1301_admin")->get()
				)
			);
			//Uygulama secildiyse uygulama adini gosterme!
			if ((int)$currentUser->UserTypeID == eUserTypes::Customer && (int)$applicationID > 0) {
				array_shift($arrReport['customer']['columnWidth']);
				array_shift($arrReport['customer']['fieldType']);
				array_shift($arrReport['customer']['fieldName']);
				array_shift($arrReport['customer']['fieldCaption']);
			}
			$sql = File::get(path('public').'files/report.sql/1301.sql');
			$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
			$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
			$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
			$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? ''.$applicationID : 'null'), $sql);
			$sql = str_replace('{CONTENTID}', ($contentID > 0 ? ''.$contentID : 'null'), $sql);
			$sql = str_replace('{COUNTRY}', (Str::length($country) > 0 ? "'$country'" : 'null'), $sql);
			$sql = str_replace('{CITY}', (Str::length($city) > 0 ? "'$city'" : 'null'), $sql);
			$sql = str_replace('{DISTRICT}', (Str::length($district) > 0 ? "'$district'" : 'null'), $sql);
			//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		}
		elseif((int)$id == 1302) {
			$report = '1302';
			$arrReport = array(
				'customer' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "String", "String", "String", "String", "Number", "Number", "Number"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "Country", "City", "District", "Page", "People", "Duration"),
					'fieldCaption' => __("common.reports_columns_report1302")->get()
				),
				'admin' => array(
					'columnWidth' => array("100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px", "100px"),
					'fieldType' => array("String", "String", "String", "String", "String", "String", "String", "Number", "Number", "Number"),
					'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "Country", "City", "District", "Page", "People", "Duration"),
					'fieldCaption' => __("common.reports_columns_report1302")->get()
				)
			);
			$sql = File::get(path('public').'files/report.sql/1302.sql');
			$sql = str_replace('{SD}', Common::dateWrite($sd, false), $sql);
			$sql = str_replace('{ED}', Common::dateWrite($ed, false), $sql);
			$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? ''.$customerID : 'null'), $sql);
			$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? ''.$applicationID : 'null'), $sql);
			$sql = str_replace('{CONTENTID}', ($contentID > 0 ? ''.$contentID : 'null'), $sql);
			$sql = str_replace('{COUNTRY}', (Str::length($country) > 0 ? "'$country'" : 'null'), $sql);
			$sql = str_replace('{CITY}', (Str::length($city) > 0 ? "'$city'" : 'null'), $sql);
			$sql = str_replace('{DISTRICT}', (Str::length($district) > 0 ? "'$district'" : 'null'), $sql);
			//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		}

		$reportUser = 'customer';
		if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
			$reportUser = 'admin';
		}
		
		if($xls == 1) {
			header("Content-Type: application/octet-stream"); 
			header("Content-Transfer-Encoding: binary"); 
			header('Expires: '.gmdate('D, d M Y H:i:s').' GMT'); 
			header('Content-Disposition: attachment; filename = "Export '.date("Y-m-d").'.xls"'); 
			header('Pragma: no-cache'); 

			$schema_insert = "";
			$sep = "\t";
			/*
			'arrColumnWidth' => $arrReport[$reportUser]['columnWidth'],
			'arrFieldCaption' => $arrReport[$reportUser]['fieldCaption'],
			'arrFieldType' => $arrReport[$reportUser]['fieldType'],
			'arrFieldName' => $arrReport[$reportUser]['fieldName'],
			*/
			$arrFieldCaption = $arrReport[$reportUser]['fieldCaption'];
			$arrFieldType = $arrReport[$reportUser]['fieldType'];
			$arrFieldName = $arrReport[$reportUser]['fieldName'];

			for ($i = 0; $i < count($arrFieldCaption); $i++) {
				$schema_insert .= $arrFieldCaption[$i].$sep;
			}
			$schema_insert .= "\n";

			$rows = DB::table(DB::raw('('.$sql.') t'))->get();
	        foreach($rows as $row) {
	        	$row = get_object_vars($row);
	        	$r = "";
		        for($j = 0; $j < count($arrFieldName); $j++)
		        {
		        	//$arrFieldType = array("String", "String", "String", "Date", "String", "Bit", "Number", "Number", "Number", "Size", "Number", "Size");

		        	if($arrFieldType[$j] == 'Percent' || $arrFieldType[$j] == 'DateTime' || $arrFieldType[$j] == 'Date' || $arrFieldType[$j] == 'Bit')
		        	{
		        		$r .= Common::getFormattedData($row[$arrFieldName[$j]], $arrFieldType[$j])."".$sep;
		        	}
		        	else {
		        		$fieldName = $arrFieldName[$j];
			            if(!isset($row[$fieldName]))
			                $r .= "NULL".$sep;
			            elseif ($row[$fieldName] != "")
			                $r .= "$row[$fieldName]".$sep;
			            else
			                $r .= "".$sep;
		        	}
		        }
		        $r = str_replace($sep."$", "", $r);
		        $r = preg_replace("/\r\n|\n\r|\n|\r/", " ", $r);
		        $r .= "\t";
		        $r = trim($r);
		        $r .= "\n";
        		$schema_insert .= $r;
	        }
	        $schema_insert .= "\n";
	        echo chr(255).chr(254).iconv("UTF-8", "UTF-16LE//IGNORE", $schema_insert); 
	        return;
		}

		/*
		//$rs = DB::table(DB::raw('('.$sql.') t'));
		//$count = $rs->count();
		//$results = $rs
			//->for_page($page, $rowcount)
			//->get();
		$results = $rs->get();
		$rows = Paginator::make($results, $count, $rowcount);
		*/
		//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		$rows = DB::table(DB::raw('('.$sql.') t'))->paginate($rowcount);
		//return var_dump($rows->results);

		$data = array(
			'report' => $report,
			'sd' => $sd,
			'ed' => $ed,
			'arrColumnWidth' => $arrReport[$reportUser]['columnWidth'],
			'arrFieldCaption' => $arrReport[$reportUser]['fieldCaption'],
			'arrFieldType' => $arrReport[$reportUser]['fieldType'],
			'arrFieldName' => $arrReport[$reportUser]['fieldName'],
			'rows' => $rows
		);
		return View::make('pages.reportdetail', $data);
    }
    
    public function get_country()
    {
    	$type = 'country';
    	$customerID = (int)Input::get('customerID', '0');
		$applicationID = (int)Input::get('applicationID', '0');
		$contentID = (int)Input::get('contentID', '0');
		$rs = Common::getLocationData($type, $customerID, $applicationID, $contentID);
		$data = array(
			'rows' => $rs
		);
		return View::make('pages.location'.$type.'optionlist', $data);
    }

    public function get_city()
    {
    	$type = 'city';
    	$customerID = (int)Input::get('customerID', '0');
		$applicationID = (int)Input::get('applicationID', '0');
		$contentID = (int)Input::get('contentID', '0');
		$country = Input::get('country', '');
		$rs = Common::getLocationData($type, $customerID, $applicationID, $contentID, $country);
		$data = array(
			'rows' => $rs
		);
		return View::make('pages.location'.$type.'optionlist', $data);
    }

    public function get_district()
    {
    	$type = 'district';
    	$customerID = (int)Input::get('customerID', '0');
		$applicationID = (int)Input::get('applicationID', '0');
		$contentID = (int)Input::get('contentID', '0');
		$country = Input::get('country', '');
		$city = Input::get('city', '');
		$rs = Common::getLocationData($type, $customerID, $applicationID, $contentID, $country, $city);
		$data = array(
			'rows' => $rs
		);
		return View::make('pages.location'.$type.'optionlist', $data);
    }
}