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
		$this->caption = __('common.banners_caption');
		$this->detailcaption = __('common.banners_caption_detail');
		$this->fields = array();
		$this->fields[] = __('common.image');
		$this->fields[] = __('common.banner_list_customer');
		$this->fields[] = __('common.banner_list_application');
		$this->fields[] = __('common.banner_form_target_url');
		$this->fields[] = __('common.banner_form_target_content');
		$this->fields[] = __('common.banner_description');
		$this->fields[] = __('common.banners_list_status');
		$this->fields[] = __('common.banner_list_banner_id');
		$this->fields[] = __('common.detailpage_delete');

		if (Auth::User() && (int) Auth::User()->UserTypeID == eUserTypes::Customer) {
			$this->fields = array();
			$this->fields[] = __('common.image');
			$this->fields[] = __('common.banner_form_target_url');
			$this->fields[] = __('common.banner_form_target_content');
			$this->fields[] = __('common.banner_description');
			$this->fields[] = __('common.banners_list_status');
			$this->fields[] = __('common.banner_list_banner_id');
			$this->fields[] = __('common.detailpage_delete');
		}
	}

	public function get_index() {
		$applicationID = (int) Input::get('applicationID', 0);
		$application = Application::find($applicationID);
		if (!$application || !$application->CheckOwnership()) {
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
		$data['application'] = $application;
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

		if (!$application->CheckOwnership()) {
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
		$data['route'] = $this->route = __('route.' . $this->page) . '?applicationID=' . Input::get('applicationID', '0');
		$data['caption'] = $this->caption;
		$data['detailcaption'] = __('common.banners_caption_detail');
		$data["banner"] = FALSE;
		$data["bannerSet"] = Banner::getAppBanner($applicationID);
		$data["contents"] = $application->getContentSet();
		$data["templateResults"] = $templateResults;
		return View::make('pages.' . Str::lower($this->table) . 'detail', $data)->nest('filterbar', 'sections.filterbar', $data);
	}

	public function get_show($bannerID) {
		$banner = Banner::find($bannerID);
		if (!$banner) {
			return Redirect::to($this->route);
		}

		$contents = DB::table('Content')
				->where('ApplicationID', '=', $banner->ApplicationID)
				->where('StatusID', '=', eStatus::Active)
				->order_by('Name', 'ASC')
				->get();

		/* START SQL FOR TEMPLATE-CHOOSER */
		$sqlTemlateChooser = 'SELECT * FROM ('
				. 'SELECT a.Name AS ApplicationName, a.ThemeBackground,a.ThemeForeground, c.ContentID, c.Name, c.Detail, c.MonthlyName, '
				. 'cf.ContentFileID,cf.FilePath, cf.InteractiveFilePath, '
				. 'ccf.ContentCoverImageFileID, ccf.FileName '
				. 'FROM `Application` AS a '
				. 'LEFT JOIN `Content` AS c ON c.ApplicationID=a.ApplicationID AND c.StatusID=1 '
				. 'LEFT JOIN `ContentFile` AS cf ON c.ContentID=cf.ContentID '
				. 'LEFT JOIN `ContentCoverImageFile` AS ccf ON ccf.ContentFileID=cf.ContentFileID '
				. 'WHERE a.ApplicationID= ' . $banner->ApplicationID . ' '
				. 'order by  c.ContentID DESC, cf.ContentFileID DESC, ccf.ContentCoverImageFileID DESC) as innerTable '
				. 'group by innerTable.ContentID '
				. 'order by innerTable.ContentID DESC '
				. 'LIMIT 9';

		$templateResults = DB::table(DB::raw('(' . $sqlTemlateChooser . ') t'))->order_by('ContentID', 'Desc')->get();
		$data = array();
		$data["application"] = Application::find($banner->ApplicationID);
		$data['route'] = $this->route = __('route.' . $this->page) . '?applicationID=' . $banner->ApplicationID;
		$data['caption'] = $this->caption;
		$data['detailcaption'] = $this->detailcaption;
		$data["bannerSet"] = Banner::getAppBanner($banner->ApplicationID);
		$data["banner"] = $banner;
		$data["contents"] = $contents;
		$data["templateResults"] = $templateResults;
		return View::make("pages." . Str::lower($this->table) . "detail", $data)->nest('filterbar', 'sections.filterbar', $data);
	}

	public function get_delete() {
		$banner = Banner::find((int)Input::get('id'));
		if(!$banner) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
		$application = Application::find($banner->ApplicationID);
		if(!$application || !$application->CheckOwnership()) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
		
		$banner->StatusID = eStatus::Deleted;
		$banner->save();
		return "success=" . base64_encode("true");
	}

	public function post_order($applicationID) {
		$application = Application::find($applicationID);
		if(!$application || !$application->CheckOwnership()) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
		$bannerIDSet = Input::get("bannerIDSet");
		$bannerCount = count($bannerIDSet);
		for($i = 0; $i < $bannerCount; $i++) {
			$banner = Banner::find($bannerIDSet[$i]);
			$banner->OrderNo = $bannerCount - $i;
			$banner->save();
		}
		
		return "success=" . base64_encode("true");
	}

	public function post_save() {

		$pk = (int) Input::get("primaryKeyID");
		$banner = Banner::find($pk);
		if (!$banner) {
			$banner = new Banner();
		}

		$application = Application::find(Input::get("applicationID"));
		if (!$application || !$application->CheckOwnership()) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}

		$banner->ApplicationID = $application->ApplicationID;
		$banner->TargetContent = (int) Input::get("TargetContent");
		$banner->TargetUrl = Input::get("TargetUrl");
		$banner->Description = Input::get("Description");
		$banner->Status = (int) Input::get('Status');
		$banner->save();
		$banner->processImage($application);
		
		$application->BannerActive = (int) Input::get("BannerActive");
		$application->BannerAutoplay = (int) Input::get("BannerAutoplay");
		$application->BannerIntervalTime = (int) Input::get("BannerIntervalTime");
		$application->BannerTransitionRate = (int) Input::get("BannerTransitionRate");
		$application->save(FALSE);
		
		return "success=" . base64_encode("true") . "&bannerID=" . base64_encode($banner->BannerID);
	}

	public function post_imageupload() {
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

	public function post_imageupload_ltie10() {
		
	}

	public function get_service_view($applicationID) {
		$data = array();
		$data['caption'] = $this->caption;
		$data['detailcaption'] = $this->detailcaption;
		$data["application"] = Application::find($applicationID);
		$data['bannerSet'] = Banner::getAppBanner($applicationID);
		return View::make("service.banner_service", $data);
	}

}
