<?php

class Banners_Controller extends Base_Controller
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
        parent::__construct();
        $this->page = 'banners';
        $this->route = __('route.' . $this->page);
        $this->table = 'Banner';
        $this->pk = 'BannerID';
        $this->caption = __('common.applications_caption');
        $this->detailcaption = __('common.banners_caption_detail');
        $this->fields = array();
        $this->fields[] = __('common.image') . ' (1480x640)';
        $this->fields[] = __('common.banner_list_customer');
        $this->fields[] = __('common.banner_list_application');
        $this->fields[] = __('common.banner_form_target_url');
//	$this->fields[] = __('common.banner_form_target_content');
//	$this->fields[] = __('common.banner_description');
        $this->fields[] = __('common.banners_list_status');
        $this->fields[] = __('common.banner_list_banner_id');
        $this->fields[] = __('common.detailpage_delete');

        if (Auth::User() && (int)Auth::User()->UserTypeID == eUserTypes::Customer) {
            $this->fields = array();
            $this->fields[] = __('common.image') . ' (1480x640)';
            $this->fields[] = __('common.banner_form_target_url');
//	    $this->fields[] = __('common.banner_form_target_content');
//	    $this->fields[] = __('common.banner_description');
            $this->fields[] = __('common.banners_list_status');
            $this->fields[] = __('common.banner_list_banner_id');
            $this->fields[] = __('common.detailpage_delete');
        }
    }

    public function get_index()
    {
        $applicationID = (int)Input::get('applicationID', 0);
        $application = Application::find($applicationID);
        if (!$application || !$application->CheckOwnership()) {
            return Redirect::to(__('route.home'));
        }

        $rows = Banner::getAppBanner($applicationID);
        $data = array();
        $data['route'] = $this->route;
        $data['caption'] = __('common.application_settings_caption_detail');
        $data['route'] = str_replace('(:num)', $application->ApplicationID, __('route.applications_usersettings'));
        $data['detailcaption'] = $this->detailcaption;
        $data['pk'] = $this->pk;
        $data['page'] = $this->page;
        $data['fields'] = $this->fields;
        $data['rows'] = $rows;
        $data['application'] = $application;
        return $html = View::make('pages.' . Str::lower($this->table) . 'list', $data)
            ->nest('filterbar', 'sections.filterbar', $data)
            ->nest('commandbar', 'sections.commandbar', $data);
    }

    /**
     * @return string
     */
    public function get_delete()
    {
        $banner = Banner::find((int)Input::get('id'));
        if (!$banner) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }
        $application = Application::find($banner->ApplicationID);
        if (!$application || !$application->CheckOwnership()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        $banner->StatusID = eStatus::Deleted;
        $banner->save();
        return "success=" . base64_encode("true");
    }

    public function post_order($applicationID)
    {
        $application = Application::find($applicationID);
        if (!$application || !$application->CheckOwnership()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }
        $bannerIDSet = Input::get("bannerIDSet");
        $bannerCount = count($bannerIDSet);
        for ($i = 0; $i < $bannerCount; $i++) {
            $banner = Banner::find($bannerIDSet[$i]);
            $banner->OrderNo = $bannerCount - $i;
            $banner->save();
        }

        return "success=" . base64_encode("true");
    }

    public function post_save()
    {
        $application = Application::find(Input::get("applicationID"));
        if (!$application || !$application->CheckOwnership()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        if (Input::has("newBanner")) {
            //set a default dummy banner
            /* @var $maxOrderedBanner Banner */
            $maxOrderedBanner = Banner::where("ApplicationID", "=", $application->ApplicationID)->order_by("OrderNo", "DESC")->first();
            $order = 1;
            if ($maxOrderedBanner) {
                $order = $maxOrderedBanner->OrderNo + 1;
            }

            $banner = new Banner();
            $banner->ApplicationID = $application->ApplicationID;
            $banner->OrderNo = $order;
            $banner->Status = eStatus::Passive;
            $banner->save();
            $destinationFolder = path('public') . 'files/customer_' . $application->CustomerID . '/application_' . $application->ApplicationID . '/banner/';
            if (!File::exists($destinationFolder)) {
                File::mkdir($destinationFolder);
            }
            File::copy(path('public') . 'images/upload_image.png', $destinationFolder . $banner->BannerID . IMAGE_EXTENSION);
        } else {
            $banner = Banner::find((int)Input::get("pk"));
            if (!$banner) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
            }
            if (Laravel\Input::has("TargetContent")) {
                $banner->TargetContent = (int)Input::get("TargetContent");
            }

            if (Laravel\Input::has("TargetUrl")) {
                if (!Input::get("TargetUrl", "")) {
                    $banner->TargetUrl = "";
                } else if (preg_match('/^https?:\/\/.+$/', Input::get("TargetUrl", ""))) {
                    $banner->TargetUrl = Input::get("TargetUrl");
                } else {
                    $banner->TargetUrl = "http://" . Input::get("TargetUrl");
                }
            }

            if (Laravel\Input::has("Description")) {
                $banner->Description = Input::get("Description");
            }

            if (Laravel\Input::has("Status")) {
                $banner->Status = (int)Input::get('Status');
            }

            if (Laravel\Input::has("name")) {
                $name = Laravel\Input::get("name");
                $value = Laravel\Input::get("value", "");
                if ($name == "TargetUrl") {
                    if (!$value) {
                        $banner->TargetUrl = "";
                    } else if (preg_match('/^https?:\/\/.+$/', $value)) {
                        $banner->TargetUrl = $value;
                    } else {
                        $banner->TargetUrl = "http://" . $value;
                    }
                }
            }
            $banner->save();
        }

        return "success=" . base64_encode("true")
        . "&BannerID=" . base64_encode($banner->BannerID)
        . "&BannerImagePath=" . base64_encode($banner->getImagePath())
        . "&ActiveText=" . base64_encode((string)__('common.active'))
        . "&PassiveText=" . base64_encode((string)__('common.passive'));
    }

    public function post_save_banner_setting()
    {
        $application = Application::find(Input::get("applicationID"));
        if (!$application || !$application->CheckOwnership()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        $rules = array(
            "BannerActive" => 'in:on',
            "BannerAutoplay" => 'in:on',
            "BannerCustomerActive" => 'in:1',
            "BannerIntervalTime" => 'integer|min:1',
            "BannerTransitionRate" => 'integer|min:1',
            "BannerColor" => 'match:/^#[A-Fa-f0-9]{6}$/',
        );
        if ((int)Input::get("BannerCustomerActive")) {
            $rules["BannerCustomerUrl"] = 'required|min:2';
        }

        $ruleNames = array(
            "BannerActive" => __('common.contents_status'),
            "BannerAutoplay" => __('common.banners_autoplay'),
            "BannerCustomerActive" => __("common.banner_use_costomer_banner"),
            "BannerIntervalTime" => __('common.banners_autoplay_interval'),
            "BannerTransitionRate" => __('common.banners_autoplay_speed'),
            "BannerCustomerUrl" => __("common.banner_use_costomer_banner"),
            "BannerColor" => __("common.banners_pager_color"),
        );


        $v = Laravel\Validator::make(Input::all(), $rules);
        if (!$v->passes()) {
            $errMsg = $v->errors->first();
            foreach ($ruleNames as $inputName => $ruleName) {
                $errMsg = str_replace($inputName, $ruleName, $errMsg);
            }
//	    return "success=" . base64_encode("false") . "&errmsg=" . $errMsg;
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($errMsg);
        }

        if (Input::get("BannerCustomerUrl") == '' || Input::get("BannerCustomerUrl") == 'http://') {
            $application->BannerCustomerUrl = '';
        } else if (preg_match('/^https?:\/\/.+$/', Input::get("BannerCustomerUrl"))) {
            $application->BannerCustomerUrl = Input::get("BannerCustomerUrl");
        } else {
            $application->BannerCustomerUrl = "http://" . Input::get("BannerCustomerUrl");
        }

        $application->BannerActive = Input::get("BannerActive", "off") == "on" ? 1 : 0;
        $application->BannerAutoplay = Input::get("BannerAutoplay", "off") == "on" ? 1 : 0;
        $application->BannerCustomerActive = (int)Input::get("BannerCustomerActive");
        $application->BannerIntervalTime = (int)Input::get("BannerIntervalTime", 0);
        $application->BannerTransitionRate = (int)Input::get("BannerTransitionRate", 0);
        $application->BannerColor = Input::get('BannerColor');
        $application->BannerSlideAnimation = Input::get('BannerSlideAnimation');
        $application->save();
        return "success=" . base64_encode("true");
    }

    public function post_imageupload()
    {
        ob_start();


        $rules = array(
            'element' => 'required',
            'bannerID' => 'required',
        );

        $v = Validator::make(Input::all(), $rules);
        if (!$v->passes()) {
            return ajaxResponse::error($v->errors->first());
        }

        $element = Input::get('element');
        $banner = Banner::find(Input::get('bannerID'));
        if (!$banner) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        $options = array(
            'upload_dir' => path('public') . 'files/temp/',
            'upload_url' => URL::base() . '/files/temp/',
            'param_name' => $element,
            'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i'
        );
        $upload_handler = new UploadHandler($options);

        if (!Request::ajax()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
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
        $banner->processImage($ret["fileName"]);
        return Response::json($ret);
    }

    public function get_service_view($applicationID)
    {
        $application = Application::find($applicationID);
        $bannerSet = Banner::getAppBanner($applicationID, FALSE);
        if (!$application || !$bannerSet) {
            return "";
        }
        $data = array();
        $data['caption'] = $this->caption;
        $data['detailcaption'] = $this->detailcaption;
        $data["application"] = $application;
        $data['bannerSet'] = $bannerSet;
        return View::make("service.banner_service", $data);
    }

}
