<?php

class GroupCode extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'GroupCode';
	public static $key = 'GroupCodeID';

	public function DisplayName($languageID)
	{
		/*
		$gcl = DB::table('GroupCodeLanguage')
				->where('GroupCodeID', '=', $this->GroupCodeID)
				->where('LanguageID', '=', (int)Session::get('language_id'))
				->first();
		if($gcl)
		{
			return $gcl->DisplayName;
		}
		return '';
		*/
		$gcl = $this->belongs_to('GroupCodeLanguage', 'GroupCodeID')->where('LanguageID', '=', $languageID)->first();
		if($gcl) {
			return $gcl->DisplayName;
		}
		return '';
	}
}