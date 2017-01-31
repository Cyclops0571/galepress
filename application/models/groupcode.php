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

	public static function getGroupCodes() {
        return DB::table('GroupCode AS gc')
            ->join('GroupCodeLanguage AS gcl', function ($join) {
                /** @var \Laravel\Database\Query\Join $join */
                $join->on('gcl.GroupCodeID', '=', 'gc.GroupCodeID');
                $join->on('gcl.LanguageID', '=', DB::raw((int)Session::get('language_id')));
            })
            ->where('gc.GroupName', '=', 'Currencies')
            ->where('gc.StatusID', '=', eStatus::Active)
            ->order_by('gc.DisplayOrder', 'ASC')
            ->order_by('gcl.DisplayName', 'ASC')
            ->get();
    }
}