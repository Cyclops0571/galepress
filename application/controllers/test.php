<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Test_Controller extends Base_Controller
{

    public $restful = true;

    public function __construct()
    {
        parent::__construct();
    }


    public function get_index($test = 1)
    {
        return View::make('test.bannertest');
        var_dump(\Laravel\Auth::User());
        exit;
        if (Request::env() == ENV_LIVE) {
            exit;
        }

        $paymentAccounts = PaymentAccount::where('StatusID', '=', eStatus::Active)->get();
        var_dump($paymentAccounts);
        exit;

        $test = new Application();
//        var_dump($test->asdfasdfasdf); exit;
        var_dump($test);
        $test2 = Application::find(10);
        var_dump($test2);
//        if($test) {
//            echo '1111';
//        }  else {
//            echo '22222';
//        }
        exit;
        echo phpinfo();
        $mailData = array(
            'name' => 'Serdar',
            'surname' => 'Saygili',
            'url' => Config::get("custom.url") . '/' . Config::get('application.language') . '/blog',
        );
        return View::make('mail-templates.hosgeldiniz.index')->with($mailData)->render();

        $gsCommand = array();
        $gsCommand[] = 'gs';
        $gsCommand[] = '-o /vagrant/public/files/customer_60/application_58/content_2007/file_2673/deneme.jpg';
        $gsCommand[] = '-sDEVICE=jpeg';
        $gsCommand[] = '-sPAPERSIZE=a1';
//        $gsCommand[] = '-dDEVICEWIDTHPOINTS=1536 -dDEVICEHEIGHTPOINTS=2048';
        $gsCommand[] = '-dUseCropBox';
        $gsCommand[] = '-dFirstPage=1';
        $gsCommand[] = '-dLastPage=1';
        $gsCommand[] = '-dPDFFitPage=true';

        $gsCommand[] = '-dJPEGQ=100';
        $gsCommand[] = '-r72x72';
        $gsCommand[] = "'/vagrant/public/files/customer_60/application_58/content_2007/file_2673/file.pdf'";

        echo implode(" ", $gsCommand);
        exit;

        shell_exec(implode(" ", $gsCommand));


        echo 1 / 2;
        exit;
        $mycontentIDSet = '3704';
        $contentIDSet = explode(',', $mycontentIDSet);
        array_push($contentIDSet, 1000);
        var_dump($contentIDSet);
        var_dump($returnResult);
        exit;
        $client = Client::find(1);
        var_dump($client->Application);
        echo date("Y-m-d H:i:s", 1456503997000 / 1000);
        exit;
        echo time();
        exit;
        try {
            require_once path('bundle') . '/google/src/Google/autoload.php';
            $client = new Google_Client();

            // set Application Name to the name of the mobile app
            $client->setApplicationName("Uni Saç");

            // get p12 key file
            //echo path('public') . 'keys/GooglePlayAndroidDeveloper-74176ee02cd0.p12'; exit;
            $key = file_get_contents(path('public') . 'keys/GooglePlayAndroidDeveloper-74176ee02cd0.p12');

            // create assertion credentials class and pass in:
            // - service account email address
            // - query scope as an array (which APIs the call will access)
            // - the contents of the key file
            $cred = new Google_Auth_AssertionCredentials(
                '552236962262-compute@developer.gserviceaccount.com',
                'https://www.googleapis.com/auth/androidpublisher',
                $key
            );
            // add the credentials to the client
            $client->setAssertionCredentials($cred);

            // create a new Android Publisher service class
            $service = new Google_Service_AndroidPublisher($client);

            // set the package name and subscription id
            $packageName = "ak.detaysoft.unisac";
            $subscriptionId = "android.test.purchased";
            $purchaseToken = "inapp:ak.detaysoft.unisac:android.test.purchased";
            // use the purchase token to make a call to Google to get the subscription info
            $subscription = $service->purchases_subscriptions->get($packageName, $subscriptionId, $purchaseToken);
            var_dump($subscription);
        } catch (Google_Auth_Exception $e) {
            // if the call to Google fails, throw an exception
            var_dump($e);
            //throw new Exception('Error validating transaction', 500);
        }
    }

    public function create($ContentFileID, $Included)
    {
        try {
            //-----------------------------------------------------------------------------------------------
            $ContentID = (int)ContentFile::find($ContentFileID)->ContentID;
            $ApplicationID = (int)Content::find($ContentID)->ApplicationID;
            $CustomerID = (int)Application::find($ApplicationID)->CustomerID;

            $relativePath = 'files/customer_' . $CustomerID . '/application_' . $ApplicationID . '/content_' . $ContentID . '/file_' . $ContentFileID;
            $path = path('public') . $relativePath;

            //find pdf file
            $pdfFile = '';
            $files = scandir($path);
            foreach ($files as $file) {
                if (is_file($path . '/' . $file) && Common::endsWith($file, '.pdf')) {
                    $pdfFile = $file;
                    break;
                }
            }
            $fileOriginal = $path . "/" . $pdfFile;

            $baseRelativePath = $relativePath . '/output';
            $basePath = path('public') . $baseRelativePath;
            if (!File::exists($basePath)) {
                File::mkdir($basePath);
            }

            $fileOutput = $basePath . "/" . $pdfFile;
            //-----------------------------------------------------------------------------------------------
            $p = new pdflib();
            $p->set_option("license=" . Config::get('custom.pdflib_license'));
            $p->set_option("errorpolicy=return");
            $doc = $p->begin_document($fileOutput, "destination={type=fitwindow} pagelayout=singlepage");
            if ($doc == 0) {
                throw new Exception($p->get_errmsg());
            }

            $p->set_info("Creator", "Galepress");
            $p->set_info("Title", "Galepress Interactive PDF");
            //-----------------------------------------------------------------------------------------------
            //open original document
            $docOriginal = $p->open_pdi_document($fileOriginal, "");
            if ($docOriginal == 0) {
                throw new Exception($p->get_errmsg());
            }

            //get page count
            $pageCount = (int)$p->pcos_get_number($docOriginal, "length:pages");

            for ($page = 0; $page < $pageCount; $page++) {
                //add new page
                $p->begin_page_ext(10, 10, "");

                //open page in original document
                //$pageOriginal = $p->open_pdi_page($docOriginal, ($page + 1), "cloneboxes");
                $pageOriginal = $p->open_pdi_page($docOriginal, ($page + 1), "pdiusebox=crop");
                if ($pageOriginal == 0) {
                    throw new Exception($p->get_errmsg());
                }
                //$p->fit_pdi_page($pageOriginal, 0, 0, "cloneboxes");
                $p->fit_pdi_page($pageOriginal, 0, 0, "adjustpage");

                //close page in original document
                $p->close_pdi_page($pageOriginal);

                $cfp = DB::table('ContentFilePage')
                    ->where('ContentFileID', '=', $ContentFileID)
                    ->where('No', '=', $page + 1)
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();
                if ($cfp) {
                    $width = (float)$cfp->Width;
                    $height = (float)$cfp->Height;

                    $pc = DB::table('PageComponent')
                        ->where('ContentFilePageID', '=', $cfp->ContentFilePageID)
                        ->where('StatusID', '=', eStatus::Active)
                        ->order_by('No', 'ASC')
                        ->get();

                    foreach ($pc as $c) {
                        //get componenet property
                        $trigger_x = 0;
                        $trigger_y = 0;
                        $trigger_w = 60;
                        $trigger_h = 60;
                        $x = 0;
                        $y = 0;
                        $w = 0;
                        $h = 0;
                        $propertyImport = 0;
                        $propertyModal = 0;
                        $propertyType = 0;
                        $propertyUrl = '';
                        $propertyPage = 0;
                        $propertyText = '';
                        $propertyLat = '';
                        $propertyLon = '';
                        $propertyZoom = 0.09;
                        /*
                          $propertyOption = 0;
                          $propertyFilename = '';
                          $propertyVideoinit = '';
                          $propertyHidecontrols = 0;
                          $propertyRestartwhenfinished = 0;
                          $propertyMute = 0;
                          $propertyPosteroption = 0;
                          $propertyPosterimagename = '';
                          $propertyBoxcolor = '';
                          $propertyIconcolor = '';
                          $propertyOpacity = 0;
                          $propertyContent = '';
                         */

                        $data = array(
                            'preview' => false,
                            'baseDirectory' => '',
                            'id' => $c->PageComponentID
                        );

                        $pcp = DB::table('PageComponentProperty')
                            ->where('PageComponentID', '=', $c->PageComponentID)
                            ->where('StatusID', '=', eStatus::Active)
                            ->order_by('PageComponentPropertyID', 'ASC')
                            ->get();
                        foreach ($pcp as $cp) {
                            if ($cp->Name == 'trigger-x') {
                                $trigger_x = (int)$cp->Value;
                            } elseif ($cp->Name == 'trigger-y') {
                                $trigger_y = (int)$cp->Value;
                            } elseif ($cp->Name == 'x') {
                                $x = (int)$cp->Value;
                            } elseif ($cp->Name == 'y') {
                                $y = (int)$cp->Value;
                            } elseif ($cp->Name == 'w') {
                                $w = (int)$cp->Value;
                            } elseif ($cp->Name == 'h') {
                                $h = (int)$cp->Value;
                            } elseif ($cp->Name == 'import') {
                                $propertyImport = (int)$cp->Value;
                            } elseif ($cp->Name == 'modal') {
                                $propertyModal = (int)$cp->Value;
                            } elseif ($cp->Name == 'type') {
                                $propertyType = (int)$cp->Value;
                            } elseif ($cp->Name == 'url') {
                                $propertyUrl = $cp->Value;
                            } elseif ($cp->Name == 'page') {
                                $propertyPage = (int)$cp->Value;
                            } elseif ($cp->Name == 'text') {
                                $propertyText = $cp->Value;
                            } elseif ($cp->Name == 'lat') {
                                $propertyLat = $cp->Value;
                            } elseif ($cp->Name == 'lon') {
                                $propertyLon = $cp->Value;
                            } elseif ($cp->Name == 'zoom') {
                                $propertyZoom = (float)$cp->Value;
                            }


                            /*
                              elseif($cp->Name == 'videoinit') $propertyVideoinit = $cp->Value;
                              elseif($cp->Name == 'hidecontrols') $propertyHidecontrols = (int)$cp->Value;
                              elseif($cp->Name == 'restartwhenfinished') $propertyRestartwhenfinished = (int)$cp->Value;
                              elseif($cp->Name == 'mute') $propertyMute = (int)$cp->Value;
                              elseif($cp->Name == 'posteroption') $propertyPosteroption = (int)$cp->Value;
                              elseif($cp->Name == 'posterimagename') $propertyPosterimagename = $cp->Value;
                              elseif($cp->Name == 'boxcolor') $propertyBoxcolor = $cp->Value;
                              elseif($cp->Name == 'iconcolor') $propertyIconcolor = $cp->Value;
                              elseif($cp->Name == 'opacity') $propertyOpacity = (int)$cp->Value;
                              elseif($cp->Name == 'content') $propertyContent = $cp->Value;
                             */

                            /*
                              else
                              {
                              $param .= (Str::length($param) > 0 ? '&' : '?').$cp->Name.'='.$cp->Value;
                              }
                             */
                            $data = array_merge($data, array($cp->Name => $cp->Value));
                        }

                        if ($propertyModal == 1) {
                            $trigger_w = 52;
                            $trigger_h = 52;
                        }

                        //reverse y
                        $y = $height - $y - $h;
                        $trigger_y = $height - $trigger_y;
                        //$trigger_y = $height - $trigger_y - $trigger_h;

                        $component = PageComponent::find($c->PageComponentID)->Component();
                        $componentID = $component->ComponentID;
                        $componentClass = $component->Class;

                        $qs = '';
                        $paramQS = array();

                        array_push($paramQS, 'componentTypeID=' . $componentID);

                        if ($propertyModal == 1) {
                            array_push($paramQS, 'modal=1');
                        }
                        if (count($paramQS) > 0) {
                            $qs = '?' . implode("&", $paramQS);
                        }

                        if ($propertyModal == 1) {
                            //$p->set_parameter("SearchPath", path('public')."files/components/".$componentClass);
                            //$triggerImage = $p->load_image("auto", "icon.png", "");
                            $image_url = path('public') . $data["modaliconname"];
                            if (File::exists($image_url) && is_file($image_url)) {
                                $image_url = Config::get("custom.url") . "/" . $data["modaliconname"];
                            } else {
                                $image_url = Config::get("custom.url") . "/files/components/" . $componentClass . "/icon.png";
                            }
                            $imageData = file_get_contents($image_url);
                            if ($imageData == false) {
                                throw new Exception("Error: file_get_contents($image_url) failed");
                            }
                            $p->create_pvf("/pvf/image", $imageData, "");
                            $triggerImage = $p->load_image("auto", "/pvf/image", "");
                            if ($triggerImage == 0) {
                                throw new Exception($p->get_errmsg());
                            }
                            //$optlist = "boxsize={30 30} position={center} fitmethod=meet matchbox={borderwidth=10 offsetleft=-5 offsetright=5 offsetbottom=-5 offsettop=5 linecap=round linejoin=round strokecolor {rgb 0.0 0.3 0.3}}";
                            //$optlist = "boxsize={52 52} position={center} fitmethod=meet";
                            //$p->fit_image($triggerImage, $trigger_x, $trigger_y, $optlist);
                            $optlist = "boxsize={" . $w . " " . $h . "} position={center} fitmethod=meet";
                            $p->fit_image($triggerImage, $x, $y, $optlist);
                            $p->close_image($triggerImage);
                            $p->delete_pvf("/pvf/image");

                            //$x = $trigger_x;
                            //$y = $trigger_y;
                            //$w = 52;
                            //$h = 52;
                        }

                        if ($componentClass == 'video' || $componentClass == 'audio' || $componentClass == 'animation' || $componentClass == 'tooltip' || $componentClass == 'scroll' || $componentClass == 'slideshow' || $componentClass == 'gal360') {


                            //ylvideo://xxx.com/video.mp4?autostart=X?modal=0
                            //ylvideo://localhost/video=001.mp4?autostart=X?modal=0
                            //create component directory
                            $outputPath = $path . '/output';
                            $componentPath = $outputPath . '/comp_' . $c->PageComponentID;

                            if (!File::exists($componentPath)) {
                                File::mkdir($componentPath);
                            }

                            //extract zip file
                            $zipFile = path('public') . 'files/components/' . $componentClass . '/files.zip';

                            $zip = new ZipArchive();
                            $res = $zip->open($zipFile);
                            if ($res === true) {
                                $zip->extractTo($componentPath);
                                $zip->close();
                            }

                            //copy file
                            if ($componentClass == 'slideshow' || $componentClass == 'gal360') {
                                $files = DB::table('PageComponentProperty')
                                    ->where('PageComponentID', '=', $c->PageComponentID)
                                    ->where('Name', '=', 'filename')
                                    ->where('StatusID', '=', eStatus::Active)
                                    ->order_by('PageComponentPropertyID', 'ASC')
                                    ->get();
                                $arr = array();
                                foreach ($files as $file) {
                                    array_push($arr, $file->Value);
                                }
                                $data = array_merge($data, array('files' => $arr));
                                //$data = array_merge($data, array('files' => $files));
                            }

                            if ($componentClass == 'audio') {
                                $x = $trigger_x;
                                $y = $trigger_y - $trigger_h;
                                $w = $trigger_w;
                                $h = $trigger_h;
                            }

                            //video url youtube embed
                            if ($componentClass == 'video' && !(strpos($propertyUrl, 'www.youtube.com/embed') === false)) {

                                if (strpos($propertyUrl, '?') !== false) {
                                    $qs = str_replace('?', '&', $qs);
                                }
                                $propertyUrl = str_replace("http", "ylweb", $propertyUrl . $qs);
                                $action = $p->create_action("URI", "url {" . $propertyUrl . "}");
                                $p->create_annotation($x, $y, $x + $w, $y + $h, "Link", "linewidth=0 action {activate $action}");
                            } else {

                                $content = View::make('interactivity.components.' . $componentClass . '.dynamic', $data)->render();
                                File::put($outputPath . '/comp_' . $c->PageComponentID . '.html', $content);
                                //File::put($componentPath.'/'.$bladeTemplate[$componentClass], $content);

                                $url = 'ylweb://www.galepress.com/files/customer_' . $CustomerID . '/application_' . $ApplicationID . '/content_' . $ContentID . '/file_' . $ContentFileID . '/output/comp_' . $c->PageComponentID . '.html' . $qs;

                                if ($Included == 1 || $propertyImport == 1) {
                                    $url = 'ylweb://localhost/comp_' . $c->PageComponentID . '.html' . $qs;
                                }

                                $action = $p->create_action("URI", "url {" . $url . "}");
                                $p->create_annotation($x, $y, $x + $w, $y + $h, "Link", "linewidth=0 action {activate $action}");
                            }
                            //video || audio || tooltip || scroll || slideshow || gal360
                        } elseif ($componentClass == 'map') {
                            //$propertyType
                            //$propertyLat
                            //$propertyLon
                            //$propertyZoom
                            $mapType = 'standard';

                            if ($propertyType == 2) {
                                $mapType = 'hybrid';
                            } else if ($propertyType == 3) {
                                $mapType = 'satellite';
                            }
                            //$propertyUrl = str_replace("http", "ylweb", $propertyUrl);
                            $zoom = ((100 - ($propertyZoom * 1000)) / 1000);
                            $propertyUrl = 'ylmap://' . $mapType . $qs . '&lat=' . $propertyLat . '&lon=' . $propertyLon . '&slat=' . $zoom . '&slon=' . $zoom;
                            $action = $p->create_action("URI", "url {" . $propertyUrl . "}");
                            $p->create_annotation($x, $y, $x + $w, $y + $h, "Link", "linewidth=0 action {activate $action}");
                            //map
                        } elseif ($componentClass == 'link') {
                            //$propertyType
                            //$propertyPage
                            //$propertyUrl
                            if ($propertyType == 1) {
                                //goto page
                                $optlist = "destination={page=" . $propertyPage . " type=fixed left=10 top=10 zoom=1}";
                                $action = $p->create_action("GOTO", $optlist);
                                $p->create_annotation($x, $y, $x + $w, $y + $h, "Link", "linewidth=0 action {activate $action}");
                            } elseif ($propertyType == 2) {
                                //goto link
                                if (strpos($propertyUrl, '?') !== false) {
                                    $qs = str_replace('?', '&', $qs);
                                }
                                $action = $p->create_action("URI", "url {" . $propertyUrl . $qs . "}");
                                $p->create_annotation($x, $y, $x + $w, $y + $h, "Link", "linewidth=0 action {activate $action}");
                            }
                            //link
                        } elseif ($componentClass == 'webcontent') {
                            if (strpos($propertyUrl, '?') !== false) {
                                $qs = str_replace('?', '&', $qs);
                            }
                            $propertyUrl = str_replace("http", "ylweb", $propertyUrl . $qs);
                            $action = $p->create_action("URI", "url {" . $propertyUrl . "}");
                            $p->create_annotation($x, $y, $x + $w, $y + $h, "Link", "linewidth=0 action {activate $action}");
                            //webcontent
                        } elseif ($componentClass == 'bookmark') {
                            //$propertyText
                            $propertyText = pack('H*', 'feff') . mb_convert_encoding($propertyText, 'UTF-16', 'UTF-8');
                            $p->create_bookmark($propertyText, "destination={page=" . ($page + 1) . " type=fixed left=" . $trigger_x . " top=" . $trigger_y . " zoom=1}");
                            //bookmark
                        }
                    }
                }

                //end new page
                $p->end_page_ext("");
            }
            //close document
            $p->close_pdi_document($docOriginal);
            //-----------------------------------------------------------------------------------------------
            $p->end_document("");
            //-----------------------------------------------------------------------------------------------
            //create zip archive
            if (File::exists($basePath . '/file.zip')) {
                File::delete($basePath . '/file.zip');
            }

            //Create zip archive
            $zip = new ZipArchive();
            $res = $zip->open($basePath . '/file.zip', ZIPARCHIVE::CREATE);
            if ($res === true) {
                $this->addToZip($zip, $basePath, $Included !== 1);
                $zip->close();
            }
            //-----------------------------------------------------------------------------------------------
            $a = Application::find($ApplicationID);
            $a->Version = (int)$a->Version + 1;
            $a->save();

            $s = Content::find($ContentID);
            $s->Version = (int)$s->Version + 1;
            $s->PdfVersion = (int)$s->PdfVersion + 1;
            $s->save();

            $cf = ContentFile::find($ContentFileID);
            $cf->HasCreated = 1;
            //$cf->ErrorCount = 0;
            //$cf->LastErrorDetail = '';
            $cf->InteractiveFilePath = $baseRelativePath;
            $cf->InteractiveFileName = 'file.zip';
            $cf->InteractiveFileSize = File::size($basePath . '/file.zip');
            $cf->save();
            //-----------------------------------------------------------------------------------------------
        } catch (PDFlibException $e) {
            $err = 'PDFlib exception occurred in starter_block sample: [' . $e->get_errnum() . '] ' . $e->get_apiname() . ': ' . $e->get_errmsg();
            $cf = ContentFile::find($ContentFileID);
            $cf->ErrorCount = (int)$cf->ErrorCount + 1;
            $cf->LastErrorDetail = $err;
            $cf->save();
            throw new Exception($err);
        } catch (Exception $e) {
            $err = $e->getMessage();
            $cf = ContentFile::find($ContentFileID);
            $cf->ErrorCount = (int)$cf->ErrorCount + 1;
            $cf->LastErrorDetail = $err;
            $cf->save();
            throw new Exception($err);
        }
        $p = 0;
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
