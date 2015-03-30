<?php

class Categories_Controller extends Base_Controller
{
	public $restful = true;
	
	public $page = '';
	public $route = '';
	public $table = '';
	public $pk = '';
	
	public function __construct()
	{
		parent::__construct();
		$this->page = 'categories';
		$this->route = __('route.'.$this->page);
		$this->table = 'Category';
		$this->pk = 'CategoryID';
	}
	
	public function get_index()
    {
		$currentUser = Auth::User();
		
		try
		{
			$appID = (int)Input::get('appID', 0);
			$contentID = (int)Input::get('contentID', 0);
			$type = Input::get('type', '');
			
			$rows = DB::table('Category')
						->where('ApplicationID', '=', $appID)
						->where('StatusID', '=', eStatus::Active)
						->order_by('Name', 'ASC')
						->get();
						
			if((int)Auth::User()->UserTypeID == eUserTypes::Customer)
			{
				$rows = DB::table('Application AS a')
							->join('Category AS t', function($join)
							{
								$join->on('t.ApplicationID', '=', 'a.ApplicationID');
								$join->on('t.StatusID', '=', DB::raw(eStatus::Active));
							})
							->where('a.ApplicationID', '=', $appID)
							->where('a.CustomerID', '=', $currentUser->CustomerID)
							->where('a.StatusID', '=', eStatus::Active)
							->order_by('t.Name', 'ASC')
							->get('t.*');
			}
			
			$data = array(
				'page' => $this->page,
				'route' => $this->route,
				'pk' => $this->pk,
				'rows' => $rows,
				'contentID' => $contentID
			);
			if($type == 'options')
			{
				return View::make('pages.'.Str::lower($this->table).'optionlist', $data);	
			}
			return View::make('pages.'.Str::lower($this->table).'list', $data);
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
			//return Redirect::to('home');
		}
    }
	
	//POST
	public function post_save()
    {
		$currentUser = Auth::User();
		
		$id = (int)Input::get('CategoryCategoryID', '0');
		$applicationID = (int)Input::get('CategoryApplicationID', '0');
		$chk = Common::CheckApplicationOwnership($applicationID);
		$rules = array(
			'CategoryApplicationID' => 'required|integer|min:1',
			'CategoryName' => 'required'
		);
		$v = Validator::make(Input::all(), $rules);
		if ($v->passes() && $chk)
		{
			if($id == 0)
			{
				$s = new Category();
			}
			else
			{
				$chk = Common::CheckCategoryOwnershipWithApplication($applicationID, $id);
				if(!$chk)
				{
					return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
				}
				$s = Category::find($id);
			}
			//$s->ApplicationID = (int)Input::get('CategoryApplicationID');
			$s->ApplicationID = $applicationID;
			$s->Name = Input::get('CategoryName');
			if($id == 0)
			{
				$s->StatusID = eStatus::Active;
				$s->CreatorUserID = $currentUser->UserID;
				$s->DateCreated = new DateTime();
			}
			$s->ProcessUserID = $currentUser->UserID;
			$s->ProcessDate = new DateTime();
			if($id == 0)
			{
				$s->ProcessTypeID = eProcessTypes::Insert;
			}
			else
			{
				$s->ProcessTypeID = eProcessTypes::Update;
			}
			$s->save();
			
			/*
			//Increment application version
			$a = Application::find($applicationID);
			$a->Version = (int)$a->Version + 1;	
			$a->ProcessUserID = $currentUser->UserID;
			$a->ProcessDate = new DateTime();
			$a->ProcessTypeID = eProcessTypes::Update;
			$a->save();
			*/
			
			return "success=".base64_encode("true");
		}
		else
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
		}
    }
	
	public function post_delete()
    {
		$currentUser = Auth::User();
		
		$id = (int)Input::get($this->pk, '0');
		
		$chk = Common::CheckCategoryOwnership($id);
		if($chk)
		{
			$s = Category::find($id);
			if($s)
			{
				$s->StatusID = eStatus::Deleted;
				$s->ProcessUserID = $currentUser->UserID;
				$s->ProcessDate = new DateTime();
				$s->ProcessTypeID = eProcessTypes::Update;
				$s->save();
				
				/*
				//Increment application version
				$a = Application::find($s->ApplicationID);
				$a->Version = (int)$a->Version + 1;	
				$a->ProcessUserID = $currentUser->UserID;
				$a->ProcessDate = new DateTime();
				$a->ProcessTypeID = eProcessTypes::Update;
				$a->save();
				*/
			}
			return "success=".base64_encode("true");
		}
		return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
    }
}