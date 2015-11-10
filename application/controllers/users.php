<?php

class Users_Controller extends Base_Controller {

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
	$this->page = 'users';
	$this->route = __('route.' . $this->page);
	$this->table = 'User';
	$this->pk = 'UserID';
	$this->caption = __('common.users_caption');
	$this->detailcaption = __('common.users_caption_detail');
	$this->fields = array(
	    0 => array('35px', __('common.users_list_column1'), ''),
	    1 => array('125px', __('common.users_list_column2'), 'UserTypeName'),
	    2 => array('125px', __('common.users_list_column3'), 'FirstName'),
	    3 => array('', __('common.users_list_column4'), 'LastName'),
	    4 => array('175px', __('common.users_list_column5'), 'Email'),
	    5 => array('75px', __('common.users_list_column6'), 'UserID')
	);
    }

    public function get_index() {
	$currentUser = Auth::User();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    try {
		$customerID = (int) Input::get('customerID', 0);
		$search = Input::get('search', '');
		$sort = Input::get('sort', $this->pk);
		$sort_dir = Input::get('sort_dir', 'DESC');
		$rowcount = (int) Config::get('custom.rowcount');
		$p = Input::get('page', 1);

		$sql = '' .
			'SELECT ' 
			. 'u.CustomerID, ' 
			. '(SELECT DisplayName FROM `GroupCodeLanguage` WHERE GroupCodeID=u.UserTypeID AND '
			. 'LanguageID=' . (int) Session::get('language_id') . ') AS UserTypeName, ' 
			. 'u.FirstName, ' 
			. 'u.LastName, ' 
			. 'u.Email, ' 
			. 'u.UserID ' 
			. 'FROM `User` AS u ' 
			. 'WHERE u.StatusID=1';

		$rs = DB::table(DB::raw('(' . $sql . ') t'))
			->where(function($query) use($customerID, $search) {
			    if ($customerID > 0) {
				$query->where('CustomerID', '=', $customerID);
			    }

			    if (strlen(trim($search)) > 0) {
				$query->where('UserTypeName', 'LIKE', '%' . $search . '%');
				$query->or_where('FirstName', 'LIKE', '%' . $search . '%');
				$query->or_where('LastName', 'LIKE', '%' . $search . '%');
				$query->or_where('Email', 'LIKE', '%' . $search . '%');
				$query->or_where('UserID', 'LIKE', '%' . $search . '%');
			    }
			})
			->order_by($sort, $sort_dir);

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
		//throw new Exception($e->getMessage());
		return Redirect::to(__('route.home'));
	    }
	}
	return Redirect::to(__('route.home'));
    }

    public function get_new() {
	$currentUser = Auth::User();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    $data = array(
		'page' => $this->page,
		'route' => $this->route,
		'caption' => $this->caption,
		'detailcaption' => $this->detailcaption
	    );
	    return View::make('pages.' . Str::lower($this->table) . 'detail', $data)
			    ->nest('filterbar', 'sections.filterbar', $data);
	}
	return Redirect::to(__('route.home'));
    }

    public function get_show($id) {
	$currentUser = Auth::User();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    $row = User::find($id);
	    if ($row) {
		$data = array(
		    'page' => $this->page,
		    'route' => $this->route,
		    'caption' => $this->caption,
		    'detailcaption' => $this->detailcaption,
		    'row' => $row
		);
		return View::make('pages.' . Str::lower($this->table) . 'detail', $data)
				->nest('filterbar', 'sections.filterbar', $data);
	    } else {
		return Redirect::to($this->route);
	    }
	}
	return Redirect::to(__('route.home'));
    }

    //POST
    public function post_save() {
	$currentUser = Auth::User();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    $id = (int) Input::get($this->pk, '0');

	    $rules = array(
		'UserTypeID' => 'required',
		'Username' => 'required',
		//'Password'  => 'required_with:UserID|min:6|max:12',
		'FirstName' => 'required',
		'LastName' => 'required',
		'Email' => 'required|email'
	    );
	    $v = Validator::make(Input::all(), $rules);
	    if ($v->passes()) {
		$password = Input::get('Password');

		if ($id == 0) {
		    $s = new User();
		} else {
		    $s = User::find($id);
		}
		$s->UserTypeID = (int) Input::get('UserTypeID');
		$s->CustomerID = (int) Input::get('CustomerID');
		$s->Username = Input::get('Username');
		if (strlen(trim($password)) > 0) {
		    $s->Password = Hash::make($password);
		}
		$s->FirstName = Input::get('FirstName');
		$s->LastName = Input::get('LastName');
		$s->Email = Input::get('Email');
		$s->Timezone = Input::get('Timezone');
		if ($id == 0) {
		    $s->StatusID = eStatus::Active;
		    $s->CreatorUserID = $currentUser->UserID;
		    $s->DateCreated = new DateTime();
		}
		$s->ProcessUserID = $currentUser->UserID;
		$s->ProcessDate = new DateTime();
		if ($id == 0) {
		    $s->ProcessTypeID = eProcessTypes::Insert;
		} else {
		    $s->ProcessTypeID = eProcessTypes::Update;
		}
		$s->save();
		return "success=" . base64_encode("true");
	    } else {
		return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
	    }
	}
	return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
    }

    /**
     * Send new password to user who forgets it
     * @return type
     */
    public function post_send() {
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
		    'username' => $s->Username,
		    'pass' => $pass
			)
		);

		Common::sendEmail($s->Email, $s->FirstName . ' ' . $s->LastName, $subject, $msg);
	    }
	    return "success=" . base64_encode("true");
	}
	return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
    }

    /**
     * Makes StatusID eStatus::Deleted from user
     * @return type
     */
    public function post_delete() {
	$currentUser = Auth::User();

	if ((int) $currentUser->UserTypeID == eUserTypes::Manager) {
	    $id = (int) Input::get($this->pk, '0');

	    $s = User::find($id);
	    if ($s) {
		$s->StatusID = eStatus::Deleted;
		$s->ProcessUserID = $currentUser->UserID;
		$s->ProcessDate = new DateTime();
		$s->ProcessTypeID = eProcessTypes::Update;
		$s->save();
	    }
	    return "success=" . base64_encode("true");
	}
	return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
    }

}
