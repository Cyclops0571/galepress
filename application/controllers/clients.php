<?php

class Clients_Controller extends Base_Controller
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
        $this->page = 'clients';
        $this->route = __('route.' . $this->page);
        $this->table = 'Client';
        $this->pk = 'ClientID';
        $this->caption = __('common.clients_caption');
        $this->detailcaption = __('common.clients_caption_detail');

        $this->fields = array(
            0 => array('35px', __('common.clients_list_column1'), ''),
            1 => array('75px', __('common.clients_list_column2'), 'Username'),
            2 => array('75px', __('common.clients_list_column3'), 'Name'),
            3 => array('75px', __('common.clients_list_column4'), 'Surname'),
            4 => array('100px', __('common.clients_list_column5'), 'Email'),
            5 => array('75px', __('common.clients_list_column6'), 'ApplicationID'),
            6 => array('100px', __('common.clients_list_column7'), 'LastLoginDate'),
            7 => array('25px', __('common.clients_list_column8'), 'ClientID')
        );
    }

    public function get_index()
    {
        /** @var User $currentUser */
        $currentUser = Auth::User();
        $applications = $currentUser->Application();
        if (empty($applications)) {
            throw new Exception('This user does not have applications. UserID: ' . $currentUser->UserID);
        }

        $appIDSet = array();

        foreach ($applications as $app) {
            $appIDSet[] = $app->ApplicationID;
        }

        $search = Input::get('search', '');
        $sort = Input::get('sort', $this->pk);
        $sort_dir = Input::get('sort_dir', 'DESC');
        $rowcount = (int)Config::get('custom.rowcount');
        $p = Input::get('page', 1);

        $rs = Client::where_in('ApplicationID', $appIDSet)->where('StatusID', '=', eStatus::Active)->order_by($sort, $sort_dir);
        if (!empty($search)) {
            $rs->where(function ($myquery) use ($search) {
                $myquery->or_where('Username', 'LIKE', '%' . $search . '%');
                $myquery->where('Name', 'LIKE', '%' . $search . '%');
                $myquery->or_where('Surname', 'LIKE', '%' . $search . '%');
                $myquery->or_where('Email', 'LIKE', '%' . $search . '%');
                $myquery->or_where('ClientID', 'LIKE', '%' . $search . '%');
            });
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
            'rows' => $rows,
            'applications' => $applications
        );

        return View::make(Laravel\Request::$route->controller . '.' . Str::lower($this->table) . 'list', $data)
            ->nest('filterbar', 'sections.filterbar', $data)
            ->nest('commandbar', 'sections.commandbar', $data);
    }

    public function get_new()
    {
        $selectableContents = NULL;
        /* @var $currentUser User */
        $currentUser = Auth::User();
        $applications = $currentUser->Application();
        foreach ($applications as $app) {
            $tmpContents = $app->Contents(eStatus::Active);
            foreach ($tmpContents as $tmp) {
                $selectableContents[] = $tmp;
            }
        }

        $data = array();
        $data['page'] = $this->page;
        $data['route'] = $this->route;
        $data['caption'] = $this->caption;
        $data['detailcaption'] = $this->detailcaption;
        $data['applications'] = $applications;
        $data['contents'] = array();
        $data['selectableContents'] = $selectableContents;

        return View::make(Laravel\Request::$route->controller . '.' . Str::lower($this->table) . 'detail', $data)
            ->nest('filterbar', 'sections.filterbar', $data);
    }

    public function get_show($id)
    {
        $selectableContents = NULL;
        /* @var $currentUser User */
        $currentUser = Auth::User();

        /* @var $client Client */
        $client = Client::find($id);

        if (!$client) {
            \Laravel\Redirect::to($this->route);
        }
        $applications = $currentUser->Application();
        foreach ($applications as $app) {
            $tmpContents = $app->Contents(eStatus::Active);
            foreach ($tmpContents as $tmp) {
                $selectableContents[] = $tmp;
            }
        }

        $contents = $client->Contents();
        foreach ($selectableContents as $key => $selectableContent) {
            foreach ($contents as $content) {
                if ($selectableContent->ContentID == $content->ContentID) {
                    unset($selectableContents[$key]);
                }
            }
        }

        $data = array();
        $data['page'] = $this->page;
        $data['route'] = $this->route;
        $data['caption'] = $this->caption;
        $data['detailcaption'] = $this->detailcaption;
        $data['row'] = $client;
        $data['applications'] = $applications;
        $data['contents'] = $contents;
        $data['selectableContents'] = $selectableContents;
        return View::make(Laravel\Request::$route->controller . '.' . Str::lower($this->table) . 'detail', $data)
            ->nest('filterbar', 'sections.filterbar', $data);
    }

    /**
     * Makes StatusID eStatus::Deleted from Client
     * @return type
     */
    public function post_delete()
    {
        $currentUser = Auth::User();
        $id = (int)Input::get($this->pk, '0');

        $s = Client::find($id);
        if (!$s) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        /* @var $applications Application[] */
        $applications = $currentUser->Application();
        $appIDSet = array();
        foreach ($applications as $application) {
            $appIDSet[] = $application->ApplicationID;
        }

        if (!in_array($s->ApplicationID, $appIDSet)) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_unauthorized_attempt'));
        }

        $s->StatusID = eStatus::Deleted;
        $s->save();
        return "success=" . base64_encode("true");
    }

    //POST
    public function post_save()
    {
        /* @var $currentUser User */
        $currentUser = Auth::User();
        /* @var $applications Application[] */
        $applications = $currentUser->Application();
        $appIDSet = array();
        foreach ($applications as $application) {
            $appIDSet[] = $application->ApplicationID;
        }

        $clientID = (int)Input::get($this->pk, '0');
        $password = Input::get('Password');
        $username = trim(Input::get('Username'));
        $applicationID = Input::get('ApplicationID');
        $email = Input::get('Email');
        $contentIDSet = \Laravel\Input::get("contentIDSet", array());

        $rules = array(
            'Username' => 'required|min:2',
            'FirstName' => 'required',
            'LastName' => 'required',
            'Email' => 'required|email',
        );

        if ($clientID == 0) {
            $rules['Password'] = 'required|min:2';
            $clientSameUsername = Client::where('ApplicationID', "=", $applicationID)->where('Username', '=', $username)->first();
            $clientSameEmail = Client::where('ApplicationID', "=", $applicationID)->where('Email', '=', $email)->first();
            if ($clientSameUsername) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(Common::localize("username_must_be_unique"));
            } else if ($clientSameEmail) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(Common::localize("email_must_be_unique"));
            }
            $client = new Client();
            $client->Token = $username . "_" . md5(uniqid());
        } else {
            $client = Client::find($clientID);
            if (!$client) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(Common::localize("user_not_found"));
            }

            $clientSameUsername = Client::where('ApplicationID', "=", $applicationID)->where('Username', '=', $username)->where('ClientID', "!=", $client->ClientID)->first();
            $clientSameEmail = Client::where('ApplicationID', "=", $applicationID)->where('Email', '=', $email)->where('ClientID', "!=", $client->ClientID)->first();
            if ($clientSameUsername) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(Common::localize("username_must_be_unique"));
            } else if ($clientSameEmail) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(Common::localize("email_must_be_unique"));
            }
        }

        $v = Validator::make(Input::all(), $rules);
        if (!$v->passes()) {
            return ajaxResponse::error($v->errors->first());
        }

        $client->Username = $username;
        $client->Email = $email;
        $client->ApplicationID = $applicationID;

        if (strlen(trim($password)) > 0) {
            $client->Password = md5($password);
        }

        $client->Name = Input::get('FirstName');
        $client->Surname = Input::get('LastName');
        if ($clientID == 0) {
            $client->StatusID = eStatus::Active;
            $client->CreatorUserID = $currentUser->UserID;
        }

        if (count($appIDSet) == 1) {
            $client->ApplicationID = $appIDSet[0];
        } else if (!in_array($client->ApplicationID, $appIDSet)) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_unauthorized_attempt'));
        }

        $selecteableContentIDSet = array();
        foreach ($applications as $application) {
            $contents = $application->Contents();
            foreach ($contents as $content) {
                $selecteableContentIDSet[] = $content->ContentID;
            }
        }
        foreach ($contentIDSet as $key => $contentID) {
            if (!in_array($contentID, $selecteableContentIDSet)) {
                unset($contentIDSet[$key]);
            }
        }

        $contentIDSet = array_unique($contentIDSet);
        sort($contentIDSet);
        $client->ContentIDSet = implode(",", $contentIDSet);
        $client->save();
        return "success=" . base64_encode("true") . "&id=" . base64_encode($client->ClientID);
    }

    /**
     * Insert New Clients From Excel
     * @return HTML
     */
    public function post_excelupload()
    {
//        $obj = new stdClass();
//        $obj->responseMsg = (string)'asdfasdf';
//        $obj->status = 'success';
//        return Response::json($obj);

        $selectableContentIDSet = NULL;
        $responseMsg = "";
        $status = "Failed";
        /* @var $user User */
        $user = Auth::User();
        $applications = $user->Application();
        $appIDSet = array();
        foreach ($applications as $application) {
            $appIDSet[] = $application->ApplicationID;
        }
        ob_start();
        $element = Input::get('element');
        $options = array(
            'upload_dir' => path('public') . 'files/temp/',
            'upload_url' => URL::base() . '/files/temp/',
            'param_name' => $element,
            'accept_file_types' => '/\.(xls)$/i'
        );
        $upload_handler = new UploadHandler($options);

        if (!Request::ajax()) {
            return Response::error('404');
        }


        $upload_handler->post(false);

        $ob = ob_get_contents();
        ob_end_clean();
        $object = json_decode($ob);
        $filePath = path('public') . 'files/temp/' . $object->File[0]->name;

        include_once path("base") . "application/libraries/excel_reader2.php";
        error_reporting(E_ALL ^ E_NOTICE);
        $data = new Spreadsheet_Excel_Reader($filePath);
        $rowCount = $data->rowcount();
        $columnCount = $data->colcount();

        if ($rowCount < 2) {
            $responseMsg = Common::localize("invalid_excel_file_two_rows");
        } else if ($columnCount != 8) {
            $responseMsg = Common::localize("invalid_excel_file_seven_columns");
        } else {
            $addedUserCount = 0;
            $updatedUserCount = 0;
            for ($row = 2; $row <= $rowCount; $row++) {
                $colNo = 1;
                $applicationID = (int)$data->val($row, $colNo++);
                $username = $data->val($row, $colNo++);
                $password = $data->val($row, $colNo++);
                $email = $data->val($row, $colNo++);
                $name = $data->val($row, $colNo++);
                $surname = $data->val($row, $colNo++);
                $paidUntil = date("Y-m-d", strtotime($data->val($row, $colNo++)));
                $contentIDSetNew = explode(",", $data->val($row, $colNo));
                if ($applicationID <= 0) {
                    continue;
                }

                if (!in_array($applicationID, $appIDSet)) {
                    $responseMsg .= Common::localize("invalid_application_id_at_row") . $row;
                    break;
                }

                /* @var $client Client */
                $clientSameUsername = Client::where('ApplicationID', "=", $applicationID)->where('Username', '=', $username)->first();
                $clientSameEmail = Client::where('ApplicationID', "=", $applicationID)->where('Email', '=', $email)->first();
                if ($clientSameUsername) {
                    //user exists same
                    $client = $clientSameUsername;
                    $client->Name = $name;
                    $client->Surname = $surname;
                    $client->PaidUntil = $paidUntil;
                    $updatedUserCount++;
                } else if ($clientSameEmail) {
                    $client = $clientSameEmail;
                    $client->Name = $name;
                    $client->Surname = $surname;
                    $client->PaidUntil = $paidUntil;
                    $updatedUserCount++;
                } else {
                    $client = new Client();
                    $client->ApplicationID = $applicationID;
                    $client->Username = $username;
                    $client->Token = $client->Username . "_" . md5(uniqid());
                    $client->Password = md5($password);
                    $client->Email = $email;
                    $client->Name = $name;
                    $client->Surname = $surname;
                    $client->PaidUntil = $paidUntil;
                    $client->StatusID = eStatus::Active;
                    $client->CreatorUserID = $user->UserID;
                    $addedUserCount++;
                }

                //Uygulama sahibi bu contentID ye yetkilendirme yapabilir mi diye bakmiyorum su anda ama bakmaliyim...
                if (!empty($contentIDSetNew)) {
                    $contentIDSet = explode(",", $client->ContentIDSet);
                    $mergedContentIDSet = array_merge($contentIDSet, $contentIDSetNew);
                    $uniqueContentIDSet = array_unique($mergedContentIDSet);
                    sort($uniqueContentIDSet);
                    $filteredContentIDSet = array_filter($uniqueContentIDSet);
                    if (count($filteredContentIDSet) != $contentIDSet) {
                        if ($selectableContentIDSet == NULL) {
                            $selectableContentIDSet = array();
                            foreach ($applications as $application) {
                                $contents = $application->Contents();
                                foreach ($contents as $content) {
                                    $selectableContentIDSet[] = $content->ContentID;
                                }
                            }
                        }
                        //yeni eklenilenler var
                        foreach ($filteredContentIDSet as $key => $contentID) {
                            if (!in_array($contentID, $selectableContentIDSet)) {
                                unset($filteredContentIDSet[$key]);
                            }
                        }
                    }
                    $client->ContentIDSet = implode(",", $filteredContentIDSet);
                }
                $client->save();
            }

            $responseMsg .= Common::localize('inserted_mobile_user_count') . $addedUserCount . " " . Common::localize('updated_mobile_user_count') . $updatedUserCount;
            $status = 'success';
        }

        $json = get_object_vars($object);
        $arr = $json[$element];
        $obj = $arr[0];
        $obj->responseMsg = (string)$responseMsg;
        $obj->status = $status;

        return Response::json($obj);
    }

    /**
     * Mobil application interface for register
     * urlEN: clients/register/ApplicationID
     * urlDU: klient/registrieren/ApplicationID
     * urlTR: mobil-kullanici/kayitol/ApplicationID
     * @param int $applicationID
     * @return HTML
     */
    public function get_clientregister($applicationID)
    {
        $application = Application::find($applicationID);
        $data = array();
        $data["application"] = $application;
        return View::make(Laravel\Request::$route->controller . '.clientregister', $data);
    }

    /**
     * Mobil application interface for user profile update
     */
    public function get_updateclient($applicationID, $clientToken)
    {
        /* @var $client Client */
        $client = Client::where('Token', '=', $clientToken)->first();
        if (!$client) {
            return Redirect::to(str_replace("(:num)", $applicationID, __("route.clients_register")));
        }
        $data = array();
        $data["application"] = $client->Application;
        $data["client"] = $client;
        //
        return View::make(Laravel\Request::$route->controller . '.clientregister', $data);
    }


    public function post_clientregister()
    {
        $clientID = (int)Input::get($this->pk, '0');
        $username = trim(Input::get('Username'));
        $applicationID = Input::get('ApplicationID');
        $email = Input::get('Email');
        $password = Input::get('Password');
        $newPassword = Laravel\Input::get('NewPassword');
        $newPassword2 = Laravel\Input::get('NewPassword2');

        $rules = array(
            'ApplicationID' => 'required',
            'Username' => 'required|min:2',
            'Password' => 'required|min:2',
            'FirstName' => 'required',
            'LastName' => 'required',
            'Email' => 'required|email'
        );
        if ($clientID == 0) {
            $rules['Password'] = 'required|min:2|max:12';
            $rules['Password2'] = 'required|min:2|max:12|same:Password';
        }

        $v = Laravel\Validator::make(Input::all(), $rules);
        if (!$v->passes()) {
            return ajaxResponse::error(__('common.detailpage_validation'));
        }

        if ($clientID == 0) {
            $clientSameUsername = Client::where('ApplicationID', "=", $applicationID)->where('Username', '=', $username)->first();
            $clientSameEmail = Client::where('ApplicationID', "=", $applicationID)->where('Email', '=', $email)->first();
            if ($clientSameUsername) {
                return ajaxResponse::error(Common::localize("username_must_be_unique"));
            } else if ($clientSameEmail) {
                return ajaxResponse::error(Common::localize("email_must_be_unique"));
            }

            $client = new Client();
            $client->Password = md5($password);
            $client->Token = $username . "_" . md5(uniqid());
            $client->StatusID = eStatus::Active;
            $client->CreatorUserID = 0;
        } else {
            //current password is a must !!!
            $client = Client::find($clientID);
            if (!$client) {
                return ajaxResponse::error(Common::localize("user_not_found"));
            } else if ($client->ApplicationID != $applicationID) {
                return ajaxResponse::error(Common::localize("client_application_invalid"));
            }

            $clientSameUsername = Client::where('ApplicationID', "=", $applicationID)->where('Username', '=', $username)->where('ClientID', "!=", $client->ClientID)->first();
            $clientSameEmail = Client::where('ApplicationID', "=", $applicationID)->where('Email', '=', $email)->where('ClientID', "!=", $client->ClientID)->first();
            if ($clientSameUsername) {
                return ajaxResponse::error(Common::localize("username_must_be_unique"));
            } else if ($clientSameEmail) {
                return ajaxResponse::error(Common::localize("email_must_be_unique"));
            }

            if ($client->Password != md5($password)) {
                return ajaxResponse::error(Common::localize("invalid_password"));
            }

            if (!empty($newPassword) || !empty($newPassword2)) {
                if ($newPassword != $newPassword2) {
                    return ajaxResponse::error(Common::localize("password_does_not_match"));
                }
                $client->Password = md5($newPassword);
            }
        }

        $client->Username = $username;
        $client->Email = $email;
        $client->ApplicationID = $applicationID;
        $client->Name = Input::get('FirstName');
        $client->Surname = Input::get('LastName');
        $client->save();

        $application = Application::find($applicationID);
        $subject = __('clients.registered_email_subject', array('Application' => $application->Name));
        $msg = __('clients.registered_email_message', array(
                'Application' => $application->Name,
                'firstname' => $client->Name,
                'lastname' => $client->Surname,
                'username' => $client->Username,
                'pass' => empty($newPassword) ? $password : $newPassword
            )
        );
        Common::sendEmail($client->Email, $client->Name . ' ' . $client->Surname, $subject, $msg);

        return ajaxResponse::success(Laravel\URL::to_route("clientsregistered") . "?usertoken=" . $client->Token);
    }

    /**
     * Show successfull register message
     * @return type
     */
    public function get_registered()
    {
        //ajax ile atilan request duzgun ise buraya donecegim.
        $data = array();
        return View::make(Laravel\Request::$route->controller . '.registered', $data);
    }

    public function get_forgotpassword($applicationID)
    {
        $application = Application::find($applicationID);
        $data = array();
        $data["application"] = $application;
        return View::make(Laravel\Request::$route->controller . "." . Laravel\Request::$route->controller_action, $data);
    }

    public function post_forgotpassword()
    {
        $rules = array(
            'Email' => 'required|email',
            'ApplicationID' => 'required',
        );

        $v = Laravel\Validator::make(Input::all(), $rules);
        if ($v->invalid()) {
            $errorMsg = $v->errors->first();
            if (empty($errorMsg)) {
                $errorMsg = __('common.detailpage_validation');
            }
            return ajaxResponse::error($errorMsg);
        }
        $email = Laravel\Input::get("Email");
        $applicationID = Laravel\Input::get("ApplicationID");
        /* @var $client Client */
        $client = Client::where('ApplicationID', "=", $applicationID)->where('Email', '=', $email)->first();
        if (!$client) {
            return ajaxResponse::error(Common::localize("user_not_found"));
        }

        $application = Application::find($applicationID);
        $client->PWRecoveryCode = Common::generatePassword();
        $client->PWRecoveryDate = new DateTime();
        $client->save();

        $subject = __('clients.login_email_subject', array('Application' => $application->Name));
        $msg = __('clients.login_email_message', array(
                'Application' => $application->Name,
                'firstname' => $client->Name,
                'lastname' => $client->Surname,
                'username' => $client->Username,
                'url' => Laravel\URL::to_route("clientsresetpw") . "?ApplicationID=" . $applicationID . "&email=" . $client->Email . "&code=" . $client->PWRecoveryCode
            )
        );

        Common::sendEmail($client->Email, $client->Name . ' ' . $client->Surname, $subject, $msg);
        return ajaxResponse::success(__('common.login_emailsent'));
    }

    /**
     * Mobil application interface for renewing user password
     * @return HTML
     */
    public function get_resetpw()
    {
        $errorMsg = "";
        $rules = array(
            'ApplicationID' => 'required',
            'email' => 'required|email',
            'code' => 'required|min:2',
        );

        $v = Laravel\Validator::make(Input::all(), $rules);
        if ($v->invalid()) {
            $errorMsg = $v->errors->first();
            if (empty($errorMsg)) {
                $errorMsg = __('common.login_ticketnotfound');
            }
        }

        $applicationID = Input::get("ApplicationID");
        $email = Input::get("email");
        $code = Input::get("code");

        $client = Client::where("ApplicationID", "=", $applicationID)
            ->where("Email", "=", $email)
            ->where("PwRecoveryCode", "=", $code)
            ->where("PwRecoveryDate", ">", DB::raw('ADDDATE(CURDATE(), INTERVAL -7 DAY)'))
            ->where("StatusID", "=", eStatus::Active)
            ->first();

        if (!$client) {
            $errorMsg = __('common.login_ticketnotfound');
        }

        $data = array();
        $data["errorMsg"] = $errorMsg;
        return View::make(Laravel\Request::$route->controller . "." . Laravel\Request::$route->controller_action, $data);
    }

    /**
     * Saves new user password then redirect to successful token page
     */
    public function post_resetpw()
    {
        $rules = array(
            'Email' => 'required|email',
            'Code' => 'required',
            'Password' => 'required|min:6|max:12',
            'Password2' => 'required|min:6|max:12|same:Password'
        );

        $v = Validator::make(Input::all(), $rules);
        if ($v->invalid()) {
            $errorMsg = $v->errors->first();
            if (empty($errorMsg)) {
                $errorMsg = __('common.detailpage_validation');
            }
            return ajaxResponse::error($errorMsg);
        }

        $applicationID = Input::get('ApplicationID');

        /* @var $client Client */
        $client = $client = Client::where("ApplicationID", "=", $applicationID)
            ->where("Email", "=", Input::get('Email'))
            ->where("PwRecoveryCode", "=", Input::get('Code'))
            ->where("PwRecoveryDate", ">", DB::raw('ADDDATE(CURDATE(), INTERVAL -7 DAY)'))
            ->where("StatusID", "=", eStatus::Active)
            ->first();
        if (!$client) {
            return ajaxResponse::error(__('common.login_ticketnotfound'));
        }

        $application = $application = Application::find($applicationID);
        $pass = trim(Input::get("Password"));
        $client->Password = md5($pass);
        $client->save();

        $subject = __('clients.login_resetpassword_email_subject', array('Application' => $application->Name,));
        $msg = __('clients.login_resetpassword_email_message', array(
                'Application' => $application->Name,
                'firstname' => $client->Name,
                'lastname' => $client->Surname,
                'username' => $client->Username,
                'pass' => $pass
            )
        );
        Common::sendEmail($client->Email, $client->Name . ' ' . $client->Surname, $subject, $msg);


        return ajaxResponse::success(Laravel\URL::to_route("pwreseted") . "?usertoken=" . $client->Token);
    }

    public function get_passwordreseted()
    {
        $data = array();
        return View::make(Laravel\Request::$route->controller . '.passwordreseted', $data);
    }
}
