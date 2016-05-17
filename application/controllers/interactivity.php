<?php

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Interactivity_Controller extends Base_Controller
{

    public $restful = true;

    public function get_preview()
    {
        $componentID = Input::get('componentid');
        $componentName = Input::get('componentname');
        $c = Component::where('Class', '=', $componentName)->where('StatusID', '=', eStatus::Active)->count();
        if ($c > 0) {
            $ids = Input::get('compid');
            if ($ids !== null) {
                $data = array(
                    'preview' => true,
                    'baseDirectory' => Config::get("custom.url") . '/files/components/' . $componentName . '/',
                    'id' => ''
                );

                foreach ($ids as $id) {
                    if ((int)$componentID == (int)$id) {
                        $clientPageComponentID = (int)Input::get('comp-' . $id . '-pcid', '0');
                        $postedData = Input::get();

                        foreach ($postedData as $name => $value) {
                            if (Common::startsWith($name, 'comp-' . $id)) {
                                $name = str_replace('comp-' . $id . '-', "", $name);

                                if ($name !== "id" && $name !== "process" && $name !== "fileselected" && $name !== "posterimageselected" && $name !== "modaliconselected") {
                                    if (($name == 'file' || $name == 'filename' || $name == 'filename2') && is_array($value)) {
                                        //var_dump($value);
                                        //return;

                                        $files = array();

                                        foreach ($value as $v) {
                                            //var_dump($v);

                                            $pcp = DB::table('PageComponentProperty')
                                                ->where('PageComponentID', '=', $clientPageComponentID)
                                                ->where('Name', '=', $name)
                                                ->where('Value', 'LIKE', '%' . $v . '%')
                                                ->where('StatusID', '=', 1)
                                                ->first();

                                            if ($pcp) {
                                                //$files = array_merge($files, array($name => $pcp->Value));
                                                array_push($files, $pcp->Value);
                                            } else {
                                                $val = 'files/temp/' . $v;

                                                //$files = array_merge($files, array($name => $val));
                                                array_push($files, $val);
                                            }
                                        }

                                        //var_dump($files);
                                        //return;

                                        $data = array_merge($data, array('files' => $files));
                                    } elseif ($name == 'file' || $name == 'filename' || $name == 'filename2' || $name == 'posterimagename' || $name == 'modaliconname') {
                                        $pcp = DB::table('PageComponentProperty')
                                            ->where('PageComponentID', '=', $clientPageComponentID)
                                            ->where('Name', '=', $name)
                                            ->where('StatusID', '=', 1)
                                            ->first();
                                        if ($pcp) {
                                            if (Common::endsWith($pcp->Value, $value)) {
                                                $data = array_merge($data, array($name => $pcp->Value));
                                            } else {
                                                $val = 'files/temp/' . $value;
                                                $data = array_merge($data, array($name => $val));
                                            }
                                        } else {
                                            $val = 'files/temp/' . $value;
                                            $data = array_merge($data, array($name => $val));
                                        }
                                    } elseif ($name == 'url' && !Common::startsWith($value, 'http://') && !Common::startsWith($value, 'https://') && !empty($value)) {
                                        $value = 'http://' . $value;

                                        $data = array_merge($data, array($name => $value));
                                    } else {
                                        $data = array_merge($data, array($name => $value));
                                    }
                                }
                            }
                        }
                        break;
                    }
                }


                //var_dump($data);
                //return;

                if (isset($data['modal'])) {
                    if ((int)$data['modal'] == 1) {
                        $image_url = path('public') . $data["modaliconname"];
                        if (File::exists($image_url) && is_file($image_url)) {
                            $image_url = "/" . $data["modaliconname"];
                        } else {
                            $image_url = "/files/components/" . $componentName . "/icon.png";
                        }
                        // height="52"
//                        $fullUrl = Laravel\URL::full();
//                        $urlSrc = str_replace('-modal=1', '-modal=0', $fullUrl);
                        return '<html><head></head><body style="margin:0px; padding:0px;"><img src="' . $image_url . '" width="100%"></body></html>';
                        //return '<html><head></head><body style="margin:0px; padding:0px;"><img src="/files/components/'.$componentName.'/icon.png"></body></html>';
                    }
                }

                if ($componentName == 'video' || $componentName == 'audio' || $componentName == 'animation' || $componentName == 'tooltip' || $componentName == 'scroll' || $componentName == 'slideshow' || $componentName == 'gal360') {
                    $url = '';
                    if (isset($data['url'])) {
                        $url = $data['url'];
                    }
                    if (!(strpos($url, 'www.youtube.com/watch') === false)) {
                        $parts = parse_url($url);
                        parse_str($parts['query'], $query);
                        $data['url'] = 'http://www.youtube.com/embed/' . $query['v'];
                        return Redirect::to($data['url']);
                    }
                    if (!(strpos($url, 'www.youtube.com/embed') === false)) {
                        return Redirect::to($data['url']);
                    }

                    if (!(strpos($url, 'player.vimeo.com/video') === false)) {
                        return Redirect::to($data['url']);
                    }

                    return View::make('interactivity.components.' . $componentName . '.dynamic', $data);
                } elseif ($componentName == 'map') {
                    $type = 'roadmap';
                    if ((int)$data['type'] == 2) {
                        //hybrid
                        $type = 'satellite';
                    } elseif ((int)$data['type'] == 3) {
                        //satellite
                        $type = 'satellite';
                    }
                    /*
                      --------------------------------------------------------------------
                      http://stackoverflow.com/questions/9356724/google-map-api-zoom-range
                      --------------------------------------------------------------------
                      Google Maps basics
                      Zoom Level - zoom
                      0 - 19
                      0 lowest zoom (whole world)
                      19 highest zoom (individual buildings, if available) Retrieve current zoom level using mapObject.getZoom()
                      --------------------------------------------------------------------
                      0.01 = 10
                      0.02 = 20
                      .
                      .
                      --------------------------------------------------------------------
                     */
                    $zoom = 1000 * (float)$data['zoom'];
                    $z = (19 * $zoom / 100);

                    return Redirect::to('https://www.google.com/maps/embed/v1/search?'
                        . 'maptype=' . $type
                        . '&q=' . $data['lat'] . ',' . $data['lon']
                        . '&zoom=' . $z
                        . '&key=' . Config::get('custom.google_api_key')
                    );
                } elseif ($componentName == 'link') {
                    return '';
                } elseif ($componentName == 'webcontent') {
                    return Redirect::to($data['url']);
                } elseif ($componentName == 'bookmark') {
                    return '';
                }
            }
        }
        return 'error';
    }

    public function get_show($contentFileID)
    {
        set_time_limit(3000);
        $ContentID = (int)ContentFile::find($contentFileID)->ContentID;
        $ApplicationID = (int)Content::find($ContentID)->ApplicationID;

        if (!Common::CheckContentOwnership($ContentID)) {
            $data = array(
                'errmsg' => __('error.unauthorized_user_attempt')
            );
            return View::make('interactivity.error', $data);
        }

        if (!Common::AuthInteractivity($ApplicationID)) {
            $data = array(
                'errmsg' => __('error.auth_interactivity')
            );
            return View::make('interactivity.error', $data);
        }

        $content = Content::find($ContentID);
        $cf = ContentFile::find($contentFileID);
        if (!$cf) {
            return View::make('interactivity.error', array('errmsg' => __('error.your_page_not_found')));
        }

        if ($cf->Interactivity == ContentFile::InteractivityProcessContinues) {
            return Redirect::to('/' . __('route.contents') . '/' . $cf->ContentID . '?error=' . __('error.interactivity_conflict'));
        }

        $errorMsg = ContentFile::makeContentInteractive($cf);
        if ($errorMsg) {
            Common::sendErrorMail($errorMsg);
            return View::make('interactivity.error', array('errmsg' => $errorMsg));
        }
        
        $data = array(
            'content' => $content,
            'ContentID' => $cf->ContentID,
            'ContentFileID' => $cf->ContentFileID,
            'included' => (int)$cf->Included,
            'filename' => $cf->FileName,
            'pages' => $cf->ContentFilePage
        );

        return View::make('interactivity.master', $data)
            ->nest('header', 'interactivity.header', $data)
            ->nest('sidebar', 'interactivity.sidebar', $data)
            ->nest('footer', 'interactivity.footer', $data);
    }

    public function get_fb($applicationID)
    {
        //return $applicationID;
        $search = Input::get('search', '');
        $cats = Input::get('cat', '');
        $where = '';

        if (is_array($cats)) {
            $arrCategory = array();
            foreach ($cats as $cat) {
                array_push($arrCategory, (int)$cat);
            }
            $where .= ' AND o.`ContentID` IN (SELECT ContentID FROM ContentCategory WHERE CategoryID IN (' . implode(',', $arrCategory) . '))';
        }

        if (Str::length($search) > 0) {
            $search = str_replace("'", "", $search);
            $where .= ' AND o.`Name` LIKE \'%' . $search . '%\'';
        }
        $contentFileSQL = 'SELECT ContentFileID FROM ContentFile WHERE ContentID=o.ContentID AND StatusID=1';
        $sql = '' .
            'SELECT ' .
            'c.CustomerID, ' .
            'c.CustomerName, ' .
            'a.ApplicationID, ' .
            'a.Name AS ApplicationName, ' .
            'o.Name, ' .
            'o.Detail, ' .
            '(SELECT CONCAT(FilePath, \'/\', FileName) FROM ContentCoverImageFile WHERE ContentFileID IN (' . $contentFileSQL . ') AND StatusID=1 ORDER BY ContentCoverImageFileID DESC LIMIT 1) AS CoverImageFile, ' .
            'o.ContentID ' .
            'FROM `Customer` AS c ' .
            'INNER JOIN `Application` AS a ON a.CustomerID=c.CustomerID AND a.ApplicationID=' . (int)$applicationID . ' AND a.StatusID=1 ' .
            'INNER JOIN `Content` AS o ON o.ApplicationID=a.ApplicationID' . $where . ' AND IFNULL(o.Blocked, 0)=0 AND o.Status=1 AND IsProtected=0 AND (SELECT COUNT(*) FROM ContentFilePage WHERE ContentFileID IN (' . $contentFileSQL . ') AND StatusID=1) > 0 AND o.StatusID=1 ' .
            'WHERE c.StatusID=1';
        //var_dump($sql);
        $contents = DB::table(DB::raw('(' . $sql . ') t'))->get();

        $sql = '' .
            'SELECT * ' .
            'FROM Category ' .
            'WHERE CategoryID IN (SELECT CategoryID FROM `ContentCategory` WHERE ContentID IN (SELECT ContentID FROM (' . $sql . ') t)) AND StatusID=1 ' .
            'ORDER BY `Name` ASC';
        $categories = DB::table(DB::raw('(' . $sql . ') t'))->get();
        //$categories = Category::where('ApplicationID', '=', (int)$applicationID)->where('StatusID', '=', eStatus::Active)->order_by('Name', 'ASC')->get();

        $data = array(
            'filterSearch' => $search,
            'filterCat' => $cats,
            'cat' => $categories,
            'contents' => $contents
        );
        return View::make('flipbook.index', $data);
    }

    public function post_check()
    {
        try {
            $url = Input::get('url');
            $connectable = false;
            $handle = curl_init($url);
            if ($handle !== false) {
                curl_setopt($handle, CURLOPT_HEADER, true);
                curl_setopt($handle, CURLOPT_FAILONERROR, true);
                curl_setopt($handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                curl_setopt($handle, CURLOPT_NOBODY, true);
                curl_setopt($handle, CURLOPT_TIMEOUT, 10);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($handle, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
                $connectable = curl_exec($handle);
                curl_close($handle);
                if (!$connectable) {
                    //eger server CURLOPT_NOBODY desteklemiyorsa
                    $handle2 = curl_init($url);
                    curl_setopt($handle2, CURLOPT_HEADER, true);
                    curl_setopt($handle2, CURLOPT_FAILONERROR, true);
                    curl_setopt($handle2, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                    curl_setopt($handle2, CURLOPT_TIMEOUT, 10);
                    curl_setopt($handle2, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($handle2, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($handle2, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
                    $connectable = curl_exec($handle2);
                }
            }
            if ($connectable) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
    }

    public function post_save()
    {
        try {
            //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
            $currentUser = Auth::User();

            $included = (int)Input::get('included');
            $contentFileID = (int)Input::get('contentfileid', 0);
            $contentID = (int)ContentFile::find($contentFileID)->ContentID;
            $applicationID = (int)Content::find($contentID)->ApplicationID;
            $customerID = (int)Application::find($applicationID)->CustomerID;

            if (!Common::CheckContentOwnership($contentID)) {
                throw new Exception(__('error.unauthorized_user_attempt'));
            }

            if (!Common::AuthInteractivity($applicationID)) {
                throw new Exception(__('error.auth_interactivity'));
            }

            /** @var ContentFilePage $contentFilePage */
            $contentFilePage = ContentFilePage::where('ContentFileID', '=', $contentFileID)
                ->where('No', '=', Input::get('pageno'))
                ->where('StatusID', '=', eStatus::Active)
                ->first();

            if (!$contentFilePage) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode('ContentFilePage not found');
            } else {
                if ($contentFilePage->OperationStatus) {
                    return "success=" . base64_encode("false") . "&errmsg=" . base64_encode('Previous save operation not complete');
                } else {
                    $contentFilePage->OperationStatus = 1;
                    $contentFilePage->save();
                }
            }


            $contentFilePageID = $contentFilePage->ContentFilePageID;

            //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
            DB::transaction(
                function () use ($currentUser, $customerID, $applicationID, $contentID, $contentFileID, $contentFilePageID, $included) {
                    $closing = Input::get('closing');
                    $ids = (array)Input::get('compid');

                    //find current page id


                    $contentFile = ContentFile::find($contentFileID);
                    $contentFile->Included = ($included == 1 ? 1 : 0);
                    if ($closing == "true") {
                        $contentFile->Interactivity = 1;
                        $contentFile->HasCreated = 0;
                        $contentFile->ErrorCount = 0;
                        $contentFile->InteractiveFilePath = '';
                        $contentFile->InteractiveFileName = '';
                        $contentFile->InteractiveFileName2 = '';
                        $contentFile->InteractiveFileSize = 0;
                    }
                    $contentFile->save();

                    $postedData = Input::get();
                    $componentProperties = array();
                    $ignoredProperties = array('id', 'process', 'fileselected', 'posterimageselected', 'modaliconselected');
                    foreach ($ids as $id) {
                        $properties = array();
                        foreach ($postedData as $name => $value) {
                            if (Common::startsWith($name, 'comp-' . $id)) {
                                $name = str_replace('comp-' . $id . '-', "", $name);
                                if (!in_array($name, $ignoredProperties)) {
                                    $properties[$name] = $value;
                                }
                            }
                        }
                        $componentProperties[$id] = $properties;
                        //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
                    }

                    foreach ($ids as $id) {
                        //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
                        $clientComponentID = (int)Input::get('comp-' . $id . '-id', '0');
                        $clientPageComponentID = (int)Input::get('comp-' . $id . '-pcid', '0');
                        $clientProcess = Input::get('comp-' . $id . '-process', '');

                        if ($clientProcess == 'new' || $clientProcess == 'loaded') {
                            $tPageComponentExists = false;

                            if ($clientProcess == 'loaded' && $clientPageComponentID > 0) {
                                $tPageComponentExists = true;
                                $pageComponent = PageComponent::find($clientPageComponentID);
                            } else {
                                $pageComponent = new PageComponent();
                            }

                            $pageComponent->ContentFilePageID = $contentFilePageID;
                            $pageComponent->ComponentID = $clientComponentID;
                            $pageComponent->No = $id;
                            $pageComponent->save();

                            //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
                            if ($tPageComponentExists) {
                                //wtf neden statusu deleted yapiyor ????
                                DB::table('PageComponentProperty')
                                    ->where('PageComponentID', '=', $pageComponent->PageComponentID)
                                    ->where('StatusID', '=', eStatus::Active)
                                    ->update(
                                        array(
                                            'StatusID' => eStatus::Deleted,
                                            'ProcessUserID' => $currentUser->UserID,
                                            'ProcessDate' => new DateTime(),
                                            'ProcessTypeID' => eProcessTypes::Update
                                        )
                                    );
                            }
                            //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());

                            foreach ($componentProperties[$id] as $name => $value) {
                                //Log::info('line:' . __LINE__ . ' comp:' . $name . ' time:' . microtime());

                                //slideshow || gallery360
                                if (($name == 'file' || $name == 'filename' || $name == 'filename2') && is_array($value)) {
                                    $index = 1;

                                    foreach ($value as $v) {
                                        if (Str::length($v) > 0) {
                                            $sourcePath = 'files/temp';
                                            $sourcePathFull = path('public') . $sourcePath;
                                            $sourceFile = $v;
                                            $sourceFileNameFull = $sourcePathFull . '/' . $sourceFile;

                                            $targetPath = 'files/customer_' . $customerID . '/application_' . $applicationID . '/content_' . $contentID . '/file_' . $contentFileID . '/output/comp_' . $pageComponent->PageComponentID;
                                            $targetPathFull = path('public') . $targetPath;
                                            $targetFile = $currentUser->UserID . '_' . date("YmdHis") . '_' . $v;
                                            //360
                                            if ($clientComponentID == 9) {
                                                $targetFile = ($index < 10 ? '0' . $index : '' . $index) . '.jpg';
                                            }
                                            $targetFileNameFull = $targetPathFull . '/' . $targetFile;

                                            if (!File::exists($targetPathFull)) {
                                                File::mkdir($targetPathFull);
                                            }

                                            if (File::exists($sourceFileNameFull)) {
                                                File::move($sourceFileNameFull, $targetFileNameFull);
                                                $v = $targetPath . '/' . $targetFile;
                                            } else {
                                                $oldValue = DB::table('PageComponentProperty')
                                                    ->where('PageComponentID', '=', $pageComponent->PageComponentID)
                                                    ->where('Name', '=', $name)
                                                    ->where('Value', 'LIKE', '%' . $v)
                                                    ->where('StatusID', '=', eStatus::Deleted)
                                                    ->order_by('PageComponentPropertyID', 'DESC')
                                                    ->first(array('Value'));
                                                if ($oldValue) {
                                                    $v = $oldValue->Value;
                                                } else {
                                                    $v = $targetPath . '/' . $v;
                                                }
                                                //TODO:kaydete bastiktan sonra ikinci kez kaydete basilirsa veriler bozuluyor !!!
                                                //$v = $targetPath.'/'.$v;
                                            }

                                            $pcp = new PageComponentProperty();
                                            $pcp->PageComponentID = $pageComponent->PageComponentID;
                                            $pcp->Name = $name;
                                            $pcp->Value = $v;
                                            $pcp->StatusID = eStatus::Active;
                                            $pcp->CreatorUserID = $currentUser->UserID;
                                            $pcp->DateCreated = new DateTime();
                                            $pcp->ProcessUserID = $currentUser->UserID;
                                            $pcp->ProcessDate = new DateTime();
                                            $pcp->ProcessTypeID = eProcessTypes::Insert;
                                            $pcp->save();

                                            $index = $index + 1;
                                        }
                                    }
                                } else {
                                    if (($name == 'file' || $name == 'filename' || $name == 'filename2' || $name == 'posterimagename' || $name == 'modaliconname') && Str::length($value) > 0) {
                                        $sourcePath = 'files/temp';
                                        $sourcePathFull = path('public') . $sourcePath;
                                        $sourceFile = $value;
                                        $sourceFileNameFull = $sourcePathFull . '/' . $sourceFile;

                                        $targetPath = 'files/customer_' . $customerID . '/application_' . $applicationID . '/content_' . $contentID . '/file_' . $contentFileID . '/output/comp_' . $pageComponent->PageComponentID;
                                        $targetPathFull = path('public') . $targetPath;
                                        $targetFile = $currentUser->UserID . '_' . date("YmdHis") . '_' . $value;
                                        $targetFileNameFull = $targetPathFull . '/' . $targetFile;

                                        if (!File::exists($targetPathFull)) {
                                            File::mkdir($targetPathFull);
                                        }

                                        if (File::exists($sourceFileNameFull)) {
                                            File::move($sourceFileNameFull, $targetFileNameFull);
                                            $value = $targetPath . '/' . $targetFile;
                                        } else {
                                            $oldValue = DB::table('PageComponentProperty')
                                                ->where('PageComponentID', '=', $pageComponent->PageComponentID)
                                                ->where('Name', '=', $name)
                                                ->where('StatusID', '=', eStatus::Deleted)
                                                ->order_by('PageComponentPropertyID', 'DESC')
                                                ->first(array('Value'));

                                            if ($oldValue) {
                                                $value = $oldValue->Value;
                                            } else {
                                                $value = $targetPath . '/' . $value;
                                            }
                                            //TODO:kaydete bastiktan sonra ikinci kez kaydete basilirsa veriler bozuluyor !!!
                                            //$value = $targetPath.'/'.$value;
                                        }
                                    }

                                    if ($name == 'url' && !Common::startsWith($value, 'http://') && !Common::startsWith($value, 'https://') && !empty($value)) {
                                        $value = 'http://' . $value;
                                    }
                                    $value = str_replace("www.youtube.com/watch?v=", "www.youtube.com/embed/", $value);

                                    $pcp = new PageComponentProperty();
                                    $pcp->PageComponentID = $pageComponent->PageComponentID;
                                    $pcp->Name = $name;
                                    $pcp->Value = $value;
                                    $pcp->StatusID = eStatus::Active;
                                    $pcp->CreatorUserID = $currentUser->UserID;
                                    $pcp->DateCreated = new DateTime();
                                    $pcp->ProcessUserID = $currentUser->UserID;
                                    $pcp->ProcessDate = new DateTime();
                                    $pcp->ProcessTypeID = eProcessTypes::Insert;
                                    $pcp->save();
                                }

                            }
                        } elseif ($clientProcess == 'removed' && $clientPageComponentID > 0) {
                            DB::table('PageComponentProperty')
                                ->where('PageComponentID', 'IN', DB::raw('(SELECT `PageComponentID` FROM `PageComponent` WHERE `PageComponentID`=' . $clientPageComponentID . ' AND `ContentFilePageID`=' . $contentFilePageID . ' AND `StatusID`=1)'))
                                ->where('StatusID', '=', eStatus::Active)
                                ->update(
                                    array(
                                        'StatusID' => eStatus::Deleted,
                                        'ProcessUserID' => $currentUser->UserID,
                                        'ProcessDate' => new DateTime(),
                                        'ProcessTypeID' => eProcessTypes::Update
                                    )
                                );

                            DB::table('PageComponent')
                                ->where('PageComponentID', '=', $clientPageComponentID)
                                ->where('ContentFilePageID', '=', $contentFilePageID)
                                ->where('StatusID', '=', eStatus::Active)
                                ->update(
                                    array(
                                        'StatusID' => eStatus::Deleted,
                                        'ProcessUserID' => $currentUser->UserID,
                                        'ProcessDate' => new DateTime(),
                                        'ProcessTypeID' => eProcessTypes::Update
                                    )
                                );

                            //TODO:Delete current file
                        }
                    }
                    //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
                });
            //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
            if (Laravel\Request::env() == ENV_LIVE && Input::get('closing') == "true") {
                interactivityQueue::trigger();
            }
            //echo 'breakPoint: ' . $i++ . " -- " . microtime(true), PHP_EOL;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            if ($contentFilePage) {
                $contentFilePage->OperationStatus = 0;
                $contentFilePage->save();
            }
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }

        $contentFilePage->OperationStatus = 0;
        $contentFilePage->save();
        return "success=" . base64_encode("true");
    }

    public function post_transfer()
    {
        //return "success=".base64_encode("false");
        try {
            $currentUser = Auth::User();
            $pageFrom = (int)Input::get('from', '0');
            $pageTo = (int)Input::get('to', '0');
            $componentID = (int)Input::get('componentid', '0');
            $contentFileID = (int)Input::get('contentfileid', '0');
            $contentID = (int)ContentFile::find($contentFileID)->ContentID;
            $applicationID = (int)Content::find($contentID)->ApplicationID;
            $customerID = (int)Application::find($applicationID)->CustomerID;

            if (!Common::CheckContentOwnership($contentID)) {
                throw new Exception(__('error.unauthorized_user_attempt'));
            }

            if (!Common::AuthInteractivity($applicationID)) {
                throw new Exception(__('error.auth_interactivity'));
            }

            DB::transaction(function () use ($currentUser, $customerID, $applicationID, $contentID, $contentFileID, $componentID, $pageFrom, $pageTo) {
                $contentFilePageIDFrom = 0;
                $cfp = DB::table('ContentFilePage')
                    ->where('ContentFileID', '=', $contentFileID)
                    ->where('No', '=', $pageFrom)
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();
                if ($cfp) {
                    $contentFilePageIDFrom = (int)$cfp->ContentFilePageID;
                }

                $contentFilePageIDTo = 0;
                $cfp = DB::table('ContentFilePage')
                    ->where('ContentFileID', '=', $contentFileID)
                    ->where('No', '=', $pageTo)
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();
                if ($cfp) {
                    $contentFilePageIDTo = (int)$cfp->ContentFilePageID;
                }

                $cnt = (int)DB::table('PageComponent')->where('ContentFilePageID', '=', $contentFilePageIDFrom)->where('StatusID', '=', eStatus::Active)->count();
                if ($cnt == 0) {
                    throw new Exception(__('interactivity.transfer_error_insufficient'));
                }

                if ($componentID > 0) {
                    DB::table('PageComponent')
                        ->where('ContentFilePageID', '=', $contentFilePageIDFrom)
                        ->where('No', '=', $componentID)
                        ->where('StatusID', '=', eStatus::Active)
                        ->update(array(
                                'ContentFilePageID' => $contentFilePageIDTo,
                                'ProcessUserID' => $currentUser->UserID,
                                'ProcessDate' => new DateTime(),
                                'ProcessTypeID' => eProcessTypes::Update
                            )
                        );
                } else {
                    DB::table('PageComponent')
                        ->where('ContentFilePageID', '=', $contentFilePageIDFrom)
                        ->where('StatusID', '=', eStatus::Active)
                        ->update(array(
                                'ContentFilePageID' => $contentFilePageIDTo,
                                'ProcessUserID' => $currentUser->UserID,
                                'ProcessDate' => new DateTime(),
                                'ProcessTypeID' => eProcessTypes::Update
                            )
                        );
                }

                //From
                $componentNo = 1;
                $pageComponents = DB::table('PageComponent')
                    ->where('ContentFilePageID', '=', $contentFilePageIDFrom)
                    ->where('StatusID', '=', eStatus::Active)
                    ->order_by('PageComponentID', 'ASC')
                    ->get();
                foreach ($pageComponents as $component) {
                    DB::table('PageComponent')
                        ->where('PageComponentID', '=', $component->PageComponentID)
                        ->update(array(
                                'No' => $componentNo,
                                'ProcessUserID' => $currentUser->UserID,
                                'ProcessDate' => new DateTime(),
                                'ProcessTypeID' => eProcessTypes::Update
                            )
                        );
                    $componentNo += 1;
                }

                //To
                $componentNo = 1;
                $pageComponents = DB::table('PageComponent')
                    ->where('ContentFilePageID', '=', $contentFilePageIDTo)
                    ->where('StatusID', '=', eStatus::Active)
                    ->order_by('PageComponentID', 'ASC')
                    ->get();
                foreach ($pageComponents as $component) {
                    DB::table('PageComponent')
                        ->where('PageComponentID', '=', $component->PageComponentID)
                        ->update(array(
                                'No' => $componentNo,
                                'ProcessUserID' => $currentUser->UserID,
                                'ProcessDate' => new DateTime(),
                                'ProcessTypeID' => eProcessTypes::Update
                            )
                        );
                    $componentNo += 1;
                }
            });
            return "success=" . base64_encode("true");
        } catch (Exception $e) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
    }

    public function post_refreshtree()
    {
        //return "success=".base64_encode("false");
        try {
            $currentUser = Auth::User();

            $contentFileID = (int)Input::get('contentfileid', '0');
            $contentID = (int)ContentFile::find($contentFileID)->ContentID;
            $applicationID = (int)Content::find($contentID)->ApplicationID;
            $customerID = (int)Application::find($applicationID)->CustomerID;

            if (!Common::CheckContentOwnership($contentID)) {
                throw new Exception(__('error.unauthorized_user_attempt'));
            }

            if (!Common::AuthInteractivity($applicationID)) {
                throw new Exception(__('error.auth_interactivity'));
            }
            $data = array(
                'ContentFileID' => $contentFileID
            );
            $html = View::make('interactivity.tree', $data)->render();
            return "success=" . base64_encode("true") . "&html=" . base64_encode($html);
        } catch (Exception $e) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
    }

    public function post_upload()
    {
        //$file = Input::file('Filedata');
        //$filePath = path('public').'files/temp';
        //$fileName = File::name($file['name']);
        //$fileExt = File::extension($file['name']);
        //$tempFile = $fileName.'_'.Str::random(20).'.'.$fileExt;

        $type = Input::get('type');
        $element = Input::get('element');

        $options = array();
        if ($type == 'uploadvideofile') {
            $options = array(
                'upload_dir' => path('public') . 'files/temp/',
                'upload_url' => URL::base() . '/files/temp/',
                'param_name' => $element,
                'accept_file_types' => '/\.(mp4)$/i'
            );
        } else if ($type == 'uploadaudiofile') {
            $options = array(
                'upload_dir' => path('public') . 'files/temp/',
                'upload_url' => URL::base() . '/files/temp/',
                'param_name' => $element,
                'accept_file_types' => '/\.(mp3)$/i'
            );
        } else if ($type == 'uploadimage') {
            $options = array(
                'upload_dir' => path('public') . 'files/temp/',
                'upload_url' => URL::base() . '/files/temp/',
                'param_name' => $element,
                'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i'
            );
        }
        $upload_handler = new UploadHandler($options);

        if (!Request::ajax()) {
            return;
        }

        $upload_handler->post("");
    }

    public function post_loadpage()
    {
        try {
            $currentUser = Auth::User();

            $contentFileID = (int)Input::get('contentfileid');
            $pageNo = (int)Input::get('pageno');

            $contentID = (int)ContentFile::find($contentFileID)->ContentID;
            $applicationID = (int)Content::find($contentID)->ApplicationID;
            $customerID = (int)Application::find($applicationID)->CustomerID;

            if (!Common::CheckContentOwnership($contentID)) {
                throw new Exception(__('error.unauthorized_user_attempt'));
            }

            if (!Common::AuthInteractivity($applicationID)) {
                throw new Exception(__('error.auth_interactivity'));
            }

            $ContentFilePageID = 0;

            $cfp = DB::table('ContentFilePage')
                ->where('ContentFileID', '=', $contentFileID)
                ->where('No', '=', $pageNo)
                ->where('StatusID', '=', eStatus::Active)
                ->first();
            if ($cfp) {
                $ContentFilePageID = (int)$cfp->ContentFilePageID;
            }

            $pageCount = DB::table('ContentFilePage')
                ->where('ContentFileID', '=', $contentFileID)
                ->where('StatusID', '=', eStatus::Active)
                ->count();

            $toolC = '';
            $propC = '';

            $pc = DB::table('PageComponent')
                ->where('ContentFilePageID', '=', $ContentFilePageID)
                ->where('StatusID', '=', eStatus::Active)
                ->get();
            foreach ($pc as $c) {
                $componentClass = PageComponent::find($c->PageComponentID)->Component()->Class;

                $cp = DB::table('PageComponentProperty')
                    ->where('PageComponentID', '=', $c->PageComponentID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->get();

                $cpX = DB::table('PageComponentProperty')
                    ->where('PageComponentID', '=', $c->PageComponentID)
                    ->where('Name', '=', 'x')
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();

                $cpY = DB::table('PageComponentProperty')
                    ->where('PageComponentID', '=', $c->PageComponentID)
                    ->where('Name', '=', 'y')
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();

                $cpTriggerX = DB::table('PageComponentProperty')
                    ->where('PageComponentID', '=', $c->PageComponentID)
                    ->where('Name', '=', 'trigger-x')
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();

                $cpTriggerY = DB::table('PageComponentProperty')
                    ->where('PageComponentID', '=', $c->PageComponentID)
                    ->where('Name', '=', 'trigger-y')
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();

                $x = 0;
                $y = 0;
                $trigger_x = 0;
                $trigger_y = 0;
                if ($cpX) {
                    $x = (int)$cpX->Value;
                }
                if ($cpY) {
                    $y = (int)$cpY->Value;
                }
                if ($cpTriggerX) {
                    $trigger_x = (int)$cpTriggerX->Value;
                }
                if ($cpTriggerY) {
                    $trigger_y = (int)$cpTriggerY->Value;
                }

                if ($componentClass == "audio" || $componentClass == "bookmark") {
                    $x = $trigger_x;
                    $y = $trigger_y;
                }

                $data = array(
                    'ComponentID' => $c->ComponentID,
                    'PageComponentID' => $c->PageComponentID,
                    'Process' => 'loaded',
                    'PageCount' => $pageCount,
                    'Properties' => $cp
                );
                $tool = View::make('interactivity.components.' . $componentClass . '.tool', $data)->render();
                //$tool = str_replace("{id}", $c->PageComponentID, $tool);
                $tool = str_replace("{id}", $c->No, $tool);
                $tool = str_replace("{name}", $componentClass, $tool);
                $tool = str_replace("{x}", $x, $tool);
                $tool = str_replace("{y}", $y, $tool);
                $tool = str_replace("{trigger-x}", $trigger_x, $tool);
                $tool = str_replace("{trigger-y}", $trigger_y, $tool);
                $toolC .= $tool;

                $prop = View::make('interactivity.components.' . $componentClass . '.property', $data)->render();
                //$prop = str_replace("{id}", $c->PageComponentID, $prop);
                $prop = str_replace("{id}", $c->No, $prop);
                $propC .= $prop;
            }
            return "success=" . base64_encode("true") . "&tool=" . base64_encode($toolC) . "&prop=" . base64_encode($propC);
        } catch (Exception $e) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
    }

}
