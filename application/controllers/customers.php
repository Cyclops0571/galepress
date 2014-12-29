<?php

class Customers_Controller extends Base_Controller
{
	public $restful = true;
	
	public $page = '';
	public $route = '';
	public $table = '';
	public $pk = '';
	public $caption = '';
	public $detailcaption = '';
	public $fields;
	
	public function __construct()
	{
		$this->page = 'customers';
		$this->route = __('route.'.$this->page);
		$this->table = 'Customer';
		$this->pk = 'CustomerID';
		$this->caption = __('common.customers_caption');
		$this->detailcaption = __('common.customers_caption_detail');
		$this->fields = array(
				0 => array('35px', __('common.customers_list_column1'), ''),
				1 => array('55px', __('common.customers_list_column2'), 'ApplicationCount'),
				2 => array('55px', __('common.customers_list_column3'), 'UserCount'),
				3 => array('125px', __('common.customers_list_column4'), 'CustomerNo'),
				4 => array('', __('common.customers_list_column5'), 'CustomerName'),
				5 => array('125px', __('common.customers_list_column6'), 'Phone1'),
				6 => array('175px', __('common.customers_list_column7'), 'Email'),
				7 => array('75px', __('common.customers_list_column8'), 'CustomerID')
			);
	}
	
	public function get_index()
    {
		$currentUser = Auth::User();
		
		if((int)$currentUser->UserTypeID == eUserTypes::Manager) 
		{
			try
			{
				$search = Input::get('search', '');
				$sort = Input::get('sort', $this->pk);
				$sort_dir = Input::get('sort_dir', 'DESC');
				$rowcount = (int)Config::get('custom.rowcount');
				$p = Input::get('page', 1);
				$option = (int)Input::get('option', 0);
				
				$sql = ''.
						'SELECT '.
							'(SELECT COUNT(*) FROM `Application` WHERE CustomerID=c.CustomerID AND StatusID=1) AS ApplicationCount, '.
							'(SELECT COUNT(*) FROM `User` WHERE CustomerID=c.CustomerID AND StatusID=1) AS UserCount, '.
							'c.CustomerNo, '.
							'c.CustomerName, '.
							'c.Phone1, '.
							'c.Email, '.
							'c.CustomerID '.
						'FROM `Customer` AS c '.
						'WHERE c.StatusID=1';
				
				$rs = DB::table(DB::raw('('.$sql.') t'))
					->where(function($query) use($search)
					{
						if(strlen(trim($search)) > 0)
						{
							$query->where('ApplicationCount', 'LIKE', '%'.$search.'%');
							$query->or_where('UserCount', 'LIKE', '%'.$search.'%');
							$query->or_where('CustomerNo', 'LIKE', '%'.$search.'%');
							$query->or_where('CustomerName', 'LIKE', '%'.$search.'%');
							$query->or_where('Phone1', 'LIKE', '%'.$search.'%');
							$query->or_where('Email', 'LIKE', '%'.$search.'%');
							$query->or_where('CustomerID', 'LIKE', '%'.$search.'%');
						}
					})
					->order_by($sort, $sort_dir);
				
				if($option == 1)
				{
					$data = array(
						'rows' => $rs->get()
					);
					return View::make('pages.'.Str::lower($this->table).'optionlist', $data);
				}
				
				$count = $rs->count();
				$results = $rs
					->for_page($p, $rowcount)
					->get();
				
				$rows = Paginator::make($results, $count, $rowcount);
				
				$data = array(
					'page' => $this->page,
					'route' => $this->route,
					'caption' => $this->caption,
					'pk' => $this->pk,
					'fields' => $this->fields,
					'search' => $search,
					'sort' => $sort,
					'sort_dir' => $sort_dir,
					'rows' => $rows
				);
				return View::make('pages.'.Str::lower($this->table).'list', $data)
					->nest('filterbar', 'sections.filterbar', $data)
					->nest('commandbar', 'sections.commandbar', $data);
			}
			catch(Exception $e)
			{
				//throw new Exception($e->getMessage());
				return Redirect::to(__('route.home'));
			}
		}
		return Redirect::to(__('route.home'));
    }
	
	public function get_new()
    {
		$currentUser = Auth::User();
		
		if((int)$currentUser->UserTypeID == eUserTypes::Manager) 
		{
			$data = array(
				'page' => $this->page,
				'route' => $this->route,
				'caption' => $this->caption,
				'detailcaption' => $this->detailcaption
			);
			return View::make('pages.'.Str::lower($this->table).'detail', $data)
				->nest('filterbar', 'sections.filterbar', $data);
		}
		return Redirect::to(__('route.home'));
    }
	
    public function get_show($id)
    {
		$currentUser = Auth::User();
		
		if((int)$currentUser->UserTypeID == eUserTypes::Manager) 
		{
			$row = Customer::find($id);
			if($row)
			{
				$data = array(
					'page' => $this->page,
					'route' => $this->route,
					'caption' => $this->caption,
					'detailcaption' => $this->detailcaption,
					'row' => $row
				);
				return View::make('pages.'.Str::lower($this->table).'detail', $data)
					->nest('filterbar', 'sections.filterbar', $data);
			}
			else 
			{
				return Redirect::to($this->route);
			}
		}
		return Redirect::to(__('route.home'));
    }
	
	//POST
	public function post_save()
    {
		$currentUser = Auth::User();
		
		if((int)$currentUser->UserTypeID == eUserTypes::Manager) 
		{
			$id = (int)Input::get($this->pk, '0');
			
			$rules = array(
				'CustomerNo' => 'required',
				'CustomerName' => 'required'
			);
			$v = Validator::make(Input::all(), $rules);
			if ($v->passes())
			{
				if($id == 0)
				{
					$s = new Customer();
				}
				else
				{
					$s = Customer::find($id);
				}
				$s->CustomerNo = Input::get('CustomerNo');
				$s->CustomerName = Input::get('CustomerName');
				$s->Address = Input::get('Address');
				$s->City = Input::get('City');
				$s->Country = Input::get('Country');
				$s->Phone1 = Input::get('Phone1');
				$s->Phone2 = Input::get('Phone2');
				$s->Email = Input::get('Email');
				$s->BillName = Input::get('BillName');
				$s->BillAddress = Input::get('BillAddress');
				$s->BillTaxOffice = Input::get('BillTaxOffice');
				$s->BillTaxNumber = Input::get('BillTaxNumber');
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
				return "success=".base64_encode("true");
			}
			else
			{
				return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
			}
		}
		return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
    }
	
	public function post_delete()
    {
		$currentUser = Auth::User();
		
		if((int)$currentUser->UserTypeID == eUserTypes::Manager) 
		{
			$id = (int)Input::get($this->pk, '0');
			
			$s = Customer::find($id);
			if($s)
			{
				$s->StatusID = eStatus::Deleted;
				$s->ProcessUserID = $currentUser->UserID;
				$s->ProcessDate = new DateTime();
				$s->ProcessTypeID = eProcessTypes::Update;
				$s->save();
			}
			return "success=".base64_encode("true");
		}
		return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
    }
}