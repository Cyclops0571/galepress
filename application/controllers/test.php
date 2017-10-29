<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Test_Controller extends Base_Controller
{

    public $restful = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function action_index($test = 1)
    {

        $tmp = array();
        $tmp["paths"][] = "customer_333/application_340";
        $tmp["paths"][] = "customer_333/application_341";
        $tmp["paths"][] = "customer_333/application_342";
        $tmp["paths"][] = "customer_333/application_343";
        $tmp["paths"][] = "customer_333/application_344";
        $tmp["query"] = "Bunu bulll";
        echo json_encode($tmp);
        exit;
        $tmp = getimagesize('818_20161123222637_asus_1.png');
        var_dump($tmp);
        exit;
        $cf = ContentFile::find(7196);
        $cf->createInteractivePdf();
        exit;
        $content = Content::find(1000);
        echo $content->ProcessDate;
        echo strtotime($content->ProcessDate);
        exit;
        $applicationsWhichHaveATopic = ApplicationTopic::group_by("ApplicationID")->get();

        var_dump($applicationsWhichHaveATopic); exit;

//        throw new ServerErrorException('Error validating transaction.', 560);
//        exit;
//        $serverError = new ServerErrorLog();
        /** @var PushNotification $pushNotification */
        $pushNotification = PushNotification::find(1331);
        $app = $pushNotification->Application;
        var_dump($app); exit;
        mobileService::androidInternalNew($pushNotification);
        exit;

        $data['fields']['message'] = "test";
        echo json_encode($data); exit;
        $serviceVersion = 103;
        return webService::render(function() use ($serviceVersion) {
        $topicID = Input::get('topicID', 3);
        $sql = "Select tmp.*, Application.Name as ApplicationName from
                      (select Content.*, ContentTopic.TopicID from Content inner join ContentTopic on Content.ContentID = ContentTopic.ContentID
                        where Content.StatusID = 1 AND
                        Content.PublishDate < curdate() AND
                        ContentTopic.TopicID = ?
                        order by Content.ProcessDate DESC) tmp
                  join Application on Application.ApplicationID = tmp.ApplicationID
                  join ApplicationTopic on ApplicationTopic.ApplicationID = tmp.ApplicationID
                  where
                          Application.ExpirationDate > curdate() AND
                          Application.TopicStatus = ? AND
                          Application.StatusID = ? AND
                          ApplicationTopic.ApplicationTopicID = ?
                      group by tmp.ApplicationID";
        $results = DB::query($sql, array($topicID, eStatus::Active, eStatus::Active, $topicID));
        $response = array();
        foreach($results as $result) {
            $content = new Content();
            Common::Cast($content, $result);
            $response[] = array_merge($content->getServiceDataDetailed($serviceVersion), array('ApplicationName' => $result->ApplicationName));
        }

        return json_encode($response);
    });
        exit;

//        $app = Application::find(58);
        var_dump(empty($app->ApplicationTopics));
        var_dump($app->ApplicationTopics);
        var_dump(empty($app->ApplicationTopics));
        exit;
        $result = "";
//        set_exception_handler(function($exception) { echo "geldim";});
//        set_error_handler(function($error) {throw  new Exception("Error da error");} );
//        throw new Exception("ASdfasdf");
        try {
//            @file_get_contents('http://37.9.205.205/inndexing?path=customer_127/application_135/content_5207/file_6688/file.pdf');
            @$ch = curl_init('http://37.9.205.205/indexing?path=customer_127/application_135/content_5207/file_6688/file.pdf');
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            if (!empty($result)) {
                $resultJson = json_decode($result, true);
                if (isset($resultJson['status'])) {
                    echo $resultJson['status'];
                }
                var_dump($resultJson);
            }
        } catch (\Exception $e) {
            echo "request hata aldi";
        }

}

        var_dump($result);
        exit;

    public function action_index2($test = 1)
    {
	echo 'serdar';
	echo $this->route; exit;	        
//  $apiKey = Config::get('custom.api_key'.$apiIndex);
        $statistic = Statistic::find(7401407);
        $apiKeyDetay = 'AIzaSyB6iLJTSOH0qniPtozvFEkUFiaJfQdMvRg';
        $apiKeyGunes = 'IzaSyCmovRVpwDZaFkDRy-iY_47h6OkT1xgIJg';
        $apiKey = $apiKeyDetay;
        $apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
        $url = sprintf('%s?latlng=%s,%s&sensor=false&key=%s',
            $apiUrl,
            $statistic->Lat,
            $statistic->Long,
            $apiKey
        );

        $content = Content::find(2054);
        var_dump($content->ContentFile);
        exit;
        $app = Application::find(304);
        var_dump($app->ApplicationCategories());
        exit;
        // file page id 34373, 34374, 34375
        $cf = ContentFile::find(2738);
        $cf->createInteractivePdf();
        echo "bitti";
        exit;
    }

    public function m1()
    {
        echo "m1", PHP_EOL;
        $this->m2();
        echo "m1", PHP_EOL;
    }

    public function m2()
    {
        echo "m2", PHP_EOL;
        throw new Exception("exp de exp");
        echo "m2", PHP_EOL;
    }

    public function get_test2()
    {
        var_dump(Input::all());
    }

    public function post_test2()
    {
        $payDataMsg = __('website.payment_result_successful');
        $payDataTitle = __('website.payment_successful');
        $data = array('payDataMsg' => $payDataMsg, 'payDataTitle' => $payDataTitle, 'result' => "asdfasdfadsf");
        return View::make('payment.odeme_sonuc', $data);
//        Redirect::to_route("website_payment_result_get", array(str_replace('%2F', '/', urlencode($basicPayment->))));
    }

    public function addToZip(&$zip, &$basePath, $partial = false)
    {
        $arrComponentActive = array();
        $arrComponentPassive = array();

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath . "/"), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);

            //Ignore "." and ".." folders
            if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
                continue;

            //Check component activity
            if (preg_match("/\/files\/customer_(\d+)\/application_(\d+)\/content_(\d+)\/file_(\d+)\/output\/comp_(\d+)/", $file, $m)) {
                //$customerID = (int)$m[1];
                //$applicationID = (int)$m[2];
                //$contentID = (int)$m[3];
                //$contentFileID = (int)$m[4];
                $checkComponentID = (int)$m[5];
                //echo $customerID.'-'.$applicationID.'-'.$contentID.'-'.$contentFileID.'-'.$checkComponentID;

                if (in_array($checkComponentID, $arrComponentPassive)) {
                    continue;
                }

                if (!in_array($checkComponentID, $arrComponentActive)) {

                    $importCount = 0;

                    if ($partial) {
                        $importCount = DB::table('PageComponentProperty')
                            ->where('PageComponentID', '=', $checkComponentID)
                            ->where('Name', '=', 'import')
                            ->where('Value', '=', 1)
                            ->where('StatusID', '=', eStatus::Active)
                            ->count();
                    }

                    $checkComponentCount = DB::table('PageComponent')
                        ->where('PageComponentID', '=', $checkComponentID)
                        ->where('StatusID', '=', eStatus::Active)
                        ->count();

                    if ($importCount == 1) {
                        array_push($arrComponentActive, $checkComponentID);
                    } elseif (!$partial && $checkComponentCount == 1) {
                        array_push($arrComponentActive, $checkComponentID);
                    } else {
                        array_push($arrComponentPassive, $checkComponentID);
                        continue;
                    }
                }
            }

            $realFile = realpath($file);
            $relativeFile = str_replace($basePath . '/', '', $realFile);

            if (is_dir($realFile) === true) {
                $zip->addEmptyDir($relativeFile . '/');
            } else if (is_file($realFile) === true) {
                $zip->addFile($realFile, $relativeFile);
            }
        }
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
