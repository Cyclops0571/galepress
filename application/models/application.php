<?php

class Application extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'Application';
	public static $key = 'ApplicationID';
	
	public function Customer()
	{
		return $this->belongs_to('Customer', 'CustomerID')->first();
	}
	
	public function ApplicationStatus($languageID)
	{
		if((int)$this->ApplicationStatusID > 0)
		{
			$gc = GroupCode::find($this->ApplicationStatusID)->first();
			if($gc) {
				return $gc->DisplayName($languageID);	
			}
		}
		return '';
	}
	
	public function Package()
	{
		return $this->belongs_to('Package', 'PackageID')->first();
	}

	public function Categories($statusID)
	{
		return $this->has_many('Category', $this->key())->where('StatusID', '=', $statusID)->get();
	}
	
	public function Contents($statusID)
	{
		return $this->has_many('Content', $this->key())->where('StatusID', '=', $statusID)->get();
	}
	
	public function Users()
	{
		return $this->has_many('ApplicationUser', $this->key());
	}
	
	public function Tags()
	{
		return $this->has_many('ApplicationTag', $this->key());
	}
}