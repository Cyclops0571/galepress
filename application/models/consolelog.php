<?php
/**
 * Description of cliLog
 * @property-read int $cli_id Description
 * @property int $cli_type Description
 * @property int $cli_text Description
 * @property int $created_at Description
 * @property int $updated_at Description
 * @author Serdar
 */
class ConsoleLog extends  Eloquent {
	public static $table = 'ConsoleLog';
	public static $key = 'cli_id';
	
	/**
	 * 
	 * @param type $logType
	 * @param type $text
	 */
	public function __construct($logType, $text) {
		parent::__construct();
		$this->cli_type = Config::get('custom.' . strtolower($logType));
		$this->cli_text = $text;
	}
	
}
