<?php

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class Applications_Controller
 */
class Applications_Controller extends Base_Controller
{

    /**
     * @var bool
     */
    public $restful = true;
    /**
     * @var string
     */
    public $page = '';
    /**
     * @var string
     */
    public $route = '';
    /**
     * @var string
     */
    public $table = '';
    /**
     * @var string
     */
    public $pk = '';
    /**
     * @var string
     */
    public $caption = '';
    /**
     * @var string
     */
    public $detailcaption = '';
    /**
     * @var array
     */
    public $fields;

    /**
     * Applications_Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->page = 'applications';

        $this->route = __('route.' . $this->page);
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
            8 => array('100px', __('common.applications_trail_title'), 'Trail'),
            9 => array('90px', __('common.applications_list_column9'), 'ExpirationDate'),
            10 => array('75px', __('common.applications_list_column10'), 'ApplicationID'),
            11 => array('75px', __('common.applications_list_column11'), 'IsExpired')
        );
    }

    /**
     * @return \Laravel\Redirect|\Laravel\View
     * @throws Exception
     */
    public function get_index()
    {
        $currentUser = Auth::User();

        if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
            try {
                $customerID = (int)Input::get('customerID', 0);
                $search = Input::get('search', '');
                $sort = Input::get('sort', $this->pk);
                $sort_dir = Input::get('sort_dir', 'DESC');
                $rowcount = (int)Config::get('custom.rowcount');
                $p = Input::get('page', 1);
                $option = (int)Input::get('option', 0);

                $sql = '' .
                    'SELECT ' .
                    '(SELECT COUNT(*) FROM `Content` WHERE ApplicationID=a.ApplicationID AND StatusID=1) AS ContentCount, ' .
                    'c.CustomerID, ' .
                    'c.CustomerName, ' .
                    'a.Name, ' .
                    'IFNULL((SELECT DisplayName FROM `GroupCodeLanguage` WHERE GroupCodeID=a.ApplicationStatusID AND LanguageID=' . (int)Session::get('language_id') . '), \'\') AS ApplicationStatusName, ' .
                    'IFNULL((SELECT Name FROM `Package` WHERE PackageID=a.PackageID), \'\') AS PackageName, ' .
                    '(CASE a.Blocked WHEN 1 THEN \'' . __('common.applications_list_blocked1') . '\' ELSE \'' . __('common.applications_list_blocked0') . '\' END) AS Blocked, ' .
                    '(CASE a.Status WHEN 1 THEN \'' . __('common.applications_list_status1') . '\' ELSE \'' . __('common.applications_list_status0') . '\' END) AS Status, ' .
                    '(CASE a.Trail WHEN 2 THEN \'' . __('common.applications_trail_customer') . '\' ELSE \'' . __('common.applications_trail_demo') . '\' END) AS Trail, ' .
                    '(CASE WHEN a.ExpirationDate < NOW() THEN \'' . __('common.applications_isexpired_yes') . '\' ELSE \'' . __('common.applications_isexpired_no') . '\' END) AS IsExpired, ' .
                    'a.ExpirationDate, ' .
                    'a.ApplicationID ' .
                    'FROM `Customer` AS c ' .
                    'INNER JOIN `Application` AS a ON a.CustomerID=c.CustomerID AND a.StatusID=1 ' .
                    'WHERE c.StatusID=1';

                $rs = DB::table(DB::raw('(' . $sql . ') t'))
                    ->where(function ($query) use ($customerID, $search) {
                        /** @var Laravel\Database\Query $query */
                        if ($customerID > 0) {
                            $query->where('CustomerID', '=', $customerID);
                        }

                        if (strlen(trim($search)) > 0) {
                            $query->where('ContentCount', 'LIKE', '%' . $search . '%');
                            $query->or_where('CustomerName', 'LIKE', '%' . $search . '%');
                            $query->or_where('Name', 'LIKE', '%' . $search . '%');
                            $query->or_where('ApplicationStatusName', 'LIKE', '%' . $search . '%');
                            $query->or_where('PackageName', 'LIKE', '%' . $search . '%');
                            $query->or_where('Blocked', 'LIKE', '%' . $search . '%');
                            $query->or_where('Status', 'LIKE', '%' . $search . '%');
                            $query->or_where('ApplicationID', 'LIKE', '%' . $search . '%');
                        }
                    })
                    ->order_by($sort, $sort_dir);

                if ($option == 1) {
                    $data = array(
                        'rows' => $rs->get()
                    );
                    return View::make('pages.' . Str::lower($this->table) . 'optionlist', $data);
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
                return View::make('pages.' . Str::lower($this->table) . 'list', $data)
                    ->nest('filterbar', 'sections.filterbar', $data)
                    ->nest('commandbar', 'sections.commandbar', $data);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
//				return Redirect::to(__('route.home'));
            }
        } else {
            $option = (int)Input::get('option', 0);

            if ($option == 1) {
                $data = array(
                    'rows' => $currentUser->Customer()->Applications(eStatus::Active)
                );
                return View::make('pages.' . Str::lower($this->table) . 'optionlist', $data);
            }
        }
        return Redirect::to(__('route.home'));
    }

    /**
     * @return \Laravel\Redirect|\Laravel\View
     */
    public function get_new()
    {
        if (Auth::User()->UserTypeID != eUserTypes::Manager) {
            return Redirect::to(__('route.home'));
        }

        $customers = Customer::where('StatusID', '=', eStatus::Active)
            ->order_by('CustomerName', 'ASC')
            ->get();

        $groupcodes = DB::table('GroupCode AS gc')
            ->join('GroupCodeLanguage AS gcl', function ($join) {
                $join->on('gcl.GroupCodeID', '=', 'gc.GroupCodeID');
                $join->on('gcl.LanguageID', '=', DB::raw((int)Session::get('language_id')));
            })
            ->where('gc.GroupName', '=', 'ApplicationStatus')
            ->where('gc.StatusID', '=', eStatus::Active)
            ->order_by('gc.DisplayOrder', 'ASC')
            ->order_by('gcl.DisplayName', 'ASC')
            ->get();

        $packages = Package::order_by('PackageID', 'ASC')->get();

        $app = new Application();
        $data = array(
            'app' => $app,
            'customers' => $customers,
            'groupcodes' => $groupcodes,
            'packages' => $packages,
            'page' => $this->page,
            'route' => $this->route,
            'caption' => $this->caption,
            'detailcaption' => $this->detailcaption
        );
        return View::make('pages.' . Str::lower($this->table) . 'detail', $data)
            ->nest('filterbar', 'sections.filterbar', $data);
    }

    /**
     * @param $id
     * @return \Laravel\Redirect|\Laravel\View
     */
    public function get_show($id)
    {
        if (Auth::User()->UserTypeID != eUserTypes::Manager) {
            return Redirect::to(__('route.home'));
        }

        $app = Application::find($id);
        if (!$app) {
            return Redirect::to($this->route);
        }

        $customers = Customer::where('StatusID', '=', eStatus::Active)
            ->order_by('CustomerName', 'ASC')
            ->get();

        $groupcodes = DB::table('GroupCode AS gc')
            ->join('GroupCodeLanguage AS gcl', function ($join) {
                $join->on('gcl.GroupCodeID', '=', 'gc.GroupCodeID');
                $join->on('gcl.LanguageID', '=', DB::raw((int)Session::get('language_id')));
            })
            ->where('gc.GroupName', '=', 'ApplicationStatus')
            ->where('gc.StatusID', '=', eStatus::Active)
            ->order_by('gc.DisplayOrder', 'ASC')
            ->order_by('gcl.DisplayName', 'ASC')
            ->get();

        $packages = Package::order_by('PackageID', 'ASC')->get();
        $data = array(
            'app' => $app,
            'customers' => $customers,
            'groupcodes' => $groupcodes,
            'packages' => $packages,
            'page' => $this->page,
            'route' => $this->route,
            'caption' => $this->caption,
            'detailcaption' => $this->detailcaption,
        );

        return View::make('pages.' . Str::lower($this->table) . 'detail', $data)
            ->nest('filterbar', 'sections.filterbar', $data);

    }

    /**
     * @param $id
     * @return string
     */
    public function post_push($id)
    {
        try {
            $rules = array(
                'NotificationText' => 'required'
            );
            $v = Validator::make(Input::all(), $rules);
            if ($v->fails()) {
                throw new Exception(__('common.detailpage_validation'));
            }

            $chk = Common::CheckApplicationOwnership($id);
            if (!$chk) {
//				throw new Exception("Unauthorized user attempt");
                throw new Exception(__('error.unauthorized_user_attempt'));
            }

            $currentUser = Auth::User();
            DB::transaction(function () use ($currentUser, $id) {
                $customerID = 0;
                $applicationID = 0;

                $app = DB::table('Application')->where('ApplicationID', '=', (int)$id)->first();
                if ($app) {
                    $customerID = (int)$app->CustomerID;
                    $applicationID = (int)$app->ApplicationID;
                }

                $s = new PushNotification();
                $s->CustomerID = (int)$customerID;
                $s->ApplicationID = (int)$applicationID;
                $s->NotificationText = Input::get('NotificationText');
                $s->StatusID = eStatus::Active;
                $s->CreatorUserID = $currentUser->UserID;
                $s->DateCreated = new DateTime();
                $s->ProcessUserID = $currentUser->UserID;
                $s->ProcessDate = new DateTime();
                $s->ProcessTypeID = eProcessTypes::Insert;
                $s->save();

                //Insert
                $deviceTokens = array();
                //Son geleni son alalim... onemli
                $tokens = DB::table('Token')
                    ->where('ApplicationID', '=', (int)$applicationID)
                    ->where("StatusID", '=', eStatus::Active)
                    ->get();
                foreach ($tokens as $token) {
                    if (!in_array($token->DeviceToken, $deviceTokens)) {
                        //save to push notification
                        $p = new PushNotificationDevice();
                        $p->PushNotificationID = $s->PushNotificationID;
                        $p->TokenID = $token->TokenID;
                        $p->UDID = $token->UDID;
                        $p->ApplicationToken = $token->ApplicationToken;
                        $p->DeviceToken = $token->DeviceToken;
                        $p->DeviceType = $token->DeviceType;
                        $p->Sent = 0;
                        $p->ErrorCount = 0;
                        $p->StatusID = eStatus::Active;
                        $p->CreatorUserID = $currentUser->UserID;
                        $p->DateCreated = new DateTime();
                        $p->ProcessUserID = $currentUser->UserID;
                        $p->ProcessDate = new DateTime();
                        $p->ProcessTypeID = eProcessTypes::Insert;
                        $p->save();
                        array_push($deviceTokens, $token->DeviceToken);
                    }
                }
            });

            // burada queueya atiyoruz
            $connection = new AMQPConnection('localhost', 5672, 'galepress', 'galeprens');
            $channel = $connection->channel();
            $channel->queue_declare('queue_pushnotification', false, false, false, false);
            $msg = new AMQPMessage('Start Progress!');
            $channel->basic_publish($msg, '', 'queue_pushnotification');
            $channel->close();
            $connection->close();
        } catch (Exception $e) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
        return "success=" . base64_encode("true");
    }

    //POST
    /**
     * @return string
     */
    public function post_save()
    {
        $currentUser = Auth::User();
        if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
            $id = (int)Input::get($this->pk, '0');

            $rules = array(
                'CustomerID' => 'required',
                'Name' => 'required',
                'ExpirationDate' => 'required',
                'PackageID' => 'required|integer',
                'ApplicationLanguage' => 'required',
            );
            $v = Validator::make(Input::all(), $rules);
            if ($v->passes()) {
                //File
                $sourceFileName = Input::get('hdnCkPemName');
                $sourceFilePath = 'files/temp';
                $sourceRealPath = path('public') . $sourceFilePath;
                $sourceFileNameFull = $sourceRealPath . '/' . $sourceFileName;

                $targetFileName = $currentUser->UserID . '_' . date("YmdHis") . '_' . $sourceFileName;

                if (!((int)Input::get('hdnCkPemSelected', 0) == 1 && File::exists($sourceFileNameFull))) {
                    $targetFileName = $sourceFileName;
                }

                if ($id == 0) {
                    $s = new Application();
                } else {
                    $s = Application::find($id);
                }
                $s->CustomerID = (int)Input::get('CustomerID');
                $s->Name = Input::get('Name');
                $s->Detail = Input::get('Detail');
                $s->ApplicationLanguage = Input::get('ApplicationLanguage');
                $s->Price = str_replace(',', '', Input::get('Price'));
                $s->Installment = Input::get('Installment', Application::InstallmentCount);
                $s->InAppPurchaseActive = Input::get('InAppPurchaseActive', 0);
                $s->FlipboardActive = Input::get('FlipboardActive', 0);
                $s->BundleText = strtolower(Input::get('BundleText'));
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
                $s->Trail = (int)Input::get('Trail');
                $s->NotificationText = Input::get('NotificationText');
                $s->CkPem = $targetFileName;
                $s->save();

                if ((int)Input::get('hdnCkPemSelected', 0) == 1 && File::exists($sourceFileNameFull)) {
                    $applicationID = $s->ApplicationID;
                    $customerID = Application::find($applicationID)->CustomerID;

                    //$targetFileName = $currentUser->UserID.'_'.date("YmdHis").'_'.$sourceFileName;
                    $targetFilePath = 'files/customer_' . $customerID . '/application_' . $applicationID;
                    $targetRealPath = path('public') . $targetFilePath;
                    $targetFileNameFull = $targetRealPath . '/' . $targetFileName;

                    if (!File::exists($targetRealPath)) {
                        File::mkdir($targetRealPath);
                    }

                    File::move($sourceFileNameFull, $targetFileNameFull);
                }

                return "success=" . base64_encode("true");
            } else {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
            }
        }
        return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
    }

    /**
     * @return string
     */
    public function post_delete()
    {
        $currentUser = Auth::User();
        $id = (int)Input::get($this->pk, '0');
        $s = Application::find($id);

        if ((int)$currentUser->UserTypeID != eUserTypes::Manager || !$s) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        $s->StatusID = eStatus::Deleted;
        $s->save();
        return "success=" . base64_encode("true");
    }

    /**
     *
     */
    public function post_uploadfile()
    {
        $element = Input::get('element');

        $options = array(
            'upload_dir' => path('public') . 'files/temp/',
            'upload_url' => URL::base() . '/files/temp/',
            'param_name' => $element,
            'accept_file_types' => '/\.(pem)$/i'
        );
        $upload_handler = new UploadHandler($options);

        if (!Request::ajax())
            return;

        $upload_handler->post(false);
    }

    /**
     * @param $id
     * @return \Laravel\Redirect|\Laravel\View
     */
    public function get_applicationSetting($id)
    {

        $this->detailcaption = __('common.application_settings_caption_detail');

        $application = Application::find($id);
        if ($application) {
            $tabs = $application->Tabs();
            for ($i = 0; $i < TAB_COUNT; $i++) {
                if (!isset($tabs[$i])) {
                    $tabs[] = new Tab();
                }
            }

            $galepressTabs = Tab::getGalepresTabs();
            $data = array(
                'page' => $this->page,
                'route' => $this->route,
                'caption' => $this->detailcaption,
                'application' => $application,
                'tabs' => $tabs,
                'galepressTabs' => $galepressTabs
            );
            return View::make('pages.applicationsetting', $data)
                ->nest('filterbar', 'sections.filterbar', $data);
        } else {
            return Redirect::to($this->route);
        }
    }

    /**
     * @return string
     */
    public function post_applicationSetting()
    {
        $rules = array(
            "ThemeForegroundColor" => 'match:/^#[A-Fa-f0-9]{6}$/'
        );

        $v = Laravel\Validator::make(Input::all(), $rules);
        if (!$v->passes()) {
            $errMsg = $v->errors->first();
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($errMsg);
        }

        $application = Application::find((int)Input::get("ApplicationID", 0));
        if (!$application || !$application->CheckOwnership()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('error.unauthorized_user_attempt'));
        }

        $application->ThemeBackground = (int)Input::get("ThemeBackground", 1);
        $application->ThemeForegroundColor = Input::get("ThemeForegroundColor");
        $application->TabActive = (int)Input::get("TabActive", 0);
        $application->ShowDashboard = (int)Input::get('ShowDashboard', 0);
        $application->ConfirmationMessage = Input::get("ConfirmationMessage", '');

        $tabs = $application->Tabs();
        for ($i = 0; $i < TAB_COUNT; $i++) {
            if (!isset($tabs[$i])) {
                $tabs[] = new Tab();
            }
            $j = $i + 1;
            $tabs[$i]->ApplicationID = $application->ApplicationID;
            $tabs[$i]->TabTitle = Input::get("TabTitle_" . $j, 'Başlık ' . $j);
            $tabs[$i]->Url = Input::get("Url_" . $j, '');
            $tabs[$i]->InhouseUrl = Input::get("InhouseUrl_" . $j, '');
            $tabs[$i]->IconUrl = Input::get("hiddenSelectedIcon_" . $j, '/img/app-icons/1.png');
            $tabs[$i]->Status = (int)Input::get("TabStatus_" . $j, 0);
            $tabs[$i]->StatusID = eStatus::Active;
            $tabs[$i]->save();
        }

        if ($application->InAppPurchaseActive) {
            $application->IOSHexPasswordForSubscription = Input::get('IOSHexPasswordForSubscription', '');
            foreach (Subscription::types() as $key => $subscription) {
                $application->subscriptionStatus($key, Input::get("SubscriptionStatus_" . $key));
            }
        }

        if (!$application->dirty()) {
            $application->incrementAppVersion();
        } else {
            $application->save();
        }

        return "success=" . base64_encode("true");
    }

    /**
     * @return string
     */
    public function post_refresh_identifier()
    {
        $max = 1;
        foreach (Subscription::types() as $key => $value) {
            if ($key > $max) {
                $max = $key;
            }
        }

        $rules = array(
            "ApplicationID" => "required|numeric|min:1",
            "SubscrioptionType" => "required|numeric|min:1|max:" . $max,
        );
        $v = Validator::make(Input::all(), $rules);
        if (!$v->passes()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($v->errors->first());
//	    ajaxResponse::error($v->errors->first());
        }

        $application = Application::find(Input::get("ApplicationID"));
        $subscriptionIdentifier = $application->SubscriptionIdentifier(Input::get("SubscrioptionType"), TRUE);
        $application->save();
        return "success=" . base64_encode("true") . "&SubscriptionIdentifier=" . base64_encode($subscriptionIdentifier);
    }

    /**
     * @param $fileName
     * @return \Laravel\Response
     */
    public function get_theme($fileName)
    {
        return Response::make(eTemplateColor::templateCss($fileName), 200, array('content-type' => 'text/css'));
    }
}
