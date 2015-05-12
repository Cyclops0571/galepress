<?php

class Banners_Controller extends Base_Controller {

	public $restful = true;
	public $page = '';
	public $route = '';
	public $table = '';
	public $pk = '';
	public $caption = '';
	public $detailcaption = '';
	public $fields;

	public function __construct() {
		parent::__construct();
		$this->page = 'banners';
		$this->route = __('route.' . $this->page);
		$this->table = 'Banner';
		$this->pk = 'BannerID';
		$this->caption = __('common.contents_caption');
		$this->detailcaption = __('common.contents_caption_detail');
		$this->fields = array();
		$this->fields[] = array(__('common.contents_list_customer'), 'CustomerName');
		$this->fields[] = array(__('common.contents_list_application'), 'ApplicationName');
		$this->fields[] = array(__('common.contents_list_content_name'), 'Name');
		$this->fields[] = array(__('common.contents_list_content_bloke'), 'Blocked');
		$this->fields[] = array(__('common.contents_list_status'), 'Status');
		$this->fields[] = array(__('common.contents_list_content_id'), 'ContentID');

		if (Auth::check()) {
			if ((int) Auth::User()->UserTypeID == eUserTypes::Customer) {
				$this->fields = array();
				$this->fields[] = array(__('common.contents_list_content_name'), 'Name');
				$this->fields[] = array(__('common.coCreatorUserIDntents_list_content_category'), 'CategoryName');
				$this->fields[] = array(__('common.contents_list_content_publishdate'), 'PublishDate');
				$this->fields[] = array(__('common.contents_list_content_unpublishdate'), 'UnpublishDate');
				$this->fields[] = array(__('common.contents_list_content_bloke'), 'Blocked');
				$this->fields[] = array(__('common.contents_list_status'), 'Status');
				$this->fields[] = array(__('common.contents_list_content_id'), 'ContentID');
			}
		}
	}

	public function get_index() {
		$applicationID = (int) Input::get('applicationID', 0);

		if (!Common::CheckApplicationOwnership($applicationID)) {
			return Redirect::to(__('route.home'));
		}
		
		$rows = Banner::getAppBanner($applicationID);
		
		$data = array();
		$data['route'] = $this->route;
		$data['caption'] = $this->caption;
		$data['pk'] = $this->pk;
		$data['page'] = $this->page;
		$data['fields'] = $this->fields;
		$data['rows'] = $rows;
		
		return $html = View::make('pages.' . Str::lower($this->table) . 'list', $data)
				->nest('filterbar', 'sections.filterbar', $data)
				->nest('commandbar', 'sections.commandbar', $data);
	}

	public function get_new() {
		$applicationID = (int) Input::get('applicationID', '0');
		$application = Application::find($applicationID);
		if (!$application) {
			return Redirect::to(__('route.home'));
		}
		
		if(!$application->CheckOwnership()) {
			return Redirect::to(__('route.home'));
		}

				/* START SQL FOR TEMPLATE-CHOOSER */
		$sqlTemlateChooser = 'SELECT * FROM ('
				. 'SELECT a.Name AS ApplicationName, a.ThemeBackground,a.ThemeForeground, c.ContentID, c.Name, c.Detail, c.MonthlyName, '
				. 'cf.ContentFileID,cf.FilePath, cf.InteractiveFilePath, '
				. 'ccf.ContentCoverImageFileID, ccf.FileName '
				. 'FROM `Application` AS a '
				. 'LEFT JOIN `Content` AS c ON c.ApplicationID=a.ApplicationID AND c.StatusID=1 '
				. 'LEFT JOIN `ContentFile` AS cf ON c.ContentID=cf.ContentID '
				. 'LEFT JOIN `ContentCoverImageFile` AS ccf ON ccf.ContentFileID=cf.ContentFileID '
				. 'WHERE a.ApplicationID= ' . $applicationID . ' '
				. 'order by  c.ContentID DESC, cf.ContentFileID DESC, ccf.ContentCoverImageFileID DESC) as innerTable '
				. 'group by innerTable.ContentID '
				. 'order by innerTable.ContentID DESC '
				. 'LIMIT 9';

		$templateResults = DB::table(DB::raw('(' . $sqlTemlateChooser . ') t'))->order_by('ContentID', 'Desc')->get();
		
		$data = array();
		$data["application"] = $application;
		$data["banner"] = FALSE;
		$data["contents"] = $application->getContentSet();
		$data["templateResults"] = $templateResults;
		return View::make('pages.' . Str::lower($this->table) . 'detail', $data);
	}

	public function get_show($bannerID) {
		$banner = Banner::find($bannerID);
		$applicationID = (int) Input::get('applicationID', '0');
		if (!$banner) {
			return Redirect::to($this->route);
		}
		
		
		
		$contents = DB::table('Content')
			->where('ApplicationID', '=', $applicationID)
			->where('StatusID', '=', eStatus::Active)
			->order_by('Name', 'ASC')
			->get();
				
		$data = array();
		$data["applicationID"] = (int) Input::get('applicationID', '0');
		$data["banner"] = $banner;
		$data["contents"] = $contents;
		return View::make("pages." . Str::lower($this->table) . "detail", $data);
	}

	public function post_delete() {
		
	}

	public function post_order($applicationID) {
		
	}

	public function post_save() {
		
		$pk = (int) Input::get("primaryKeyID");
		$banner = Banner::find($pk);
		if(!$banner) {
			$banner = new Banner();
		}
		
		$application = Application::find(Input::get("applicationID"));
		if(!$application || !$application->CheckOwnership()) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
		
		$banner->ApplicationID = $application->ApplicationID;
		$banner->TargetContent = (int) Input::get("TargetContent");
		$banner->TargetUrl = Input::get("TargetUrl");
		$banner->Description = Input::get("Description");
		$banner->Autoplay = Input::get("Autoplay");
		$banner->IntervalTime = Input::get("IntervalTime");
		$banner->TransitionRate = Input::get("TransitionRate");
		$banner->Status = (int) Input::get('Status');
		$banner->save();
		$banner->processImage($application);
		return "success=" . base64_encode("true");
	}
	
	public function post_imageupload(){
		ob_start();
		$element = Input::get('element');

		$options = array(
			'upload_dir' => path('public') . 'files/temp/',
			'upload_url' => URL::base() . '/files/temp/',
			'param_name' => $element,
			'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i'
		);
		$upload_handler = new UploadHandler($options);

		if (!Request::ajax()) {
			return;
		}

		$upload_handler->post(false);

		$ob = ob_get_contents();
		ob_end_clean();

		$json = get_object_vars(json_decode($ob));
		$arr = $json[$element];
		$obj = $arr[0];
		$tempFile = $obj->name;
		//var_dump($obj->name);
		$ret = Uploader::UploadImage($tempFile);
		return Response::json($ret);
	}
	
	public function post_imageupload_ltie10(){
		
	}
	
	public function get_service_view($appID) {
		$data = array();
		return View::make("service.banner_service", $data);
	}

}
