<?php

class ReportFilter {

	public $reportID = 101;
	public $startDate = '';
	public $endDate = '';
	public $customerID = 0;
	public $applicationID = 0;
	public $contentID = 0;
	public $country = '';
	public $city = '';
	public $district = '';
	public $showAsXlsForm = 0;
	public $map = 0;
	public $rowCount = 0;
	public $userTypeID = eUserTypes::Customer;

	public function getReportSqlFile() {
		$filePath = "files/report.sql/" . $this->reportID . ($this->map ? "map.sql" : ".sql");
		return File::get($filePath);
	}
	
	public static function getSqlReplecements() {
		return array(
			'{SD}' => Common::dateWrite($this->startDate, false),
			'{ED}' => Common::dateWrite($this->endDate, false),
			'{CUSTOMERID}' => ($this->customerID > 0 ? '' . $this->customerID : 'null'),
			'{APPLICATIONID}' => ($this->applicationID > 0 ? '' . $this->applicationID : 'null'),
			'{CONTENTID}', ($this->contentID ? 'null' : ''. $this->contentID),
			'{COUNTRY}' => ($this->country  ? 'null' : "'$this->country'"),
			'{CITY}' => ($this->city > 0 ? 'null' : "'$this->city'"),
			'{DISTRICT}' => ($this->district? 'null' : "'$this->district'"),
			
		);
	}

}
