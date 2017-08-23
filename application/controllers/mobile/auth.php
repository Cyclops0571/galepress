<?php

class Mobile_Auth_Controller extends Base_Controller
{
    public $restful = false;

    public function action_register($applicationID)
    {
        $application = Application::find($applicationID);
        $data = array();
        $data["application"] = $application;
        return view('mobile.register', $data);
    }

    public function action_edit($applicationID, $clientToken)
    {
        /* @var $client Client */
        $client = Client::where('Token', $clientToken)->first();
        if (!$client)
        {
            return Redirect::to(str_replace("(:num)", $applicationID, __("route.clients_register")));
        }
        $data = array();
        $data["application"] = $client->Application;
        $data["client"] = $client;

        //
        return view('mobile.register', $data);
    }


    public function action_store()
    {
        $clientID = Input::get('ClientID', '0');
        $username = trim(Input::get('Username'));
        $applicationID = Input::get('ApplicationID');
        $email = Input::get('Email');
        $password = Input::get('Password');
        $newPassword = Input::get('NewPassword');
        $newPassword2 = Input::get('NewPassword2');

        $rules = array(
            'ApplicationID' => 'required',
            'Username'      => 'required|min:2',
            'Password'      => 'required|min:2',
            'FirstName'     => 'required',
            'LastName'      => 'required',
            'Email'         => 'required|email',
        );
        if ($clientID == 0)
        {
            $rules['Password'] = 'required|min:2|max:12';
            $rules['Password2'] = 'required|min:2|max:12|same:Password';
        }

        $v = Validator::make(Input::all(), $rules);
        if ($v->fails())
        {
            return ajaxResponse::error(__('common.detailpage_validation'));
        }

        if ($clientID == 0)
        {
            $clientSameUsername = Client::where('ApplicationID', $applicationID)->where('Username', $username)->first();
            $clientSameEmail = Client::where('ApplicationID', $applicationID)->where('Email', $email)->first();
            if ($clientSameUsername)
            {
                return ajaxResponse::error(__('clients.username_must_be_unique'));
            } else if ($clientSameEmail)
            {
                return ajaxResponse::error(__('clients.email_must_be_unique'));
            }

            $client = new Client();
            $client->Password = md5($password);
            $client->Token = $username . "_" . md5(uniqid());
            $client->StatusID = eStatus::Active;
            $client->CreatorUserID = 0;
        } else
        {
            //current password is a must !!!
            $client = Client::find($clientID);
            if (!$client)
            {
                return ajaxResponse::error(__('clients.user_not_found'));
            } else if ($client->ApplicationID != $applicationID)
            {
                return ajaxResponse::error(__('clients.client_application_invalid'));
            }

            $clientSameUsername = Client::where('ApplicationID', $applicationID)
                ->where('Username', $username)
                ->where('ClientID', "!=", $client->ClientID)
                ->first();
            $clientSameEmail = Client::where('ApplicationID', $applicationID)
                ->where('Email', $email)
                ->where('ClientID', "!=", $client->ClientID)
                ->first();
            if ($clientSameUsername)
            {
                return ajaxResponse::error(__('clients.username_must_be_unique'));
            } else if ($clientSameEmail)
            {
                return ajaxResponse::error(__('clients.email_must_be_unique'));
            }

            if ($client->Password != md5($password))
            {
                return ajaxResponse::error(__("clients.invalid_password"));
            }

            if (!empty($newPassword) || !empty($newPassword2))
            {
                if ($newPassword != $newPassword2)
                {
                    return ajaxResponse::error(__("clients.password_does_not_match"));
                }
                $client->Password = md5($newPassword);
            }
        }

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
        return ajaxResponse::success(route('mobile_user_registration_success', array('usertoken' => $client->Token)));
    }

    public function action_forgotPasswordForm($applicationID)
    {
        $application = Application::find($applicationID);
        $data = array();
        $data["application"] = $application;

        return view("mobile.forgot_password_form", $data);
    }

    public function action_sendTokenMail()
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

    public function action_resetPasswordForm()
    {
        //             * Mobil application interface for renewing user password

        $errorMsg = "";
        $rules = array(
            'ApplicationID' => 'required',
            'email'         => 'required|email',
            'code'          => 'required|min:2',
        );

        $v = Validator::make(Input::all(), $rules);
        if ($v->fails())
        {
            $errorMsg = $v->errors->first();
            if (empty($errorMsg))
            {
                $errorMsg = __('common.login_ticketnotfound');
            }
        }

        $applicationID = Input::get("ApplicationID");
        $email = Input::get("email");
        $code = Input::get("code");

        $client = Client::where("ApplicationID", $applicationID)
            ->where("Email", $email)
            ->where("PwRecoveryCode", $code)
            ->where("PwRecoveryDate", ">", DB::raw('ADDDATE(CURDATE(), INTERVAL -7 DAY)'))
            ->first();

        if (!$client)
        {
            $errorMsg = __('common.login_ticketnotfound');
        }

        $data = array();
        $data["errorMsg"] = $errorMsg;

        return view("mobile.reset_password_form", $data);
    }

    /**
     * Saves new user password then redirect to successful token page
     */
    public function action_updatePassword()
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

}
