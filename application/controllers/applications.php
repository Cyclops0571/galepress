<?php

class Applications_Controller extends Base_Controller
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
		$this->page = 'applications';
		$this->route = __('route.'.$this->page);
		$this->table = 'Application';
		$this->pk = 'ApplicationID';
		$this->caption = __('common.applications_caption');
		$this->detailcaption = __('common.applications_caption_detail');
		$this->fields = array(
				0 => array('35px', __('common.applications_list_column1'), ''),
				1 => array('55px', __('common.applications_list_column2'), 'ContentCount'),
				2 => array('175px', __('common.applications_list_column3'), 'CustomerName'),
				3 => array('', __('common.applications_list_column4'), 'Name'),
				4 => array('155px', __('common.applications_list_column5'), 'ApplicationStatusName'),
				5 => array('75px', __('common.applications_list_column6'), 'PackageName'),
				6 => array('75px', __('common.applications_list_column7'), 'Blocked'),
				7 => array('100px', __('common.applications_list_column8'), 'Status'),
				8 => array('90px', __('common.applications_list_column9'), 'ExpirationDate'),
				9 => array('75px', __('common.applications_list_column10'), 'ApplicationID')
			);
	}
			
	public function get_index()
    {
		$currentUser = Auth::User();
		
		if((int)$currentUser->UserTypeID == eUserTypes::Manager) 
		{
			try
			{
				$customerID = (int)Input::get('customerID', 0);
				$search = Input::get('search', '');
				$sort = Input::get('sort', $this->pk);
				$sort_dir = Input::get('sort_dir', 'DESC');
				$rowcount = (int)Config::get('custom.rowcount');
				$p = Input::get('page', 1);
				$option = (int)Input::get('option', 0);
				
				$sql = ''.
						'SELECT '.
							'(SELECT COUNT(*) FROM `Content` WHERE ApplicationID=a.ApplicationID AND StatusID=1) AS ContentCount, '.
							'c.CustomerID, '.
							'c.CustomerName, '.
							'a.Name, '.
							'IFNULL((SELECT DisplayName FROM `GroupCodeLanguage` WHERE GroupCodeID=a.ApplicationStatusID AND LanguageID='.(int)Session::get('language_id').'), \'\') AS ApplicationStatusName, '.
							'IFNULL((SELECT Name FROM `Package` WHERE PackageID=a.PackageID), \'\') AS PackageName, '.
							'(CASE a.Blocked WHEN 1 THEN \''.__('common.applications_list_blocked1').'\' ELSE \''.__('common.applications_list_blocked0').'\' END) AS Blocked, '.
							'(CASE a.Status WHEN 1 THEN \''.__('common.applications_list_status1').'\' ELSE \''.__('common.applications_list_status0').'\' END) AS Status, '.
							'a.ExpirationDate, '.
							'a.ApplicationID '.
						'FROM `Customer` AS c '.
							'INNER JOIN `Application` AS a ON a.CustomerID=c.CustomerID AND a.StatusID=1 '.
						'WHERE c.StatusID=1';
				
				$rs = DB::table(DB::raw('('.$sql.') t'))
					->where(function($query) use($customerID, $search)
					{
						if($customerID > 0)
						{
							$query->where('CustomerID', '=', $customerID);
						}
						
						if(strlen(trim($search)) > 0)
						{
							$query->where('ContentCount', 'LIKE', '%'.$search.'%');
							$query->or_where('CustomerName', 'LIKE', '%'.$search.'%');
							$query->or_where('Name', 'LIKE', '%'.$search.'%');
							$query->or_where('ApplicationStatusName', 'LIKE', '%'.$search.'%');
							$query->or_where('PackageName', 'LIKE', '%'.$search.'%');
							$query->or_where('Blocked', 'LIKE', '%'.$search.'%');
							$query->or_where('Status', 'LIKE', '%'.$search.'%');
							$query->or_where('ExpirationDate', 'LIKE', '%'.$search.'%');
							$query->or_where('ApplicationID', 'LIKE', '%'.$search.'%');
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
		else
		{
			$option = (int)Input::get('option', 0);
			
			if($option == 1)
			{
				$data = array(
					'rows' => $currentUser->Customer()->Applications(1)
				);
				return View::make('pages.'.Str::lower($this->table).'optionlist', $data);
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
			$row = Application::find($id);
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
	
	public function post_push($id)
    {
    	try
		{
			$rules = array(
				'NotificationText' => 'required'
			);
			$v = Validator::make(Input::all(), $rules);
			if ($v->fails())
			{
				throw new Exception(__('common.detailpage_validation'));
			}

			$chk = Common::CheckApplicationOwnership($id);
			if(!$chk)
			{
				throw new Exception("Unauthorized user attempt");
				//throw new Exception(__('error.unauthorized_user_attempt'));
			}

			$currentUser = Auth::User();

			//Update Application
			$s = Application::find($id);
			/*
			if($id == 0)
			{
				$s->Version = 1;
			}
			else
			{
				if($hasModified)
				{
					$s->Version = (int)$s->Version + 1;	
				}
			}
			*/
			$s->NotificationText = Input::get('NotificationText');
			$s->ProcessUserID = $currentUser->UserID;
			$s->ProcessDate = new DateTime();
			$s->ProcessTypeID = eProcessTypes::Update;
			$s->save();

			//Insert
			$deviceTokens = array();
			$tokens = DB::table('Token')
						->where('ApplicationID', '=', $id)
						->raw_where('DeviceToken NOT IN (SELECT DeviceToken FROM `PushNotification` WHERE ApplicationID='.(int)$id.' AND Sent=0)')
						->get();
			foreach($tokens as $token)
			{
				if(!in_array($token->DeviceToken, $deviceTokens))
				{
					//save to push notification
					$p = new PushNotification();
					$p->TokenID = $token->TokenID;
					$p->CustomerID = $token->CustomerID;
					$p->ApplicationID = $token->ApplicationID;
					$p->ApplicationToken = $token->ApplicationToken;
					$p->DeviceToken = $token->DeviceToken;
					$p->DeviceType = $token->DeviceType;
					$p->Sent = 0;
					$p->save();
					array_push($deviceTokens, $token->DeviceToken);
				}
			}
		}
		catch (Exception $e)
		{
			return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
		}
		return "success=".base64_encode("true");
    }

	//POST
	public function post_save()
    {
		$currentUser = Auth::User();
		
		if((int)$currentUser->UserTypeID == eUserTypes::Manager) 
		{
			$id = (int)Input::get($this->pk, '0');
			
			$rules = array(
				'CustomerID' => 'required',
				'Name' => 'required',
				'ExpirationDate' => 'required',
				'PackageID' => 'required|integer'
			);
			$v = Validator::make(Input::all(), $rules);
			if ($v->passes())
			{
				//File
				$sourceFileName = Input::get('hdnCkPemName');
				$sourceFilePath = 'files/temp';
				$sourceRealPath = path('public').$sourceFilePath;
				$sourceFileNameFull = $sourceRealPath.'/'.$sourceFileName;
				
				$targetFileName = $currentUser->UserID.'_'.date("YmdHis").'_'.$sourceFileName;
				
				if(!((int)Input::get('hdnCkPemSelected', 0) == 1 && File::exists($sourceFileNameFull)))
				{
					$targetFileName = $sourceFileName;
				}
				
				$hasModified = false;				
				$current = Application::find($id);
				if($current)
				{
					if((int)$current->CustomerID != (int)Input::get('CustomerID') || $current->Name != Input::get('Name') || $current->Detail != Input::get('Detail') || new DateTime($current->ExpirationDate) != new DateTime(Common::dateWrite(Input::get('ExpirationDate'))) || (int)$current->ApplicationStatusID != (int)Input::get('ApplicationStatusID') || (int)$current->PackageID != (int)Input::get('PackageID') || (int)$current->Blocked != (int)Input::get('Blocked') || (int)$current->Status != (int)Input::get('Status'))
					{
						$hasModified = true;
					}	
				}
				
				if($id == 0)
				{
					$s = new Application();
				}
				else
				{
					$s = Application::find($id);
				}
				$s->CustomerID = (int)Input::get('CustomerID');
				$s->Name = Input::get('Name');
				$s->Detail = Input::get('Detail');
				$s->StartDate = new DateTime(Common::dateWrite(Input::get('StartDate')));
				$s->ExpirationDate = new DateTime(Common::dateWrite(Input::get('ExpirationDate')));
				$s->ApplicationStatusID = (int)Input::get('ApplicationStatusID');
				$s->IOSVersion = (int)Input::get('IOSVersion');
				$s->IOSLink = Input::get('IOSLink', '');
				$s->AndroidVersion = (int)Input::get('AndroidVersion');
				$s->AndroidLink = Input::get('AndroidLink', '');
				$s->PackageID = (int)Input::get('PackageID');
				$s->Blocked = (int)Input::get('Blocked');
				$s->Status = (int)Input::get('Status');
				if($id == 0)
				{
					$s->Version = 1;
				}
				else
				{
					if($hasModified)
					{
						$s->Version = (int)$s->Version + 1;	
					}
				}
				$s->NotificationText = Input::get('NotificationText');
				$s->CkPem = $targetFileName;
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
				
				if((int)Input::get('hdnCkPemSelected', 0) == 1 && File::exists($sourceFileNameFull))
				{
					$applicationID = $s->ApplicationID;
					$customerID = Application::find($applicationID)->CustomerID;
					
					//$targetFileName = $currentUser->UserID.'_'.date("YmdHis").'_'.$sourceFileName;
					$targetFilePath = 'files/customer_'.$customerID.'/application_'.$applicationID;
					$targetRealPath = path('public').$targetFilePath;
					$targetFileNameFull = $targetRealPath.'/'.$targetFileName;
					
					if(!File::exists($targetRealPath))
					{
						File::mkdir($targetRealPath);	
					}
					
					File::move($sourceFileNameFull, $targetFileNameFull);
				}
				
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
			
			$s = Application::find($id);
			if($s)
			{
				$s->Version = (int)$s->Version + 1;
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

	public function post_uploadfile()
    {
		$element = Input::get('element');

		$options = array(
			//'script_url' => URL::to_route('contents_uploadcoverimage'),
			'upload_dir' => path('public').'files/temp/',
			'upload_url' => URL::base().'/files/temp/',
			'param_name' => $element,
			'accept_file_types' => '/\.(pem)$/i'
		);
		$upload_handler = new UploadHandler($options);
		
		if (!Request::ajax())
			return;
		
		$upload_handler->post(false);
    }
}