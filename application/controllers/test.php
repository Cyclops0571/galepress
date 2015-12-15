<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Detay
 */
class dd1
{
    const ASdf = 5;

    public static function make()
    {
        return new static(5);
    }

    public static function who()
    {
        echo __CLASS__;
    }

    public static function test()
    {
        static::who();
    }
}

class dd2 extends dd1
{
    public static function who()
    {
        echo __CLASS__;
    }
}

class dd3 extends dd2
{
    public function __construct($a)
    {
        var_dump("a:::" . $a);
    }
}

class Test_Controller extends Base_Controller
{

    public $restful = true;

    public function __construct()
    {
        parent::__construct();
    }


    public function get_index($test = 1)
    {
//        LaravelLang::writeToDB();
        LaravelLang::Export();
        echo date('Y-m-d H:i:s');
        exit;

        echo __('common.month_names');
        $langFiles = array(
            'clients',
            'common',
            'content',
            'error',
            'interactivity',
            'javascriptlang',
            'notification',
            'pagination',
            'route',
            'validation',
            'website',
        );

        $langs = array(
            'en', 'tr', 'de', 'usa'
        );

        foreach($langFiles as $langFile) {
            foreach($langs as $lang) {
                Laravel\Lang::load('application', $lang, $langFile);
            }
        }
        var_dump(Laravel\Lang::$lines);
        exit;
        echo phpinfo();
        return;
        dd(dd3::make());
        exit;
        //dd(basename("/csaa/1.css", '.css'));
        echo uniqid();
        exit;
        return View::make('test.javascripttest', array());
        //	setlocale(LC_TIME, $locale);
        //	echo Auth::User()->UserID;
        echo Auth::User()->Session()->LocalLoginDate, PHP_EOL;
        echo Common::dateRead(Auth::User()->Session()->LocalLoginDate, "dd.MM.yyyy HH:mm");
        echo Common::dateRead(Auth::User()->Session()->LocalLoginDate, 'dd.MM.yyyy'), PHP_EOL;
        echo date('d.m.Y');
        exit;
        echo date("Y-m-d", strtotime("-1 month +1 day"));
        exit;
        echo date("Y-m-d", strtotime("2015-07-20 + 3 month"));
        exit;
        $response = '{"response":{"state":"success","date_time":"15-10-23 08:48:30","request_id":"MTQ0NTU5MDEwOAHNVpS9Bj4ZTuwWGfck"},"mode":"live","card_token":"MTQ0NTU5MDA1MQDGDoQDPKTLV8pc091f","transaction":{"transaction_id":"MTQ0NTU5MDA1MAnIHvDNfQhrNTz06Oii","external_id":"1233","reference_id":"1233","state":"paid","amount":"118.00","currency":"TRY","connector_type":"Garanti","installment_count":0,"connector_auth_code":"777570"},"customer":{"first_name":"Faz\u0131l","last_name":"S\u00f6zer","email":"fazil@remax-yildiz.com"},"account":{"bin":"524347","brand":"MASTERCARD","expiry_month":"09","expiry_year":"2017","lastfourdigits":"3736","holder":"arif fazil sozer","card_family":"Axess","card_type":"CREDIT_CARD","card_association":"MASTER_CARD","issuer_bank_code":"46","issuer_bank_name":"Akbank"}}';
        $result = json_decode($response, TRUE);
//	dd($result); exit;
        if (isset($result['transaction']['state']) && strstr($result['transaction']['state'], "paid")) {
            echo "asdfadsf";
        } else {
            echo "bbbbb";
        }
        exit;
        echo time(), PHP_EOL;
        sleep(1);
        echo time();
        exit;
        $subject = 'deneme maili';
        $msg = "deneme mailidir";
        Bundle::start('messages');
        Message::send(function ($m) use ($subject, $msg) {
            /* @var $m \Swiftmailer\Drivers\Driver */
            $m->from('serdar.saygili@detaysoft.com', 'Galepress System Admin');
//	    $m->to('srdsaygili@gmail.com', 'guler.nesil@detaysoft.com', 'serdar.saygili@detaysoft.com');
            $m->to(array('srdsaygili@gmail.com', 'guler.nesil@detaysoft.com', 'serdar.saygili@detaysoft.com'));
            $m->html("true");
            $m->subject('deneme mailidir');
            $m->body("Bu mail size geldi mi ?");
        });


        dd(Laravel\URL::to_route("clientsregistered"));
        dd(preg_match('/^https?:\/\/.+$/', "asdfasf"));
        $app = Application::find(58);
        $app->SubscriptionIdentifier(2);
        exit;
        dd(dd3::who());
        $tmp = array(1, 2, 3);
        echo implode(",", $tmp);
        exit;
        $tmp2 = array(5, 2, 3, 4);
        $mrg = array_merge($tmp, $tmp2);
        $umrg = array_unique($mrg);
        sort($umrg);
        dd($umrg);
        $paymentAccount = PaymentAccount::find(1);
//	dd($paymentAccount->Application()->Price * 118);
        Laravel\Config::set("application.language", "tr");
        Laravel\Session::put("language", "tr");
        echo Laravel\Session::get("language");
        echo __('common.support');
        return;

        dd(Laravel\URL::to_route("clientsregistered"));
        echo strtotime("2015-09-07 17:15:00") . "   ----------------   ";
        echo time();
        exit;
        $res = openssl_pkey_new();
        openssl_pkey_export($res, $privateKey);
        $pubkey = openssl_pkey_get_details($res);

        var_dump($privateKey);
        echo PHP_EOL . "---------------------------------" . PHP_EOL;
        var_dump($pubkey);


//	echo date(strtotime('2015-01-01')) . " ---- " . strtotime('2015-01-01');
        echo date("Y-m-d", strtotime("2015-08-26" . " +1 month"));
        exit;
        $pa = PaymentAccount::find(1);
        var_dump($pa);
        var_dump($pa->Application());
        exit;
        $a1 = array(1, 2, 3, 4, 5);
        $a2 = array(6, 7, 8);
        $a1[] = $a2;

        echo date("Y-m-d", strtotime("+1 month", date(strtotime("2015-04-01"))));
        exit;
//	$binarydata = pack("nvc*", 0x1234, 0x5678, 65, 66);
//	dd($binarydata);
//	var_dump(chr(0));
//	dd(pack('H*', 'aaaaaaaaa'));
        $token = 'APA91bEmfN-i8YRaILLgUJvneezm1GQti9eDmRtyqUSZCxqpbqXf-3anKW6tviVFt2stgQfD3LoIxgG8PRbZsfSJUDBCf4-DFh8Ct_TlcT0pdEKZd9KK_UrmudKCmGBGos-GetP84KDAvzyEJwMqGUYjcCFj5900QA';
        $token = 'APA91bEmfN-i8YRaILLgUJvneezm1GQti9eDmRtyqUSZCxqpbqXf-3anKW6tviVFt2stgQfD3LoIxgG8PRbZsfSJUDBCf4-DFh8Ct_TlcT0pdEKZd9KK_UrmudKCmGBGos-GetP84KDAvzyEJwMqGUYjcCFj5900QA';
        echo pack('H*', str_replace(' ', '', sprintf('%u', CRC32($token))));
//	echo pack('H*', $token);
        exit;

        include(path('public') . "ticket/bootstrap.php");
        $data = array(
            'api_version' => '1',
            'api_action' => 'authenticate',
            'api_key' => '19664485-923e-46eb-8220-338300870052',
            'username' => 'admin',
            'password' => 'detay2006'
        );
        $result = $api->receive(array("data" => json_encode($data)));
        return \Laravel\Redirect::to(Laravel\Config::get('custom.url') . '/ticket');

        echo $result;
        exit;


        $add_array = array(
            'name' => 'Test User',
            'email' => 'user@example.com',
            'authentication_id' => 1,
            'allow_login' => 1,
            'username' => 'test',
            'password' => '1234',
            'user_level' => 1,
        );
        $id = $users->add($add_array);
        var_dump($session);

        if ($user['password'] === $this->hash_password($password, $user['salt'])) {

            $user['regenerate_id'] = true;
            $this->login_session($user);

            $log_array['event_severity'] = 'notice';
            $log_array['event_number'] = E_USER_NOTICE;
            $log_array['event_description'] = 'Local Login Successful "<a href="' . $config->get('address') . '/users/view/' . (int)$user['id'] . '/">' . safe_output($user['name']) . '</a>"';
            $log_array['event_file'] = __FILE__;
            $log_array['event_file_line'] = __LINE__;
            $log_array['event_type'] = 'local_login_successful';
            $log_array['event_source'] = 'auth';
            $log_array['event_version'] = '1';
            $log_array['log_backtrace'] = false;

            $log->add($log_array);

            $this->clear_failed_login($user);

            return true;
        }


        exit;
        //
        echo 'New user added. ID: ' . (int)$id;
        exit;


        $ticketApi = new sts\api();
        $ticketApi->receive("test");
        var_dump($ticketApi);
        exit;
        var_dump(Auth::User());


//            return phpinfo();

        return View::make('test.javascripttest', array());
    }

    public function post_index()
    {
        echo "aaa";
        var_dump($_POST);
        dd($_FILES);
    }

    public function get_download()
    {
        return Laravel\View::make('test.download');
    }

    public function post_download()
    {
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

        $json = get_object_vars(json_decode($ob));
        $arr = $json[$element];
        $obj = $arr[0];
        return Response::json($obj);
    }

    public function get_moveInteractivite()
    {

        /*	Target content's pages must be created and the interactive designer must be opened */
        // Enter the file id of the content which will be moved
        $contentFilePage = DB::table('ContentFilePage')
            ->where('ContentFileID', '=', "15")//*************
            ->get();

        foreach ($contentFilePage as $cfp) {

            $filePageComponent = DB::table('PageComponent')
                ->where('ContentFilePageID', '=', $cfp->ContentFilePageID)
                ->get();

            if (sizeof($filePageComponent) == 0) {
                continue;
            }

            //HANGI CONTENT'E TASINACAK
            $contentFilePageNew = DB::table('ContentFilePage')
                ->where('ContentFileID', '=', "15")//****************
                ->where('No', '=', $cfp->No)
                ->first();
            if (isset($contentFilePageNew)) {

                foreach ($filePageComponent as $fpc) {
                    $s = new PageComponent();
                    $s->ContentFilePageID = $contentFilePageNew->ContentFilePageID;
                    $s->ComponentID = $fpc->ComponentID;
                    $s->No = $fpc->No;
                    $s->StatusID = eStatus::Active;
                    $s->DateCreated = new DateTime();
                    $s->ProcessDate = new DateTime();
                    $s->ProcessTypeID = eProcessTypes::Insert;
                    $s->save();

                    $filePageComponentProperty = DB::table('PageComponentProperty')
                        ->where('PageComponentID', '=', $fpc->PageComponentID)
                        ->where('StatusID', '=', eStatus::Active)
                        ->get();

                    foreach ($filePageComponentProperty as $fpcp) {
                        $p = new PageComponentProperty();
                        $p->PageComponentID = $s->PageComponentID;
                        $p->Name = $fpcp->Name;
                        $p->Value = $fpcp->Value;
                        $p->StatusID = eStatus::Active;
                        $p->DateCreated = new DateTime();
                        $p->ProcessDate = new DateTime();
                        $p->ProcessTypeID = eProcessTypes::Insert;
                        $p->save();
                    }
                }
            }
        }

        // Don't forget to make passive after the operation done else it will write on it
    }

    /**
     * @return \Laravel\View
     */
    public function get_image()
    {
        $cropSet = Crop::get();
        foreach ($cropSet as $crop) {
            /** @var Crop $crop */
            echo $crop->CropID;
        }
//		$applicationID = (int) Input::get('applicationID', 20);
//		$app = Application::find($applicationID);
        $contentID = (int)Input::get("contentID", 0);
        $contentID = 1893;
        /** @var ContentFile $contentFile */
        $contentFile = DB::table('ContentFile')
            ->where('ContentID', '=', $contentID)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('ContentFileID', 'DESC')->first();
        /** @var ContentCoverImageFile $ccif */
        /** @var ContentCoverImageFile Description * */
        $ccif = DB::table('ContentCoverImageFile')
            ->where('ContentFileID', '=', $contentFile->ContentFileID)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('ContentCoverImageFileID', 'DESC')->first();
        //Find the content image
        //calculate the absolute path of the source image
        $imagePath = $contentFile->FilePath . "/" . $ccif->SourceFileName;
        $imageInfo = new imageInfoEx($imagePath);
        $data = array();
        $data['cropSet'] = $cropSet;
        $data['imageInfo'] = $imageInfo;
        return View::make('test.image', $data);
    }

    public function post_image()
    {

        $xCoordinateSet = Input::get("xCoordinateSet");
        $yCoordinateSet = Input::get("yCoordinateSet");
        $heightSet = Input::get("heightSet");
        $widthSet = Input::get("widthSet");
        $cropIDSet = Input::get("cropIDSet");
        $contentID = (int)Input::get("contentID", 0);
        $contentID = 1893;
        /** @var ContentFile $contentFile */
        $contentFile = DB::table('ContentFile')
            ->where('ContentID', '=', $contentID)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('ContentFileID', 'DESC')->first();
        /** @var ContentCoverImageFile $ccif */
        $ccif = DB::table('ContentCoverImageFile')
            ->where('ContentFileID', '=', $contentFile->ContentFileID)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('ContentCoverImageFileID', 'DESC')->first();
        //bu contentin imageini bulalim....
        //calculate the absolute path of the source image
        $sourceImagePath = $contentFile->FilePath . "/" . $ccif->SourceFileName;
        $imageInfo = new imageInfoEx($sourceImagePath);


        for ($i = 0; $i < count($xCoordinateSet); $i++) {
            /** @var Crop $crop */
            $crop = Crop::find($cropIDSet[$i]);
            if (!$crop) {
                continue;
            }
            $im = new Imagick($imageInfo->absolutePath);
            $im->cropimage($widthSet[$i], $heightSet[$i], $xCoordinateSet[$i], $yCoordinateSet[$i]);
            $im->resizeImage($crop->Width, $crop->Height, Imagick::FILTER_LANCZOS, 1, TRUE);
            $im->writeImage(path('public') . $contentFile->FilePath . "/" . IMAGE_CROPPED_NAME . "_" . $crop->Width . "x" . $crop->Height . ".jpg");
            $im->destroy();
        }
    }

    public function get_myhome()
    {
        return View::make('website.pages.home');
    }

    public function get_routetest($x)
    {
        echo $x . "aaaaaaaaaaaaaa";
    }

    public function get_iosInternalTest()
    {
        $appID = 424;
        $udid1 = 'E6A7CFD9-FE39-4C33-B7F4-6651404ED040';
        $deviceToken1 = '22d08c4579f9a0d0e07fe7fdcd0a064989ecb93b06f7a1cf7c3a5f130b36c776';

        $app = Application::find($appID); //mmd
        $cert = path('public') . 'files/customer_' . $app->CustomerID . '/application_' . $app->ApplicationID . '/' . $app->CkPem;
        $message = "Your Device Token: " . $deviceToken1;
        $deviceToken = $deviceToken1;


        $success = false;
        // Put your private key's passphrase here:
        $passphrase = Config::get('custom.passphrase');


        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if ($fp) {
            // Create the payload body
            $body['aps'] = array(
                'alert' => $message,
                'sound' => 'default'
            );

            // Encode the payload as JSON
            $payload = json_encode($body);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));


            if ($result) {
                $success = true;
            }
            // Close the connection to the server
            phpinfo();
            fclose($fp);
        } else {
            echo $errstr;
            exit;
            //throw new Exception("Failed to connect: $err $errstr" . PHP_EOL);
        }
        var_dump($success);
    }

    /**
     * @return Application
     */
    public function get_adaf()
    {
        $as = array("asdf" => "asdfasdg");
        foreach ($as as $a) {
            echo $a;
        }
        return new Application();
    }

}
