<?php

class Common_Controller extends Base_Controller {

	public $restful = true;

	//login
	public function get_login() {
		if (Auth::check()) {
			return Redirect::to(__('route.home'));
		} else {
			return View::make('pages.login');
		}
	}

	public function post_login() {
		$username = Input::get('Username', '');
		$password = Input::get('Password', '');
		$remember = Input::get('Remember', '');

		$validUser = false;
		$activeApps = false;

		$user = DB::table('User')
				->where('Username', '=', $username)
				//->where('Password', '=', Hash::make($password))
				->where('StatusID', '=', eStatus::Active)
				->first();
		if ($user) {
			if (Hash::check($password, $user->Password)) {
				if ((int) $user->UserTypeID == (int) eUserTypes::Customer) {
					$customer = DB::table('Customer')
							->where('CustomerID', '=', $user->CustomerID)
							->where('StatusID', '=', eStatus::Active)
							->first();
					if ($customer) {

						$validUser = true;

						$activeApps = DB::table('Application')
										->where('CustomerID', '=', $customer->CustomerID)
										->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
										->where('StatusID', '=', eStatus::Active)
										->count() > 0;
					}
				} else if ((int) $user->UserTypeID == (int) eUserTypes::Manager) {
					$validUser = true;
					$activeApps = true;
				}
			}
		}

		if (!$validUser) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_error'));
		}

		if (!$activeApps) {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_error_expiration'));
		}

		//Kullanici aktif & Musteriyse (musteri aktif & aktif uygulamaya sahip)

		if (Auth::attempt(array('username' => $username, 'password' => $password, 'StatusID' => eStatus::Active))) {
			$user = Auth::User();
			$s = new Sessionn;
			$s->UserID = $user->UserID;
			$s->IP = Request::ip(); //getenv("REMOTE_ADDR");
			$s->Session = Session::instance()->session['id'];
			$s->LoginDate = new DateTime();
			$s->StatusID = eStatus::Active;
			$s->CreatorUserID = $user->UserID;
			$s->DateCreated = new DateTime();
			$s->ProcessUserID = $user->UserID;
			$s->ProcessDate = new DateTime();
			$s->ProcessTypeID = eProcessTypes::Insert;
			$s->save();

			if ($remember == "on") {
				Cookie::forever('DSCATALOG_USERNAME', $user->Username);
			} else {
				Cookie::forever('DSCATALOG_USERNAME', '');
			}

			setcookie("loggedin", "true", time() + 3600, "/");

			return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_success_redirect'));
		} else {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_error'));
		}
	}

	//forgotmypassword
	public function get_forgotmypassword() {
		return View::make('pages.forgotmypassword');
	}

	public function post_forgotmypassword() {
		$email = Input::get('Email');
		$rules = array(
			'Email' => 'required|email'
		);
		$v = Validator::make(Input::all(), $rules);
		if ($v->passes()) {
			$user = DB::table('User')
					->where('Email', '=', $email)
					->where('StatusID', '=', 1)
					->first();

			if ($user) {
				$pass = Common::generatePassword();

				$s = User::find($user->UserID);
				$s->PWRecoveryCode = $pass;
				$s->PWRecoveryDate = new DateTime();
				$s->ProcessUserID = $user->UserID;
				$s->ProcessDate = new DateTime();
				$s->ProcessTypeID = eProcessTypes::Update;
				$s->save();

				$subject = __('common.login_email_subject');
				$msg = __('common.login_email_message', array(
					'firstname' => $user->FirstName,
					'lastname' => $user->LastName,
					'url' => 'http://www.galepress.com/' . Config::get('application.language') . '/' . __('route.resetmypassword') . '?email=' . $user->Email . '&code=' . $pass
						)
				);

				Common::sendEmail($user->Email, $user->FirstName . ' ' . $user->LastName, $subject, $msg);

				return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_emailsent'));
			} else {
				return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_emailnotfound'));
			}
		} else {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
	}

	//resetmypassword
	public function get_resetmypassword() {
		$email = Input::get('email');
		$code = Input::get('code');

		$user = DB::table('User')
				->where('Email', '=', $email)
				->where('PWRecoveryCode', '=', $code)
				->where('PWRecoveryDate', '>', DB::raw('ADDDATE(CURDATE(), INTERVAL -7 DAY)'))
				->where('StatusID', '=', 1)
				->first();

		if ($user) {
			return View::make('pages.resetmypassword');
		} else {
			return Redirect::to(__('route.login'))
							->with('message', __('common.login_ticketnotfound'));
		}
	}

	public function post_resetmypassword() {
		$email = Input::get('Email');
		$code = Input::get('Code');
		$password = Input::get('Password');

		$rules = array(
			'Email' => 'required|email',
			'Code' => 'required',
			'Password' => 'required|min:6|max:12',
			'Password2' => 'required|min:6|max:12|same:Password'
		);
		$v = Validator::make(Input::all(), $rules);
		if ($v->passes()) {
			$user = DB::table('User')
					->where('Email', '=', $email)
					->where('PWRecoveryCode', '=', $code)
					->where('PWRecoveryDate', '>', DB::raw('ADDDATE(CURDATE(), INTERVAL -7 DAY)'))
					->where('StatusID', '=', 1)
					->first();

			if ($user) {
				$s = User::find($user->UserID);
				$s->Password = Hash::make($password);
				$s->ProcessUserID = $user->UserID;
				$s->ProcessDate = new DateTime();
				$s->ProcessTypeID = eProcessTypes::Update;
				$s->save();

				return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_passwordhasbeenchanged'));
			} else {
				return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_ticketnotfound'));
			}
		} else {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
	}

	//logout
	public function get_logout() {
		if (Auth::check()) {
			$user = Auth::User();

			$sessionID = DB::table('Session')
					->where('UserID', '=', $user->UserID)
					->where('Session', '=', Session::instance()->session['id'])
					->max('SessionID');

			if ((int) $sessionID > 0) {
				$s = Sessionn::find($sessionID);
				$s->LogoutDate = new DateTime();
				$s->ProcessUserID = $user->UserID;
				$s->ProcessDate = new DateTime();
				$s->ProcessTypeID = eProcessTypes::Update;
				$s->save();
			}
			Auth::logout();
		}

		setcookie("loggedin", "false", time(), "/");

		return Redirect::to(__('route.login'))
						->with('message', __('common.login_succesfullyloggedout'));
	}

	//home
	public function get_home() {
		if ((int) Auth::User()->UserTypeID == eUserTypes::Manager) {
			return View::make('pages.homeadmin');
		}

		$applications = DB::table('Application')
				->where('CustomerID', '=', Auth::User()->CustomerID)
				->where('StatusID', '=', eStatus::Active)
				->order_by('Name', 'ASC')
				->get();

		//parametrik olacak
		$customerID = (int) Auth::User()->CustomerID;
		$applicationID = (int) Input::get('ddlApplication', '0');
		if ($applicationID == 0) {
			foreach ($applications as $app) {
				$applicationID = (int) $app->ApplicationID;
				break;
			}
		} else if (!Common::CheckApplicationOwnership($applicationID)) {
			return;
		}
		$contentID = (int) Input::get('ddlContent', '0');
		$date = Common::dateWrite(Input::get('date', date("d.m.Y")), false);

		$appDetail = Application::where('ApplicationID', '=', $applicationID)->first();
		$arrApp = array();
		foreach ($applications as $app) {
			array_push($arrApp, (int) $app->ApplicationID);
		}
		$contentCount = DB::table('Content')->where_in('ApplicationID', $arrApp)->where('StatusID', '=', eStatus::Active)->count();

		//indirilme raporu son hafta
		$w = array_fill(1, 7, '0');
		$downloadMaxData = 0;
		$downloadTotalData = 0;
		$downloadTodayTotalData = 0;
		$downloadMonthTotalData = 0;
		$sql = File::get(path('public') . 'files/report.sql/Dashboard1.sql');
		$sql = str_replace('{DATE}', $date, $sql);
		$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? '' . $customerID : 'null'), $sql);
		$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? '' . $applicationID : 'null'), $sql);
		$sql = str_replace('{CONTENTID}', ($contentID > 0 ? '' . $contentID : 'null'), $sql);
		$downloadStatistics = DB::table(DB::raw('(' . $sql . ') t'))->get();

		foreach ($downloadStatistics as $d) {
			if ((int) $d->indx == 199) {
				//Today
				$downloadTodayTotalData = (int) $d->DownloadCount;
			} elseif ((int) $d->indx == 299) {
				//Month
				$downloadMonthTotalData = (int) $d->DownloadCount;
			} else {
				//Selected week
				$w[$d->indx] = $d->DownloadCount;
				$downloadTotalData = $downloadTotalData + (int) $d->DownloadCount;

				if ($downloadMaxData < (int) $d->DownloadCount) {
					$downloadMaxData = $d->DownloadCount;
				}
			}
		}

		$columns = array();
		for ($i = 0; $i < 7; $i++) {
			$add_day = strtotime($date . " - $i days");
			$columns[$i] = date('d', $add_day) . ' ' . Common::monthName((int) date('m', $add_day));
		}

		//indirilme raporu son 5 ay
		$sql = File::get(path('public') . 'files/report.sql/Dashboard2.sql');
		$sql = str_replace('{DATE}', $date, $sql);
		$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? '' . $customerID : 'null'), $sql);
		$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? '' . $applicationID : 'null'), $sql);
		$sql = str_replace('{CONTENTID}', ($contentID > 0 ? '' . $contentID : 'null'), $sql);
		$previousMonths = DB::table(DB::raw('(' . $sql . ') t'))->get();
		$previousMonthsMaxData = 0;
		foreach ($previousMonths as $d) {
			if ($previousMonthsMaxData < (int) $d->DownloadCount) {
				$previousMonthsMaxData = $d->DownloadCount;
			}
		}

		//cihaz son 5 ay
		$sql = File::get(path('public') . 'files/report.sql/Dashboard3.sql');
		$sql = str_replace('{DATE}', $date, $sql);
		$sql = str_replace('{CUSTOMERID}', ($customerID > 0 ? '' . $customerID : 'null'), $sql);
		$sql = str_replace('{APPLICATIONID}', ($applicationID > 0 ? '' . $applicationID : 'null'), $sql);
		$sql = str_replace('{CONTENTID}', ($contentID > 0 ? '' . $contentID : 'null'), $sql);
		$devices = DB::table(DB::raw('(' . $sql . ') t'))->get();
		//return var_dump($devices);

		$iosTotalDownload = 0;
		$androidTotalDownload = 0;

		$ios = array_fill(1, 5, '0');
		$android = array_fill(1, 5, '0');
		foreach ($devices as $d) {
			if ($d->Device == 'iOS') {
				$ios[$d->indx] = $d->DownloadCount;
				$iosTotalDownload = $iosTotalDownload + (int) $d->DownloadCount;
			} else if ($d->Device == 'Android') {
				$android[$d->indx] = $d->DownloadCount;
				$androidTotalDownload = $androidTotalDownload + (int) $d->DownloadCount;
			}
		}
		$ios = array_reverse($ios);
		$android = array_reverse($android);

		$deviceColumns = array();
		foreach ($previousMonths as $month) {
			array_push($deviceColumns, Common::monthName($month->Month) . " " . $month->Year);
		}

		$data = array(
			'customerID' => $customerID,
			'applicationID' => $applicationID,
			'contentID' => $contentID,
			'date' => $date,
			'appDetail' => $appDetail,
			'applications' => $applications,
			'applicationCount' => count($applications),
			'contentCount' => $contentCount,
			'downloadStatistics' => implode('-', $w),
			'downloadMaxData' => $downloadMaxData,
			'downloadTotalData' => $downloadTotalData,
			'downloadTodayTotalData' => $downloadTodayTotalData,
			'downloadMonthTotalData' => $downloadMonthTotalData,
			'columns' => implode('-', $columns),
			'previousMonths' => $previousMonths,
			'previousMonthsMaxData' => $previousMonthsMaxData,
			'iosTotalDownload' => $iosTotalDownload,
			'androidTotalDownload' => $androidTotalDownload,
			'iosDeviceDownload' => implode('-', $ios),
			'androidDeviceDownload' => implode('-', $android),
			'deviceColumns' => implode('-', $deviceColumns)
		);
		return View::make('pages.home', $data);
	}

	//mydetail
	public function get_mydetail() {
		$data = array(
			'page' => __('route.mydetail'),
			'caption' => __('common.mydetail')
		);
		return View::make('pages.mydetail')
						->nest('filterbar', 'sections.filterbar', $data);
	}

	public function post_mydetail() {
		$firstName = Input::get('FirstName');
		$lastName = Input::get('LastName');
		$email = Input::get('Email');
		$password = Input::get('Password', '');
		$timezone = Input::get('Timezone', '');

		$rules = array(
			'FirstName' => 'required',
			'LastName' => 'required',
			'Email' => 'required|email'
		);
		$v = Validator::make(Input::all(), $rules);
		if ($v->passes()) {
			$s = User::find(Auth::User()->UserID);
			$s->FirstName = $firstName;
			$s->LastName = $lastName;
			$s->Email = $email;
			if (strlen(trim($password)) > 0) {
				$s->Password = Hash::make($password);
			}
			$s->Timezone = $timezone;
			$s->ProcessUserID = Auth::User()->UserID;
			$s->ProcessDate = new DateTime();
			$s->ProcessTypeID = eProcessTypes::Update;
			$s->save();

			return "success=" . base64_encode("true");
		} else {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
	}

	public function get_confirmemail() {
		$email = Input::get('email');
		$code = Input::get('code');

		$rules = array(
			'email' => 'required|email',
			'code' => 'required',
		);
		$v = Validator::make(Input::all(), $rules);
		if ($v->passes()) {
			$user = DB::table('User')
					->where('Email', '=', $email)
					->where('ConfirmCode', '=', $code)
					->first();
			if ($user) {
				$s = User::find($user->UserID);
				$s->StatusID = eStatus::Active;
				$s->ProcessUserID = $user->UserID;
				$s->ProcessDate = new DateTime();
				$s->ProcessTypeID = eProcessTypes::Update;
				$s->save();

				// return View::make('pages.login')
				// ->with('message', "success=".base64_encode("false")."&errmsg=".base64_encode(__('common.login_accounthasbeenconfirmed')));

				return Redirect::to(__('route.login'))
								->with('confirm', __('common.login_accounthasbeenconfirmed'));

				//return "success=".base64_encode("true")."&msg=".base64_encode(__('common.login_accounthasbeenconfirmed'));
			} else {
				return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.login_accountticketnotfound'));
			}
		} else {
			return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
		}
	}

	public function post_facebookAttempt() {
		$facebookData = Input::get('formData', '');
		$faceUserObj = json_decode($facebookData);
		$accessToken = Input::get('accessToken', '');

		if (isset($faceUserObj->email)) {

			$userEmailControl = DB::table('User')
					->where('Email', '=', $faceUserObj->email)
					->where('StatusID', '=', eStatus::Active)
					->or_where('FbUsername', '=', $faceUserObj->id)
					->first();

			if ($userEmailControl) {
				$s = User::find($userEmailControl->UserID);
				$s->FbUsername = $faceUserObj->id;
				$s->FbEmail = $faceUserObj->email;
				$s->FbAccessToken = $accessToken;
				$s->PWRecoveryDate = new DateTime();
				$s->ProcessUserID = $userEmailControl->UserID;
				$s->ProcessDate = new DateTime();
				$s->ProcessTypeID = eProcessTypes::Update;
				$s->save();
			}
		} else {
			$faceUserObj->email = "";
		}

		$user = DB::table('User')
				->where('FbUsername', '=', $faceUserObj->id)
				// ->where('FbEmail', '=', $faceUserObj->email)
				//->where('Password', '=', Hash::make($password))
				->where('StatusID', '=', eStatus::Active)
				->first();

		if (!$user) {

			$lastCustomerNo = DB::table('Customer')
					->order_by('CustomerID', 'DESC')
					->take(1)
					->only('CustomerNo');

			preg_match('!\d+!', $lastCustomerNo, $matches);
			$matches = intval($matches[0]);
			$matches++;
			$data['success'] = true;

			$today = new DateTime();
			$todayAddWeek = Date("Y-m-d", strtotime("+7 days"));

			$s = new Customer();
			$s->CustomerNo = "m0" . $matches;
			$s->CustomerName = $faceUserObj->first_name . " " . $faceUserObj->last_name;
			$s->Email = $faceUserObj->email;
			$s->StatusID = eStatus::Active;
			$s->CreatorUserID = -1;
			$s->DateCreated = new DateTime();
			$s->ProcessUserID = -1;
			$s->ProcessDate = new DateTime();
			$s->ProcessTypeID = eProcessTypes::Insert;
			$s->save();

			$lastCustomerID = DB::table('Customer')
					->order_by('CustomerID', 'DESC')
					->take(1)
					->only('CustomerID');


			$s = new Application();
			$s->CustomerID = $lastCustomerID;
			$s->Name = $faceUserObj->first_name . $faceUserObj->last_name;
			$s->StartDate = $today;
			$s->ExpirationDate = $todayAddWeek;
			$s->ApplicationStatusID = 151;
			$s->PackageID = 5;
			$s->Blocked = 0;
			$s->Status = 1;
			$s->Trail = 1;
			$s->Version = 1;
			$s->StatusID = eStatus::Active;
			$s->Trail = 1;
			$s->CreatorUserID = -1;
			$s->DateCreated = new DateTime();
			$s->ProcessUserID = -1;
			$s->ProcessDate = new DateTime();
			$s->ProcessTypeID = eProcessTypes::Insert;
			$s->save();

			$s = new User();

			$s->UserTypeID = 111;
			$s->CustomerID = $lastCustomerID;
			$s->Username = $faceUserObj->id;
			$s->FbUsername = $faceUserObj->id;
			//$s->Password = Hash::make("TestPassword");
			$s->FirstName = $faceUserObj->first_name;
			$s->LastName = $faceUserObj->last_name;
			$s->Email = $faceUserObj->email;
			$s->FbEmail = $faceUserObj->email;
			$s->FbAccessToken = $accessToken;
			$s->StatusID = eStatus::Active;
			$s->CreatorUserID = -1;
			$s->DateCreated = new DateTime();
			$s->ProcessUserID = -1;
			$s->ProcessDate = new DateTime();
			$s->ProcessTypeID = eProcessTypes::Insert;
			//$s->ConfirmCode = $confirmCode;
			$s->save();

			$user = DB::table('User')
					->where('Username', '=', $faceUserObj->id)
					->where('FbEmail', '=', $faceUserObj->email)
					//->where('Password', '=', Hash::make($password))
					->where('StatusID', '=', eStatus::Active)
					->first();
			//var_dump(Hash::check(NULL, $user->Password));
			if (Auth::facebookAttempt(array('username' => $user->Username, 'fbemail' => $user->FbEmail, 'StatusID' => eStatus::Active))) {

				$user = Auth::User();
				$s = new Sessionn;
				$s->UserID = $user->UserID;
				$s->IP = Request::ip(); //getenv("REMOTE_ADDR");
				$s->Session = Session::instance()->session['id'];
				$s->LoginDate = new DateTime();
				$s->StatusID = eStatus::Active;
				$s->CreatorUserID = $user->UserID;
				$s->DateCreated = new DateTime();
				$s->ProcessUserID = $user->UserID;
				$s->ProcessDate = new DateTime();
				$s->ProcessTypeID = eProcessTypes::Insert;
				$s->save();

				Cookie::forever('DSCATALOG_USERNAME', $user->Username);

				setcookie("loggedin", "true", time() + 3600, "/");

				return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_success_redirect'));
			}
		} else {

			if (Auth::facebookAttempt(array('username' => $user->Username, 'fbemail' => $user->FbEmail, 'StatusID' => eStatus::Active))) {

				$user = Auth::User();
				$s = new Sessionn;
				$s->UserID = $user->UserID;
				$s->IP = Request::ip(); //getenv("REMOTE_ADDR");
				$s->Session = Session::instance()->session['id'];
				$s->LoginDate = new DateTime();
				$s->StatusID = eStatus::Active;
				$s->CreatorUserID = $user->UserID;
				$s->DateCreated = new DateTime();
				$s->ProcessUserID = $user->UserID;
				$s->ProcessDate = new DateTime();
				$s->ProcessTypeID = eProcessTypes::Insert;
				$s->save();

				Cookie::forever('DSCATALOG_USERNAME', '');

				setcookie("loggedin", "true", time() + 3600, "/");

				return "success=" . base64_encode("true") . "&msg=" . base64_encode(__('common.login_success_redirect'));
			}
		}
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

}
