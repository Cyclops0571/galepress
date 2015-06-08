<?php

class Report extends Eloquent {

	const customerTraficReport = 101; //admin
	const applicationTraficReport = 201; //admin
	const trafficReport = 301;
	const deviceReport = 302;
	const downloadReport = 1001;
	const customerLocationReport = 1101;
	const applicationLocationReport = 1201; //admin
	const locationReport = 1301; //admin
	const viewReport = 1302;

	/**
	 * 
	 * @param ReportFilter $reportFilter
	 * @return type
	 */
	public static function getCustomerTrafficReport($reportFilter) {
		$arrReport = array(
			'fieldType' => array("String", "String", "Number", "Number", "Number", "Number", "Number", "Size", "Number", "Size"),
			'fieldName' => array("CustomerNo", "CustomerName", "ApplicationCount", "ApplicationBlockedCount", "ContentCount", "ContentApprovalCount", "ContentBlockedCount", "AmountOfFileSize", "DownloadCount", "AmountOfTraffic"),
			'fieldCaption' => __("common.reports_columns_report101")->get()
		);
		$sql = File::get(path('public') . 'files/report.sql/101.sql');
		return $sql;
	}

	public static function getApplicationTrafficReport($reportFilter) {
		$arrReport = array(
			'fieldType' => array("String", "String", "String", "Date", "String", "Bit", "Number", "Number", "Number", "Size", "Number", "Size"),
			'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ExpirationDate", "ApplicationStatusName", "ApplicationBlocked", "ContentCount", "ContentApprovalCount", "ContentBlockedCount", "AmountOfFileSize", "DownloadCount", "AmountOfTraffic"),
			'fieldCaption' => __("common.reports_columns_report201")->get()
		);
		$sql = File::get(path('public') . 'files/report.sql/201.sql');

		//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
	}

	/**
	 * 
	 * @param ReportFilter $reportFilter
	 * @return type
	 */
	public static function getTrafficReport($reportFilter) {
		$arrReport = array(
			'fieldType' => array("String", "String", "Size", "Size"),
			'fieldName' => array("ApplicationName", "ContentName", "AmountOfFileSize", "AmountOfTraffic"),
			'fieldCaption' => __("common.reports_columns_report301")->get()
		);
		if ($reportFilter->userTypeID == eUserTypes::Manager) {
			$arrReport['fieldType'] = array("String", "String", "String", "Date", "String", "Bit", "String", "Bit", "Bit", "Size", "Size");
			$arrReport['fieldName'] = array("CustomerNo", "CustomerName", "ApplicationName", "ExpirationDate", "ApplicationStatusName", "ApplicationBlocked", "ContentName", "ContentApproval", "ContentBlocked", "AmountOfFileSize", "AmountOfTraffic");
			$arrReport['fieldCaption'] = __("common.reports_columns_report301_admin")->get();
		}

		//Uygulama secildiyse uygulama adini gosterme!
		if ((int) $reportFilter->userTypeID == eUserTypes::Customer && (int) $applicationID > 0) {
			array_shift($arrReport['columnWidth']);
			array_shift($arrReport['fieldType']);
			array_shift($arrReport['fieldName']);
			array_shift($arrReport['fieldCaption']);
		}
		$sql = File::get(path('public') . 'files/report.sql/301.sql');

		//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		//return $sql;
	}

	/**
	 * 
	 * @param ReportFilter $reportFilter
	 * @return type
	 */
	public static function getDeviceReport($reportFilter) {
		$arrReport = array(
			'fieldType' => array("String", "Number"),
			'fieldName' => array("Device", "DownloadCount"),
			'fieldCaption' => __("common.reports_columns_report302")->get()
		);
		$sql = File::get(path('public') . 'files/report.sql/302.sql');

		//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
	}

	/**
	 * 
	 * @param ReportFilter $reportFilter
	 * @return type
	 */
	public static function getDownloadReport($reportFilter) {
		$arrReport = array(
			'fieldType' => array("String", "String", "Number"),
			'fieldName' => array("ApplicationName", "ContentName", "DownloadCount"),
			'fieldCaption' => __("common.reports_columns_report1001")->get()
		);
		if ($reportFilter->userTypeID == eUserTypes::Manager) {
			$arrReport['fieldType'] = array("String", "String", "String", "String", "Number");
			$arrReport['fieldName'] = array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "DownloadCount");
			$arrReport['fieldCaption'] = __("common.reports_columns_report1001_admin")->get();
		}

		//Uygulama secildiyse uygulama adini gosterme!
		if ((int) $reportFilter->userTypeID == eUserTypes::Customer && (int) $reportFilter->applicationID > 0) {
			array_shift($arrReport['columnWidth']);
			array_shift($arrReport['fieldType']);
			array_shift($arrReport['fieldName']);
			array_shift($arrReport['fieldCaption']);
		}
		$sql = File::get(path('public') . 'files/report.sql/1001.sql');

		//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
	}

	/**
	 * 
	 * @param ReportFilter $reportFilter
	 * @return type
	 */
	public static function getCostomerLocationReport($reportFilter) {
		$arrReport = array(
			'fieldType' => array("String", "String", "String", "String", "String", "Number"),
			'fieldName' => array("CustomerNo", "CustomerName", "Country", "City", "District", "DownloadCount"),
			'fieldCaption' => __("common.reports_columns_report1101")->get()
		);

		$replecements = $sql = File::get(path('public') . 'files/report.sql/1101.sql');


		//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
		$sql = File::get(path('public') . 'files/report.sql/1101map.sql');

		$rows = DB::table(DB::raw('(' . $sql . ') t'))->get();
	}
	/**
	 * 
	 * @param ReportFilter $reportFilter
	 * @return type
	 */
	public static function getApplicationLocationReport($reportFilter) {
		$arrReport = array(
			'fieldType' => array("String", "String", "String", "String", "String", "String", "Number"),
			'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "Country", "City", "District", "DownloadCount"),
			'fieldCaption' => __("common.reports_columns_report1201")->get()
		);
		$sql = File::get(path('public') . 'files/report.sql/1201.sql');
		//$rows = DB::table(DB::raw('('.$sql.') t'))->get();

		$sql = File::get(path('public') . 'files/report.sql/1201map.sql');
		$rows = DB::table(DB::raw('(' . $sql . ') t'))->get();
	}

	/**
	 * 
	 * @param ReportFilter $reportFilter
	 * @return type
	 */
	public static function getLocationReport($reportFilter) {
		$arrReport = array(
			'customer' => array(
				'fieldType' => array("String", "String", "String", "String", "String", "Percent"),
				'fieldName' => array("ApplicationName", "ContentName", "Country", "City", "District", "Percent"),
				'fieldCaption' => __("common.reports_columns_report1301")->get()
			),
			'admin' => array(
				'fieldType' => array("String", "String", "String", "String", "String", "String", "String", "Percent"),
				'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "Country", "City", "District", "Percent"),
				'fieldCaption' => __("common.reports_columns_report1301_admin")->get()
			)
		);
		//Uygulama secildiyse uygulama adini gosterme!
		if ((int) $currentUser->UserTypeID == eUserTypes::Customer && (int) $applicationID > 0) {
			array_shift($arrReport['customer']['columnWidth']);
			array_shift($arrReport['customer']['fieldType']);
			array_shift($arrReport['customer']['fieldName']);
			array_shift($arrReport['customer']['fieldCaption']);
		}
		$sql = File::get(path('public') . 'files/report.sql/1301.sql');
		//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
	}

	/**
	 * 
	 * @param ReportFilter $reportFilter
	 * @return type
	 */
	public static function getViewReport($reportFilter) {
		$arrReport = array(
			'fieldType' => array("String", "String", "String", "String", "String", "String", "String", "Number", "Number", "Number"),
			'fieldName' => array("CustomerNo", "CustomerName", "ApplicationName", "ContentName", "Country", "City", "District", "Page", "People", "Duration"),
			'fieldCaption' => __("common.reports_columns_report1302")->get()
		);

		$sql = File::get(path('public') . 'files/report.sql/1302.sql');
		//$rows = DB::table(DB::raw('('.$sql.') t'))->get();
	}

}
