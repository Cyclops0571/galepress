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
        //arda commit test
        //serdar commit test
        $tmp = array(1, 2);
        echo json_encode($tmp);
        exit;

        $path = path('public') . 'files\customer_60\application_58\content_2050\file_2732\file_1.jpg';
        echo pathinfo($path, PATHINFO_FILENAME);
        exit;
        echo 'arda223344'; exit;
        $client = Client::find(488);
        $clientReceipt = ClientReceipt::find(99);
        $client->checkReceiptGoogleTest($clientReceipt);
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

            $p->set_info("Creator", "Gale Press");
            $p->set_info("Title", "Gale Press Interactive PDF");
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

    public function get_interactive()
    {
        File::exists(path('public/geo.php'));

        $pdf = "/vagrant/public/files/test/annotation_top-left.pdf";
        $pdf = "/vagrant/public/files/test/annotation_top-left2.pdf";
//        $pdf = "/vagrant/public/files/test/annotation_bottom-right.pdf";
//        $pdf = "/vagrant/public/files/test/bookmarkHata.pdf";
        $myPcos = new MyPcos($pdf);
        $myPcos->checkPageSnapshots();
        exit;
        $pageCount = $myPcos->pageCount();
        echo "-------------ANNOTATIONS---------------", PHP_EOL;
        echo $myPcos->height(0), PHP_EOL;
        echo $myPcos->width(0), PHP_EOL;
        for ($i = 0; $i < $pageCount; $i++) {
            var_dump($myPcos->getAnnotations($i));
        }

        echo "-------------BOOKMARKS---------------", PHP_EOL;
        var_dump($myPcos->getBookmarks());
        exit;

        $pdfLib = new PDFlib();
        $pdfLib->set_option("license=" . Config::get('custom.pdflib_license'));
        $pdfLib->set_option("errorpolicy=return");
        $doc = $pdfLib->open_pdi_document('/vagrant/public/files/test/bookmarkHata.pdf', "");
        //1.7ext3
        echo 'Encryption: ' . $pdfLib->pcos_get_string($doc, "encrypt/description"), PHP_EOL;
        $pcosmode = $pdfLib->pcos_get_number($doc, "pcosmode");
        if ($pcosmode == 0) {
            throw new Exception("Encripted document");
        }

        $plainMetaData = (int)$pdfLib->pcos_get_number($doc, "encrypt/plainmetadata");
        $encryptNoCopy = (int)$pdfLib->pcos_get_number($doc, "encrypt/nocopy");

        if ($pcosmode == 1 && !$plainMetaData && $encryptNoCopy != 0) {
            throw new Exception("Resctricted Access");
        }

        $pdfversion = $pdfLib->pcos_get_number($doc, "fullpdfversion");

        echo 'pdfversion: ' . $pdfversion, PHP_EOL;
        echo 'pcosmode: ' . $pcosmode;
        echo 'PDF/A status: ' . $pdfLib->pcos_get_string($doc, "pdfa"), PHP_EOL;
        $pageCount = $pdfLib->pcos_get_string($doc, "type:length:pages");
        echo "length Type";
        var_dump($pageCount);
        exit;
//        for($i = 0; $i < $pageCount; $i++) {
//            $height = $pdfLib->pcos_get_number($doc, "pages[" . $i . "]/height");
//            $width = $pdfLib->pcos_get_number($doc, "pages[" . $i . "]/width");
//            echo "height: " . $height . " width: " . $width, PHP_EOL;
//        }
//
//        $fontCount = $pdfLib->pcos_get_number($doc, "length:fonts");
//        for($i = 0; $i < $fontCount; $i++){
//            $fontName = $pdfLib->pcos_get_string($doc, "fonts[" . $i . "]/name");
//            $embedded = $pdfLib->pcos_get_number($doc, "fonts[" . $i . "]/embedded");
//            echo "fontName: " . $fontName . " embedded: " . $embedded, PHP_EOL;
//            $vertical = $pdfLib->pcos_get_string($doc, "fonts[" . $i . "]/vertical");
//            $ascender = $pdfLib->pcos_get_number($doc, "fonts[" . $i . "]/ascender");
//            $descender = $pdfLib->pcos_get_number($doc, "fonts[" . $i . "]/descender");
//            echo "vertical: " . $vertical . " ascender: " . $ascender . " descender: " . $descender, PHP_EOL;
//        }
//
//
//        $imageCount = $fontCount = $pdfLib->pcos_get_number($doc, "length:images");
//        for($i = 0; $i < $imageCount; $i++){
//            $height = $pdfLib->pcos_get_number($doc, "images[" . $i . "]/Height");
//            $width = $pdfLib->pcos_get_number($doc, "images[" . $i . "]/Width");
//            $bpc = $pdfLib->pcos_get_number($doc, "images[" . $i . "]/bpc");
//            echo "height: " . $height . " width: " . $width . ' bpc: ' . $bpc, PHP_EOL;
//        }
//
//        exit;
        //571571
        $bookmarkCount = (int)$pdfLib->pcos_get_number($doc, "length:bookmarks");
        for ($bookmarkIndex = 0; $bookmarkIndex < $bookmarkCount; $bookmarkIndex++) {
            $bookmarkDestpage = (int)$pdfLib->pcos_get_number($doc, "bookmarks[" . $bookmarkIndex . "]/destpage");
            $bookmarkTitle = $pdfLib->pcos_get_string($doc, "bookmarks[" . $bookmarkIndex . "]/Title");
            echo '$bookmarkDestpage' . $bookmarkDestpage, PHP_EOL;
            echo '$bookmarkTitle' . $bookmarkTitle, PHP_EOL;
        }

        //echo $bookmarkCount;
        for ($pageNo = 0; $pageNo < $pageCount; $pageNo++) {
            $annotations_path = "pages[" . $pageNo . "]/annots";
            $anncount = (int)$pdfLib->pcos_get_number($doc, "length:" . $annotations_path);
            echo '$anncount' . $anncount, PHP_EOL;
            $enterToAnnot = true;
//            $bookmarkss_path = "pages[" . $pageNo . "]/bookmarks";
//            $bookmarks = (int)$pdfLib->pcos_get_number($doc, "length:" . $bookmarkss_path);
//            echo 'bookmarks' . $bookmarks, PHP_EOL;
            if ($enterToAnnot && $anncount > 0) {
                $indesignFind = null;
                if ($pdfLib->pcos_get_string($doc, "type:/Root/Metadata") == "stream") {
                    $docInfo = $pdfLib->pcos_get_stream($doc, "", "/Root/Metadata");
                    preg_match("/indesign/i", $docInfo, $indesignFind);
                }

                //$posStart = strpos($docInfo, '<xmp:CreatorTool>');
                //$posEnd = strpos($docInfo, '</xmp:CreatorTool>');
                //$docInfoFind = substr($docInfo, $posStart, $posEnd);
                //$indesignFind = strpos($docInfo,"InDesign");

                $counter = min(array($anncount, 30)); //30dan fazla interactif öğe sayfada olmasın.
                for ($ann = 0; $ann < $counter; $ann++) {
                    $annotation_path = $annotations_path . "[" . $ann . "]";
                    $linkDest = null;
                    $pcosmode = null;
                    $subtype = null;
                    $uri = null;
                    $pageHeight = null;
                    $lowleftX = null;
                    $lowleftY = null;
                    $uprightX = null;
                    $uprightY = null;

                    $propertySet = array();
                    $propertySet[$annotation_path . "/destpage"] = &$linkDest;
                    $propertySet["pcosmode"] = &$pcosmode;
                    $propertySet[$annotation_path . "/Subtype"] = &$subtype;
                    $propertySet[$annotation_path . "/A/URI"] = &$uri;
                    $propertySet["pages[" . $pageNo . "]/height"] = &$pageHeight;
                    //Burada rectX ve rectY ile alakali bir sorun var...
                    $propertySet[$annotation_path . "/Rect[0]"] = &$lowleftX;
                    $propertySet[$annotation_path . "/Rect[1]"] = &$lowleftY;
                    $propertySet[$annotation_path . "/Rect[2]"] = &$uprightX;
                    $propertySet[$annotation_path . "/Rect[3]"] = &$uprightY;
                    foreach ($propertySet as $key => $value) {
                        $propertyType = $pdfLib->pcos_get_string($doc, "type:" . $key);
                        echo $key . ":", PHP_EOL;
                        echo "Type:";
                        var_dump($propertyType);

                        switch ($propertyType) {
                            case 'null': //null object or object does not exits
                                break;
                            case 'boolean': //booean object
                                break;
                            case 'number': //integer or real number
                                $propertySet[$key] = $pdfLib->pcos_get_number($doc, $key);
                                break;
                            case 'name': //name object
                                $propertySet[$key] = $pdfLib->pcos_get_string($doc, $key);
                                break;
                            case 'string': //string object
                                $propertySet[$key] = $pdfLib->pcos_get_string($doc, $key);
                                break;
                            case 'array': //array object
                                $propertySet[$key] = $pdfLib->pcos_get_string($doc, $key);
                                break;
                            case 'dict': //dictionary object (but not stream)
                                $propertySet[$key] = $pdfLib->pcos_get_string($doc, $key);
                                break;
                            case 'stream': //stream object which uses only supported filters
                                $propertySet[$key] = $pdfLib->pcos_get_string($doc, $key);
                                break;
                            case 'fstream': //stream object which uses one ore more unsupported filters
                                $propertySet[$key] = $pdfLib->pcos_get_string($doc, $key);
                                break;

                        }
                        var_dump($propertySet[$key]);
                    }
                    continue;
//                    echo " ------------- propertySet ----------------",PHP_EOL;
//                    var_dump($propertySet);
//                    continue;

//                    $linkDest = (int)$pdfLib->pcos_get_number($doc, $annotation_path . "/destpage");
//                    $pcosmode = $pdfLib->pcos_get_string($doc, "pcosmode");
//                    $subtype = $pdfLib->pcos_get_string($doc, $annotation_path . "/Subtype");
//                    $objectType = $pdfLib->pcos_get_string($doc, "type:" . $annotation_path . "/A/URI");
//                    $uri = $pdfLib->pcos_get_string($doc, $annotation_path . "/A/URI");
                    $pageHeight = (float)$pdfLib->pcos_get_number($doc, "pages[" . $pageNo . "]/height");
                    var_dump($pageHeight);
                    continue;
//                    $rect_path = $annotation_path . "/Rect";
//                    $rectX = abs($pdfLib->pcos_get_number($doc, $rect_path . "[0]"));
//                    $rectY = abs($pageHeight - (int)$pdfLib->pcos_get_number($doc, $rect_path . "[3]"));
//                    $rectWidth = abs($pdfLib->pcos_get_number($doc, $rect_path . "[2]") - $rectX);
//                    $rectHeight = abs($pageHeight - (int)$pdfLib->pcos_get_number($doc, $rect_path . "[1]") - $rectY);


                    //Web Link
                    if ($objectType != "string" && ($pcosmode == "URI" || $pcosmode == ">>")) {
                        continue;
                    } else if (($pcosmode == "URI" || $pcosmode == ">>") && $subtype == "Link" && substr($uri, 0, 2) != "yl") {
                        //Weblink Component
                    } else if ($pdfLib->pcos_get_string($doc, $annotation_path . "/Subtype") == "Link") {
                        //Page Link
                    }
                }
            }
        }


    }
}
