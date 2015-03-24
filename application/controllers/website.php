<?php

class Website_Controller extends Base_Controller
{
	public $restful = true;
	
	public function get_home()
	{
		return View::make('website.pages.home');
	}

	public function get_aboutus()
	{
		return View::make('website.pages.aboutus');
	}

	public function get_galepress()
	{
		return View::make('website.pages.galepress');
	}

	public function get_products()
	{
		return View::make('website.pages.products');
	}

	public function get_advantages()
	{
		return View::make('website.pages.advantages');
	}

	public function get_customers()
	{
		return View::make('website.pages.showcase');
	}

	public function get_tutorials()
	{
		return View::make('website.pages.tutorials');
	}

	public function get_contact()
	{
		return View::make('website.pages.contact');
	}

	public function get_sitemap()
	{
		return View::make('website.pages.sitemap');
	}

	public function get_search()
	{
		return View::make('website.pages.search');
	}

	public function get_blog()
	{
		return View::make('website.pages.blog-iframe');
	}

	public function get_sectors()
	{
		return View::make('website.pages.sectors');
	}

	public function get_sectors_retail()
	{
		return View::make('website.pages.sectors-retail');
	}

	public function get_sectors_humanresources()
	{
		return View::make('website.pages.sectors-humanresources');
	}

	public function get_sectors_education()
	{
		return View::make('website.pages.sectors-education');
	}

	public function get_sectors_realty()
	{
		return View::make('website.pages.sectors-realty');
	}

	public function get_sectors_medicine()
	{
		return View::make('website.pages.sectors-medicine');
	}

	public function get_sectors_digitalpublishing()
	{
		return View::make('website.pages.sectors-digitalpublishing');
	}

	public function get_tryit()
	{
		return View::make('website.pages.tryit');
	}

	public function get_why_galepress()
	{
		return View::make('website.pages.why-galepress');
	}

	public function post_tryit()
	{
		//date_default_timezone_set('Europe/Istanbul');
		$errors = array();
		$data = array(); 

		$customerName = Input::get('name', '');

		$customerLastName = Input::get('last_name', '');

		$email = Input::get('email', '');

		$appName = Input::get('app_name', '');

		$userName = Input::get('user_name', '');

		$password = Input::get('password', '');

		$password_verify = Input::get('password_verify', '');

		$captcha = Input::get('captcha', '');


		if (empty($customerName) || $customerName=="undefined")
			$errors['name'] = 'First name is required.';

		if (empty($customerLastName) || $customerLastName=="undefined")
			$errors['last_name'] = 'Last name is required.';

		if (empty($email) || $email=="undefined")
			$errors['email'] = 'Email is required.';

		if (empty($appName) || $appName=="undefined")
			$errors['app_name'] = 'appName is required.';

		if (empty($userName) || $userName=="undefined")
			$errors['user_name'] = 'user_name is required.';

		if (empty($password) || $password=="undefined")
			$errors['password'] = 'password is required.';

		if (empty($password_verify) || $password_verify=="undefined")
			$errors['password_verify'] = 'password_verify is required.';

		if ($password != $password_verify)
			$errors['password_verify'] = 'Passwords must be matched';

		if (empty($captcha) || $captcha=="undefined")
			$errors['captcha'] = 'captcha is required';

		$rules = array(
        'captcha' => 'mecaptcha|required'
	    );

	    $validation = Validator::make(Input::all(), $rules);

	    if ($validation->valid())
	    {
	        //$errors['captcha'] = 'Invalid captcha';
	    }
	    else if($captcha && !empty($captcha))
	    {
	    	$errors['captcha_invalid'] = 'Invalid captcha';
	    }

		//$errors['customerLastName'] = $customerLastName;

		$emailExist = DB::table('User')
			->where('Email', '=', $email)
			->first();

		if($emailExist && !empty($email))
		{
			$errors['email_exist'] = 'Email is already exist';
		}

		$userNameExist = DB::table('User')
			->where('Username', '=', $userName)
			->first();

		if($userNameExist && !empty($userName))
		{
			$errors['user_name_exist'] = 'User is already exist';
		}

		// if there are errors
		if (!empty($errors)) {
			$data['success'] = false;
			$data['errors'] = $errors;
			$data['messageError'] = 'Please check the fields in red';
		} 
		else {
			//$data['userNameExist'] = $userNameExist;
			$lastCustomerNo = DB::table('Customer')
				->order_by('CustomerID', 'DESC')
				->take(1)
				->only('CustomerNo');

			//$data['lastCustomerNo'] = $lastCustomerNo;
			
			preg_match('!\d+!', $lastCustomerNo, $matches);
			$matches=intval($matches[0]);
			$matches++;
			// if there are no errors, return a message
			$data['success'] = true;

			$today = new DateTime();
			$todayAddWeek = Date("Y-m-d", strtotime("+7 days"));

			$s = new Customer();
			$s->CustomerNo = "m0".$matches;
			$s->CustomerName = $customerName." ".$customerLastName;
			$s->Email = $email;
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
			$s->Name = $appName;
			$s->StartDate = $today;
			$s->ExpirationDate = $todayAddWeek;
			$s->ApplicationStatusID = 151;
			$s->PackageID = 5;
			$s->Blocked = 0;
			$s->Status = 1;
			$s->Version = 1;
			$s->StatusID = eStatus::Active;
			$s->CreatorUserID = -1;
			$s->DateCreated = new DateTime();
			$s->ProcessUserID = -1;
			$s->ProcessDate = new DateTime();
			$s->ProcessTypeID = eProcessTypes::Insert;
			$s->save();

			// $data['bugun'] = $today;
			// $data['exp-date'] = $todayAddWeek;
			// $data['lastCustomerID'] = $lastCustomerID;

			$confirmCode=rand(10000,99999);

			$s = new User();
			
			$s->UserTypeID = 111;
			$s->CustomerID = $lastCustomerID;
			$s->Username = $userName;
			$s->Password = Hash::make(trim($password));
			$s->FirstName = $customerName;
			$s->LastName = $customerLastName;
			$s->Email = $email;
			$s->StatusID = 0;
			$s->CreatorUserID = -1;
			$s->DateCreated = new DateTime();
			$s->ProcessUserID = -1;
			$s->ProcessDate = new DateTime();
			$s->ProcessTypeID = eProcessTypes::Insert;
			$s->ConfirmCode = $confirmCode;
			$s->save();

            $subject = "Kaydınızı Tamamlayın";
            $msg = __('common.confirm_email_message', array(
              'firstname' => $s->FirstName,
              'lastname' => $s->LastName,
              'url' => Config::get("custom.url") . '/'.Config::get('application.language').'/'.__('route.confirmemail').'?email='.$s->Email.'&code='.$confirmCode
              )
            );
            
            Common::sendEmail($s->Email, $s->FirstName.' '.$s->LastName, $subject, $msg);
		 
		}
		echo json_encode($data);
	}

	public function get_article_workflow()
	{
		try
		{
			return View::make('website.pages.article-workflow');
		}
		catch(Exception $e)
		{
			//throw new Exception($e->getMessage());
			return Redirect::to(__('route.website_blog'));
		}
		
	}
	public function get_article_brandvalue()
	{
		try
		{
			return View::make('website.pages.article-brandvalue');
		}
		catch(Exception $e)
		{
			//throw new Exception($e->getMessage());
			return Redirect::to(__('route.website_blog'));
		}
		
	}
	public function get_article_whymobile()
	{
		try
		{
			return View::make('website.pages.article-whymobile');
		}
		catch(Exception $e)
		{
			//throw new Exception($e->getMessage());
			return Redirect::to(__('route.website_blog'));
		}
		
	}
}