<?php

class Contents_Controller extends Base_Controller
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
		$this->page = 'contents';
		$this->route = __('route.'.$this->page);
		$this->table = 'Content';
		$this->pk = 'ContentID';
		$this->caption = __('common.contents_caption');
		$this->detailcaption = __('common.contents_caption_detail');
		$this->fields = array(
				0 => array('35px', __('common.contents_list_column1'), ''),
				1 => array('175px', __('common.contents_list_column2'), 'CustomerName'),
				2 => array('175px', __('common.contents_list_column3'), 'ApplicationName'),
				3 => array('', __('common.contents_list_column4'), 'Name'),
				4 => array('65px', __('common.contents_list_column5'), 'Blocked'),
				5 => array('100px', __('common.contents_list_column6'), 'Status'),
				6 => array('75px', __('common.contents_list_column7'), 'ContentID')
			);
		
		if(Auth::check())
		{
			if((int)Auth::User()->UserTypeID == eUserTypes::Customer) 
			{
				$this->fields = array(
						0 => array('35px', __('common.contents_list_customer_column1'), ''),
						1 => array('', __('common.contents_list_customer_column2'), 'Name'),
						2 => array('175px', __('common.contents_list_customer_column3'), 'CategoryName'),
						3 => array('85px', __('common.contents_list_customer_column4'), 'PublishDate'),
						4 => array('65px', __('common.contents_list_customer_column5'), 'Blocked'),
						5 => array('100px', __('common.contents_list_customer_column6'), 'Status'),
						6 => array('75px', __('common.contents_list_customer_column7'), 'ContentID')
					);
			}
		}
	}
	
	public function get_index()
    {
		$currentUser = Auth::User();
		
		try
		{
			$applicationID = (int)Input::get('applicationID', 0);
			$search = Input::get('search', '');
			$sort = Input::get('sort', $this->pk);
			$sort_dir = Input::get('sort_dir', 'DESC');
			$rowcount = (int)Config::get('custom.rowcount');
			$p = Input::get('page', 1);
			$option = (int)Input::get('option', 0);

			if(!Common::CheckApplicationOwnership($applicationID)) {
				return Redirect::to(__('route.home'));
			}

			$sqlCat = '(IFNULL((SELECT GROUP_CONCAT(`Name` ORDER BY `Name` SEPARATOR \', \') FROM `Category` WHERE ApplicationID=a.ApplicationID AND CategoryID IN (SELECT CategoryID FROM `ContentCategory` WHERE ContentID = o.ContentID) AND StatusID = 1), \'\'))';
			
			$sql = ''.
					'SELECT '.
						'c.CustomerID, '.
						'c.CustomerName, '.
						'a.ApplicationID, '.
						'a.Name AS ApplicationName, '.
						'o.Name, '.
						//'(CASE o.CategoryID WHEN 0 THEN \''.__('common.contents_category_list_general').'\' ELSE (SELECT Name FROM `Category` WHERE CategoryID=o.CategoryID) END) AS CategoryName, '.
						'('.
						'CASE WHEN (SELECT COUNT(*) FROM `ContentCategory` WHERE ContentID = o.ContentID AND CategoryID = 0) > 0 '.
						'THEN CONCAT(\''.__('common.contents_category_list_general').', \', '.$sqlCat.') '.
						'ELSE '.$sqlCat.' '.
						'END'.
						') AS CategoryName, '.
						'o.PublishDate, '.
						'(CASE o.Blocked WHEN 1 THEN \''.__('common.contents_list_blocked1').'\' ELSE \''.__('common.contents_list_blocked0').'\' END) AS Blocked, '.
						'(CASE o.Status WHEN 1 THEN \''.__('common.contents_list_status1').'\' ELSE \''.__('common.contents_list_status0').'\' END) AS Status, '.
						'o.ContentID '.
					'FROM `Customer` AS c '.
						'INNER JOIN `Application` AS a ON a.CustomerID=c.CustomerID AND a.StatusID=1 '.
						'INNER JOIN `Content` AS o ON o.ApplicationID=a.ApplicationID AND o.StatusID=1 '.
					'WHERE c.StatusID=1';
			
			$rs = DB::table(DB::raw('('.$sql.') t'))
				->where(function($query) use($currentUser, $applicationID, $search)
				{
					if((int)$currentUser->UserTypeID == eUserTypes::Manager) 
					{
						if($applicationID > 0)
						{
							$query->where('ApplicationID', '=', $applicationID);
						}
						
						if(strlen(trim($search)) > 0)
						{
							$query->where('CustomerName', 'LIKE', '%'.$search.'%');
							$query->or_where('ApplicationName', 'LIKE', '%'.$search.'%');
							$query->or_where('Name', 'LIKE', '%'.$search.'%');
							$query->or_where('Blocked', 'LIKE', '%'.$search.'%');
							$query->or_where('Status', 'LIKE', '%'.$search.'%');
							$query->or_where('ContentID', 'LIKE', '%'.$search.'%');
						}
					}
					elseif((int)$currentUser->UserTypeID == eUserTypes::Customer) 
					{
						if(Common::CheckApplicationOwnership($applicationID))
						{
							if(strlen(trim($search)) > 0)
							{
								$query->where('ApplicationID', '=', $applicationID);
								/*
								$query->or_where('Name', 'LIKE', '%'.$search.'%');
								$query->or_where('CategoryName', 'LIKE', '%'.$search.'%');
								$query->or_where('PublishDate', 'LIKE', '%'.$search.'%');
								$query->or_where('Blocked', 'LIKE', '%'.$search.'%');
								$query->or_where('Status', 'LIKE', '%'.$search.'%');
								$query->or_where('ContentID', 'LIKE', '%'.$search.'%');
								*/
								$query->where(function($q) use ($search)
								{
									$q->where('Name', 'LIKE', '%'.$search.'%');
									$q->or_where('CategoryName', 'LIKE', '%'.$search.'%');
									$q->or_where('PublishDate', 'LIKE', '%'.$search.'%');
									$q->or_where('Blocked', 'LIKE', '%'.$search.'%');
									$q->or_where('Status', 'LIKE', '%'.$search.'%');
									$q->or_where('ContentID', 'LIKE', '%'.$search.'%');
								});
							}
							else
							{
								$query->where('ApplicationID', '=', $applicationID);
							}	
						}
						else
						{
							$query->where('ApplicationID', '=', -1);
						}
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





			/*START SQL FOR TEMPLATE-CHOOSER*/

			$sqlTemlateChooser = ''.
			'SELECT '.
				'a.Name AS ApplicationName, '.
				'c.ContentID, '.
				'c.Name, '.
				'c.Detail, '.
				'cf.FilePath, '.
				'c.MonthlyName, '.
				'cf.InteractiveFilePath, '.
				'ccf.FileName '.
			'FROM `Application` AS a '.
				'LEFT JOIN  `Content` AS c ON c.ApplicationID=a.ApplicationID AND c.StatusID=1 '.
				'LEFT JOIN `ContentFile` AS cf ON c.ContentID=cf.ContentID '.
				'LEFT JOIN `ContentCoverImageFile` AS ccf ON ccf.ContentFileID=cf.ContentFileID '.
			'WHERE a.ApplicationID='.$applicationID;

			$templateResults = DB::table(DB::raw('('.$sqlTemlateChooser.') t'))->order_by('ContentID', 'Desc')->get();
			
			//dd($templateResults);
			/*END SQL FOR TEMPLATE-CHOOSER*/

			// if(count($templateResults)==0){
			// 	$app = Application::find($applicationID);
			// 	$templateResults = array('appName' => $app->Name);
			// 	//var_dump($templateResults); exit();
			// }
			
			$data = array(
				'page' => $this->page,
				'route' => $this->route,
				'caption' => $this->caption,
				'pk' => $this->pk,
				'fields' => $this->fields,
				'search' => $search,
				'sort' => $sort,
				'sort_dir' => $sort_dir,
				'rows' => $rows,
				'templateResults' => $templateResults
			);
			
			if(((int)$currentUser->UserTypeID == eUserTypes::Customer))
			{
				$appCount = DB::table('Application')
							->where('CustomerID', '=', Auth::User()->CustomerID)
							->where('ApplicationID', '=', $applicationID)
							->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
							->count();

				if($appCount == 0){

					$app = Application::find($applicationID);
					if(!$app)
					{
						return Redirect::to(__('route.home'));
					}

					$data = array_merge($data, array('appName' => $app->Name));

					return View::make('pages.expiredpage', $data)
						->nest('filterbar', 'sections.filterbar', $data)
						->nest('commandbar', 'sections.commandbar', $data);
				}
			}
			return View::make('pages.'.Str::lower($this->table).'list', $data)
					->nest('filterbar', 'sections.filterbar', $data)
					->nest('commandbar', 'sections.commandbar', $data);
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
			return Redirect::to(__('route.home'));
		}
    }
	
	public function get_request()
    {
		$RequestTypeID = (int)Input::get('RequestTypeID', 0);
		$ApplicationID = (int)Input::get('ApplicationID', 0);
		$ContentID = (int)Input::get('ContentID', 0);
		$ApplicationToken = Input::get('ApplicationToken', '');
		$DeviceToken = Input::get('DeviceToken', '');
		$Password = Input::get('Password', '');
		
		//http://localhost/tr/icerikler/talep?RequestTypeID=203&ApplicationID=1&ContentID=1187&Password=
		try
		{
			//Eski talep numaralari yenisiyle degistirildi!!!
			if($RequestTypeID == 202)
			{
				$RequestTypeID == 1101;
			}
			else if($RequestTypeID == 203)
			{
				$RequestTypeID == 1001;
			}
			
			if($RequestTypeID == 1001)
			{
				//get file
				$oCustomerID = 0;
				$oApplicationID = 0;
				$oContentID = 0;
				$oContentFileID = 0;
				$oContentFilePath = '';
				$oContentFileName = '';
				Common::getContentDetail($ContentID, $Password, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, $oContentFilePath, $oContentFileName);
				Common::download($RequestTypeID, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, 0, $oContentFilePath, $oContentFileName);
			}
			else if($RequestTypeID == 1101)
			{
				//get cover image
				$oCustomerID = 0;
				$oApplicationID = 0;
				$oContentID = 0;
				$oContentFileID = 0;
				$oContentFilePath = '';
				$oContentFileName = '';
				$oContentCoverImageFileID = 0;	
				$oContentCoverImageFilePath = '';
				$oContentCoverImageFileName = '';
				$oContentCoverImageFileName2 = '';
				Common::getContentDetailWithCoverImage($ContentID, $Password, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, $oContentFilePath, $oContentFileName, $oContentCoverImageFileID, $oContentCoverImageFilePath, $oContentCoverImageFileName, $oContentCoverImageFileName2);
				Common::download($RequestTypeID, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, $oContentCoverImageFileID, $oContentCoverImageFilePath, $oContentCoverImageFileName);
			}
			else if($RequestTypeID == 1102)
			{
				//get mini cover image
				$oCustomerID = 0;
				$oApplicationID = 0;
				$oContentID = 0;
				$oContentFileID = 0;
				$oContentFilePath = '';
				$oContentFileName = '';
				$oContentCoverImageFileID = 0;	
				$oContentCoverImageFilePath = '';
				$oContentCoverImageFileName = '';
				$oContentCoverImageFileName2 = '';
				Common::getContentDetailWithCoverImage($ContentID, $Password, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, $oContentFilePath, $oContentFileName, $oContentCoverImageFileID, $oContentCoverImageFilePath, $oContentCoverImageFileName, $oContentCoverImageFileName2);
				Common::download($RequestTypeID, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, $oContentCoverImageFileID, $oContentCoverImageFilePath, $oContentCoverImageFileName2);
			}
			else
			{
				throw new Exception('Not implemented', '102');
			}
		}
		catch (Exception $e)
		{
			$r = '';
			$r .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n";
			$r .= "<Response>\n";
			$r .= "<Error code=\"".$e->getCode()."\">".Common::xmlEscape($e->getMessage())."</Error>\n";
			$r .= "</Response>\n";
			return Response::make($r, 200, array('content-type' => 'text/xml'));
		}
    }
	
	public function get_new()
    {
		$currentUser = Auth::User();
		
		$this->route = __('route.'.$this->page).'?applicationID='.Input::get('applicationID', '0');

		$data = array(
			'page' => $this->page,
			'route' => $this->route,
			'caption' => $this->caption,
			'detailcaption' => $this->detailcaption
		);
		$applicationID=Input::get('applicationID', '0');
		$appCount = DB::table('Application')
					->where('CustomerID', '=', Auth::User()->CustomerID)
					->where('ApplicationID', '=', $applicationID)
					->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
					->count();

		if($appCount == 0){

			$app = Application::find($applicationID);
			if(!$app)
			{
				return Redirect::to(__('route.home'));
			}

			$data = array_merge($data, array('appName' => $app->Name));

			return View::make('pages.expiredpage', $data)
				->nest('filterbar', 'sections.filterbar', $data);
		}
		return View::make('pages.'.Str::lower($this->table).'detail', $data)
			->nest('filterbar', 'sections.filterbar', $data);
    }
	
    public function get_show($id)
    {
		$currentUser = Auth::User();
		
		$row = Content::find($id);
		if($row)
		{
			if(Common::CheckContentOwnership($id)) 
			{
				$this->route = __('route.'.$this->page).'?applicationID='.$row->ApplicationID;

				$data = array(
					'page' => $this->page,
					'route' => $this->route,
					'caption' => $this->caption,
					'detailcaption' => $this->detailcaption,
					'row' => $row
				);

				if(((int)$currentUser->UserTypeID == eUserTypes::Customer))
				{
					$appCount = DB::table('Application')
							->where('CustomerID', '=', Auth::User()->CustomerID)
							->where('ApplicationID', '=', $row->ApplicationID)
							->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
							->count();

					if($appCount == 0)
					{
						return View::make('pages.expiredpage', $data)
							->nest('filterbar', 'sections.filterbar', $data);
					}	
				}
				return View::make('pages.'.Str::lower($this->table).'detail', $data)
					->nest('filterbar', 'sections.filterbar', $data);
			}
			else
			{
				return Redirect::to($this->route);
			}
		}
		else 
		{
			return Redirect::to($this->route);
		}
    }
	
	//POST
	public function post_save()
    {
		$currentUser = Auth::User();
		
		$id = (int)Input::get($this->pk, '0');
		$applicationID = (int)Input::get('ApplicationID', '0');
		$chk = Common::CheckApplicationOwnership($applicationID);
		$rules = array(
			'ApplicationID' => 'required|integer|min:1',
			'Name' => 'required'
		);
		$v = Validator::make(Input::all(), $rules);
		if ($v->passes() && $chk)
		{
			if(!Common::AuthMaxPDF($applicationID))
			{
				return "success=".base64_encode("false")."&errmsg=".base64_encode(__('error.auth_max_pdf'));
			}

			try
			{
				DB::transaction(function() use ($currentUser, $id, $applicationID)
				{
					$hasModified = false;
					$current = Content::find($id);
					if($current)
					{
						$selectedCategories = Input::get('chkCategoryID');
						$currentCategories = array();
						$cnt = DB::table('ContentCategory')->where('ContentID', '=', $current->ContentID)->where('CategoryID', '=', 0)->count();
						if($cnt > 0) {
							$currentCategories = array_merge($currentCategories, array(""));
						}
						$rows = DB::table('ContentCategory AS cc')
							->left_join('Category AS c', 'c.CategoryID', '=', 'cc.CategoryID')
							->where('cc.ContentID', '=', $current->ContentID)
							->where('c.ApplicationID', '=', $applicationID)
							->where('c.StatusID', '=', eStatus::Active)
							->order_by('Name', 'ASC')
							->get();
						foreach($rows as $row) {
							$currentCategories = array_merge($currentCategories, array($row->CategoryID));
						}
						if((int)$current->ApplicationID != (int)$applicationID || 
							$current->Name != Input::get('Name') || 
							$current->Detail != Input::get('Detail') || 
							$current->MonthlyName != Input::get('MonthlyName') || 
							new DateTime($current->PublishDate) != new DateTime(Common::dateWrite(Input::get('PublishDate'))) || 
							//new DateTime(Common::dateWrite(Date::forge($current->PublishDate)->format('%d.%m.%Y'))) != new DateTime(Common::dateWrite(Input::get('PublishDate'))) || 
							(int)$current->CategoryID != (int)Input::get('CategoryID') || 
							(int)$current->IsProtected != (int)Input::get('IsProtected') || 
							//$currentPassword != $cPassword || 
							(int)$current->IsBuyable != (int)Input::get('IsBuyable') || 
							(float)$current->Price != (float)Input::get('Price') || 
							(int)$current->CurrencyID != (int)Input::get('CurrencyID') ||
							$current->Identifier != Input::get('Identifier') ||
							(int)$current->Orientation != (int)Input::get('Orientation') || 
							(int)$current->IsMaster != (int)Input::get('IsMaster') || 
							(int)$current->AutoDownload != (int)Input::get('AutoDownload') ||
							//(int)$current->Approval != (int)Input::get('Approval') ||
							(int)$current->Blocked != (int)Input::get('Blocked') || 
							(int)$current->Status != (int)Input::get('Status') || 
							(int)Input::get('hdnFileSelected', 0) == 1 ||
							(int)Input::get('hdnCoverImageFileSelected', 0) == 1 ||
							$currentCategories != $selectedCategories
							)
						{
							$hasModified = true;
						}	
					}
					
					if($id == 0)
					{
						$s = new Content();
					}
					else
					{
						$chk = Common::CheckContentOwnership($id);
						if(!$chk)
						{
							throw new Exception("Unauthorized user attempt");
							//return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
						}
						$s = Content::find($id);
					}
					$s->ApplicationID = $applicationID;
					$s->Name = Input::get('Name');
					$s->Detail = Input::get('Detail');
					$s->MonthlyName = Input::get('MonthlyName');
					$s->PublishDate = new DateTime(Common::dateWrite(Input::get('PublishDate')));
					//$s->CategoryID = (int)Input::get('CategoryID');
					$s->IsProtected = (int)Input::get('IsProtected');
					if(strlen(trim(Input::get('Password'))) > 0)
					{
						$s->Password = Hash::make(Input::get('Password'));
					}
					$s->IsBuyable = (int)Input::get('IsBuyable');
					$s->Price = (float)Input::get('Price');
					$s->CurrencyID = (int)Input::get('CurrencyID');
					$s->Identifier = Input::get('Identifier');
					$s->Orientation = (int)Input::get('Orientation');
					$s->IsMaster = (int)Input::get('IsMaster');

					if ((int)$s->IsMaster == 1) {

						//Unset IsProtected & password field due to https://github.com/galepress/gp/issues/7
						$s->IsProtected = 0;
						$s->Password = '';

						$contents = DB::table('Content')->where('ApplicationID', '=', $applicationID)->get();
						foreach ($contents as $content) {
							//INFO:Added due to https://github.com/galepress/gp/issues/18
							if ((int)$id !== (int)$content->ContentID)
							{
								$a = Content::find($content->ContentID);
								$a->IsMaster = 0;
								$a->Version = (int)$a->Version + 1;
								$a->ProcessUserID = $currentUser->UserID;
								$a->ProcessDate = new DateTime();
								$a->ProcessTypeID = eProcessTypes::Update;
								$a->save();	
							}
						}
					}

					$s->AutoDownload = (int)Input::get('AutoDownload');
					if((int)$currentUser->UserTypeID == eUserTypes::Manager) 
					{
						$s->Approval = (int)Input::get('Approval');
						$s->Blocked = (int)Input::get('Blocked');
					}
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
					if($id == 0)
					{
						$s->PdfVersion = 1;
					}
					else
					{
						if((int)Input::get('hdnFileSelected', 0) == 1)
						{
							$s->PdfVersion = (int)$s->PdfVersion + 1;
						}
					}
					if($id == 0)
					{
						$s->CoverImageVersion = 1;
					}
					else
					{
						if((int)Input::get('hdnCoverImageFileSelected', 0) == 1)
						{
							$s->CoverImageVersion = (int)$s->CoverImageVersion + 1;	
						}
					}
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
					
					//content categories
					DB::table('ContentCategory')->where('ContentID', '=', $s->ContentID)->delete();
					
					$selectedCategories = Input::get('chkCategoryID');
					if(is_array($selectedCategories))
					{
						foreach($selectedCategories as $value)
						{
							//add category
							$cat = new ContentCategory();
							$cat->ContentID = $s->ContentID;
							$cat->CategoryID = (int)$value;
							$cat->save();
						}	
					}
					
					if($id == 0 || $hasModified)
					{
						$a = Application::find($applicationID);
						$a->Version = (int)$a->Version + 1;
						$a->ProcessUserID = $currentUser->UserID;
						$a->ProcessDate = new DateTime();
						$a->ProcessTypeID = eProcessTypes::Update;
						$a->save();
					}
					
					$customerID = Application::find($applicationID)->CustomerID;
					//$applicationID
					$contentID = $s->ContentID;
					$contentFileID = (int)DB::table('ContentFile')
										->where('ContentID', '=', $contentID)
										->where('StatusID', '=', eStatus::Active)
										->max('ContentFileID');
					
					//File
					if((int)Input::get('hdnFileSelected', 0) == 1)
					{
						$sourceFileName = Input::get('hdnFileName');
						$sourceFilePath = 'files/temp';
						$sourceRealPath = path('public').$sourceFilePath;
						$sourceFileNameFull = $sourceRealPath.'/'.$sourceFileName;
						
						$targetFileName = $currentUser->UserID.'_'.date("YmdHis").'_'.$sourceFileName;
						$targetFilePath = 'files/customer_'.$customerID.'/application_'.$applicationID.'/content_'.$contentID;
						$targetRealPath = path('public').$targetFilePath;
						$targetFileNameFull = $targetRealPath.'/'.$targetFileName;
						
						if(File::exists($sourceFileNameFull))
						{
							if(!File::exists($targetRealPath))
							{
								File::mkdir($targetRealPath);	
							}
							
							File::move($sourceFileNameFull, $targetFileNameFull);
							
							$f = new ContentFile();
							$f->ContentID = $contentID;
							$f->DateAdded = new DateTime();
							//$f->FilePath = '/'.$targetFilePath;
							$f->FilePath = $targetFilePath;
							$f->FileName = $targetFileName;
							//$f->FileName2 = '';
							$f->FileSize = File::size($targetFileNameFull);
							$f->Transferred = (int)Input::get('Transferred', '0');
							$f->StatusID = eStatus::Active;
							$f->CreatorUserID = $currentUser->UserID;
							$f->DateCreated = new DateTime();
							$f->ProcessUserID = $currentUser->UserID;
							$f->ProcessDate = new DateTime();
							$f->ProcessTypeID = eProcessTypes::Insert;
							$f->save();
							
							$contentFileID = $f->ContentFileID;
						}
					}
					
					//Cover Image
					if((int)Input::get('hdnCoverImageFileSelected', 0) == 1)
					{
						$sourceFileName = Input::get('hdnCoverImageFileName');
						$sourceFilePath = 'files/temp';
						$sourceRealPath = path('public').$sourceFilePath;
						$sourceFileNameFull = $sourceRealPath.'/'.$sourceFileName;
						
						$targetFileName = $currentUser->UserID.'_'.date("YmdHis").'_'.$sourceFileName;
						$targetFilePath = 'files/customer_'.$customerID.'/application_'.$applicationID.'/content_'.$contentID;
						$targetRealPath = path('public').$targetFilePath;
						$targetFileNameFull = $targetRealPath.'/'.$targetFileName;

						$targetMainFileName = $currentUser->UserID.'_'.date("YmdHis").'_'.$sourceFileName.'_main.jpg';
						$targetMainFilePath = $targetFilePath;
						$targetMainRealPath = $targetRealPath;
						$targetMainFileNameFull = $targetMainRealPath.'/'.$targetMainFileName;

						$targetThumbFileName = $targetFileName.'_thumb.jpg';
						$targetThumbFilePath = $targetFilePath;
						$targetThumbRealPath = $targetRealPath;
						$targetThumbFileNameFull = $targetThumbRealPath.'/'.$targetThumbFileName;
						
						if(File::exists($sourceFileNameFull) && is_file($sourceFileNameFull))
						{
							if(!File::exists($targetRealPath))
							{
								File::mkdir($targetRealPath);	
							}
						
							File::move($sourceFileNameFull, $targetFileNameFull);
							//------------------------------------------------------
							$im = new imagick($targetFileNameFull);
							$im->setImageFormat("jpg");
							$width = 110;
							$height = 157; //146
							
							$geo = $im->getImageGeometry();
							
							if(($geo['width'] / $width) < ($geo['height'] / $height)) {
								
								$im->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
							}
							else {
								$im->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
							}
							$im->ThumbnailImage($width, $height, true);
							$im->writeImages($targetThumbFileNameFull, true);
							$im->clear();
							$im->destroy();
							unset($im);
							//------------------------------------------------------
							$im = new imagick($targetFileNameFull);
							$im->setImageFormat("jpg");
							//$width = 936;
							//$height = 1334;
							$width = 468;
							$height = 667;
							
							$geo = $im->getImageGeometry();
							
							if(($geo['width'] / $width) < ($geo['height'] / $height)) {
								
								$im->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
							}
							else {
								$im->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
							}
							$im->ThumbnailImage($width, $height, true);
							$im->writeImages($targetMainFileNameFull, true);
							$im->clear();
							$im->destroy();
							unset($im);
							//------------------------------------------------------
							$c = new ContentCoverImageFile();
							$c->ContentFileID = $contentFileID;
							$c->DateAdded = new DateTime();
							$c->FilePath = $targetFilePath;
							$c->FileName = $targetMainFileName;
							$c->FileName2 = $targetThumbFileName;
							$c->FileSize = File::size($targetMainFileNameFull);
							$c->StatusID = eStatus::Active;
							$c->CreatorUserID = $currentUser->UserID;
							$c->DateCreated = new DateTime();
							$c->ProcessUserID = $currentUser->UserID;
							$c->ProcessDate = new DateTime();
							$c->ProcessTypeID = eProcessTypes::Insert;
							$c->save();
						}
					}
				});
			}
			catch (Exception $e)
			{
				return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
			}
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
		
		$chk = Common::CheckContentOwnership($id);
		if($chk)
		{
			try
			{
				DB::transaction(function() use ($currentUser, $id)
				{
					$s = Content::find($id);
					if($s)
					{
						$s->StatusID = eStatus::Deleted;
						$s->ProcessUserID = $currentUser->UserID;
						$s->ProcessDate = new DateTime();
						$s->ProcessTypeID = eProcessTypes::Update;
						$s->save();
						
						$a = Application::find($s->ApplicationID);
						$a->Version = (int)$a->Version + 1;
						$a->ProcessUserID = $currentUser->UserID;
						$a->ProcessDate = new DateTime();
						$a->ProcessTypeID = eProcessTypes::Update;
						$a->save();
					}
				});
				return "success=".base64_encode("true");
			}
			catch(Exception $e)
			{
				return "success=".base64_encode("false")."&errmsg=".base64_encode($e->getMessage());
			}
		}
		return "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.detailpage_validation'));
    }

    /*
    public function post_uploadfile_backup()
    {
		$element = Input::get('element');

		$options = array(
			//'script_url' => URL::to_route('contents_uploadcoverimage'),
			'upload_dir' => path('public').'files/temp/',
			'upload_url' => URL::base().'/files/temp/',
			'param_name' => $element,
			'accept_file_types' => '/\.(pdf)$/i'
		);
		$upload_handler = new UploadHandler($options);
		
		if (!Request::ajax())
			return;
		
		$upload_handler->post("");
    }
    */

	public function post_uploadfile()
    {
    	ob_start();

		$element = Input::get('element');

		$options = array(
			//'script_url' => URL::to_route('contents_uploadcoverimage'),
			'upload_dir' => path('public').'files/temp/',
			'upload_url' => URL::base().'/files/temp/',
			'param_name' => $element,
			'accept_file_types' => '/\.(pdf)$/i'
		);
		$upload_handler = new UploadHandler($options);
		
		if (!Request::ajax())
			return;
		
		$upload_handler->post(false);

		$ob = ob_get_contents();
		ob_end_clean();

		$json = get_object_vars(json_decode($ob));
		$arr = $json[$element];
		$obj = $arr[0];
		$tempFile = $obj->name;
		//var_dump($obj->name);
		$ret = Uploader::ContentsUploadFile($tempFile);
		return Response::json($ret);
    }

    public function post_uploadcoverimage()
    {
    	ob_start();

		$element = Input::get('element');

		$options = array(
			//'script_url' => URL::to_route('contents_uploadcoverimage'),
			'upload_dir' => path('public').'files/temp/',
			'upload_url' => URL::base().'/files/temp/',
			'param_name' => $element,
			'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i'
		);
		$upload_handler = new UploadHandler($options);
		
		if (!Request::ajax())
			return;
		
		$upload_handler->post(false);
		
		$ob = ob_get_contents();
		ob_end_clean();

		$json = get_object_vars(json_decode($ob));
		$arr = $json[$element];
		$obj = $arr[0];
		$tempFile = $obj->name;
		//var_dump($obj->name);
		$ret = Uploader::ContentsUploadCoverImage($tempFile);
		return Response::json($ret);
    }
}