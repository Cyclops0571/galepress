<?php

class ClientContent extends Laravel\Database\Eloquent\Model{
    public static $table = 'ClientContent';
    public static $key = 'ClientContentID';

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}

	parent::save();
    }

    /**
     * 
     * @param int $ClientContentID
     * @return ClientContent
     */
    public static function find($ClientContentID, $columns = array('*')) {
	return ClientContent::where(self::$key, "=", $ClientContentID)->first($columns);
    }
    
    /**
     * 
     * @return Client
     */
    public function Client() {
	return $this->belongs_to('Client', 'ClientID')->first();
    }
    
    
}
