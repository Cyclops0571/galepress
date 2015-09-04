<?php

class Clients_Controller extends Base_Controller {

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

    public function get_index() {
	//throw new Exception("error da errrorr");
	$applicationID = (int) Input::get('applicationID', 0);

	/* @var $currentUser User  */
	$currentUser = Auth::User();

	if ($applicationID != 0) {
	    /* @var $applications Application[] */
	    $applications = array();
	    $application = Application::find($applicationID);
	    if ($application->CustomerID != $currentUser->CustomerID) {
		\Laravel\Redirect::to(__('route.home'));
	    }
	    $applications[] = $application;
	} else {
	    $applications = $currentUser->Application();
	}

	$appIDSet = array();


	foreach ($applications as $app) {
	    $appIDSet[] = $app->ApplicationID;
	}

	$search = Input::get('search', '');
	$sort = Input::get('sort', $this->pk);
	$sort_dir = Input::get('sort_dir', 'DESC');
	$rowcount = (int) Config::get('custom.rowcount');
	$p = Input::get('page', 1);

	$rs = Client::where_in('ApplicationID', $appIDSet)->where('StatusID', '=', eStatus::Active)->order_by($sort, $sort_dir);
	if (!empty($search)) {
	    $rs->where(function($myquery) use ($search) {
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

    public function get_new() {
	/* @var $currentUser User */
	$currentUser = Auth::User();
	$data = array();
	$data['page'] = $this->page;
	$data['route'] = $this->route;
	$data['caption'] = $this->caption;
	$data['detailcaption'] = $this->detailcaption;
	$data['applications'] = $currentUser->Application();
	return View::make(Laravel\Request::$route->controller . '.' . Str::lower($this->table) . 'detail', $data)
			->nest('filterbar', 'sections.filterbar', $data);
    }

    public function get_show($id) {
	/* @var $currentUser User */
	$currentUser = Auth::User();

	/* @var $client Client */
	$client = Client::find($id);
	if (!$client) {
	    \Laravel\Redirect::to($this->route);
	}
	$data = array(
	    'page' => $this->page,
	    'route' => $this->route,
	    'caption' => $this->caption,
	    'detailcaption' => $this->detailcaption,
	    'row' => $client,
	    'applications' => $currentUser->Application()
	);
	return View::make(Laravel\Request::$route->controller . '.' . Str::lower($this->table) . 'detail', $data)
			->nest('filterbar', 'sections.filterbar', $data);
    }

    /**
     * Makes StatusID eStatus::Deleted from Client
     * @return type
     */
    public function post_delete() {
	$currentUser = Auth::User();
	$id = (int) Input::get($this->pk, '0');

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
    public function post_save() {
	/* @var $currentUser User */
	$currentUser = Auth::User();
	/* @var $applications Application[] */
	$applications = $currentUser->Application();
	$appIDSet = array();
	foreach ($applications as $application) {
	    $appIDSet[] = $application->ApplicationID;
	}

	$id = (int) Input::get($this->pk, '0');

	$rules = array(
	    'UserTypeID' => 'required',
	    'Username' => 'required|min:2',
	    'FirstName' => 'required',
	    'LastName' => 'required',
	    'Email' => 'required|email'
	);

	$v = Validator::make(Input::all(), $rules);
	if (!$v->passes()) {
	    return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
	}

	$password = Input::get('Password');

	
	$username = trim(Input::get('Username'));
	$applicationID = Input::get('ApplicationID');
	$email = Input::get('Email;');
	
	if ($id == 0) {
	    $clientSameUsername = Client::where('ApplicationID', "=", $applicationID)->where('Username', '=', $username)->first();
	    $clientSameEmail = Client::where('ApplicationID', "=", $applicationID)->where('Email', '=', $email)->first();
	    if ($clientSameUsername) {
		return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(Common::localize("username_must_be_unique"));
	    } else if($clientSameEmail) {
		return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(Common::localize("email_must_be_unique"));
	    } else {
		
	    }
	    $s = new Client();
	} else {
	    $s = Client::find($id);
	}
	$s->Username = $username;
	$s->Email = $email;
	$s->ApplicationID = $applicationID;
	if (strlen(trim($password)) > 0) {
	    $s->Password = md5($password);
	}
	
	$s->Name = Input::get('FirstName');
	$s->Surname = Input::get('LastName');
	if ($id == 0) {
	    $s->StatusID = eStatus::Active;
	    $s->CreatorUserID = $currentUser->UserID;
	}

	if (!in_array($s->ApplicationID, $appIDSet)) {
	    return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_unauthorized_attempt'));
	}

	$s->save();
	return "success=" . base64_encode("true");
    }

    /**
     * Send new password to user who forgets it
     * @return type
     */
    public function post_send() {
	return "post_send";
	$currentUser = Auth::User();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    $id = (int) Input::get($this->pk, '0');

	    $s = User::find($id);
	    if ($s) {
		$pass = Common::generatePassword();

		$s->Password = Hash::make($pass);
		$s->ProcessUserID = $currentUser->UserID;
		$s->ProcessDate = new DateTime();
		$s->ProcessTypeID = eProcessTypes::Update;
		$s->save();

		$subject = __('common.login_resetpassword_email_subject');
		$msg = __('common.login_resetpassword_email_message', array(
		    'firstname' => $s->FirstName,
		    'lastname' => $s->LastName,
		    'pass' => $pass
			)
		);

		Common::sendEmail($s->Email, $s->FirstName . ' ' . $s->LastName, $subject, $msg);
	    }
	    return "success=" . base64_encode("true");
	}
	return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
    }

    public function post_excelupload() {
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
	    return;
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
	    $includeAppColumn = 0;
	    if(count($appIDSet) > 1) {
		$includeAppColumn = 1;
	    }
	    
	    
	    if ($rowCount < 2) {
		$responseMsg = Common::localize("invalid_excel_file_two_rows");
	    } else if($columnCount != 7) {
		$responseMsg = Common::localize("invalid_excel_file_seven_columns");
	    } else {
		$addedUserCount = 0;
		$updatedUserCount = 0;
		for ($row = 2; $row <= $rowCount; $row++) {
		    $colNo = 1;
		    $applicationID = $data->val($row, $colNo++);
		    $username = $data->val($row, $colNo++);
		    $password = $data->val($row, $colNo++);
		    $email = $data->val($row, $colNo++);
		    $name = $data->val($row, $colNo++);
		    $surname = $data->val($row, $colNo++);
		    $paidUntil = date("Y-m-d", strtotime($data->val($row, $colNo++)));
		    if (!in_array($applicationID, $appIDSet)) {
			$responseMsg .= Common::localize("invalid_application_id_at_row") . $row;
			break;
		    }

		    /* @var $client Client */
		    $clientSameUsername = Client::where('ApplicationID', "=", $applicationID)->where('Username', '=', $username)->first();
		    $clientSameEmail = Client::where('ApplicationID', "=", $applicationID)->where('Email', '=', $email)->first();
		    if ($clientSameUsername) {
			//user exists upgrade or what ???
			$clientSameUsername->Name = $name;
			$clientSameUsername->Surname = $surname;
			$clientSameUsername->PaidUntil = $paidUntil;
			$clientSameUsername->save();
			$updatedUserCount++;
			continue;
		    } else if($clientSameEmail) {
			$clientSameEmail->Name = $name;
			$clientSameEmail->Surname = $surname;
			$clientSameEmail->PaidUntil = $paidUntil;
			$clientSameEmail->save();
			$updatedUserCount++;
			continue;
		    }

		    $client = new Client();
		    $client->ApplicationID = $applicationID;
		    $client->Username = $username;
		    $client->Password = md5($password);
		    $client->Email = $email;
		    $client->Name = $name;
		    $client->Surname = $surname;
		    $client->PaidUntil = $paidUntil;
		    $client->StatusID = eStatus::Active;
		    $client->CreatorUserID = $user->UserID;
		    $client->save();
		    $addedUserCount++;
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
}
