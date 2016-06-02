<?php

class Contents_Controller extends Base_Controller
{

    public $restful = true;
    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';
    public $caption = '';
    public $detailcaption = '';
    public $fields;
    private $defaultSort = "OrderNo";

    public function __construct()
    {
        parent::__construct();
        $this->page = 'contents';
        $this->route = __('route.' . $this->page);
        $this->table = 'Content';
        $this->pk = 'ContentID';
        $this->caption = __('common.contents_caption');
        $this->detailcaption = __('common.contents_caption_detail');
        $this->fields = array();
        $this->fields[] = array(__('common.contents_list_customer'), 'CustomerName');
        $this->fields[] = array(__('common.contents_list_application'), 'ApplicationName');
        $this->fields[] = array(__('common.contents_list_content_name'), 'Name');
        $this->fields[] = array(__('common.contents_list_content_bloke'), 'Blocked');
        $this->fields[] = array(__('common.contents_list_status'), 'Status');
        $this->fields[] = array(__('common.contents_list_content_id'), 'ContentID');

        if (Auth::check()) {
            if ((int)Auth::User()->UserTypeID == eUserTypes::Customer) {
                $this->fields = array();
                $this->fields[] = array(__('common.contents_list_content_name'), 'Name');
                $this->fields[] = array(__('common.contents_list_content_category'), 'CategoryName');
                $this->fields[] = array(__('common.contents_list_content_publishdate'), 'PublishDate');
                $this->fields[] = array(__('common.contents_list_content_unpublishdate'), 'UnpublishDate');
                $this->fields[] = array(__('common.contents_list_content_bloke'), 'Blocked');
                $this->fields[] = array(__('common.contents_list_status'), 'Status');
                $this->fields[] = array(__('common.contents_list_content_id'), 'ContentID');
            }
        }
    }

    public function get_index()
    {
        $currentUser = Auth::User();
        $applicationID = (int)Input::get('applicationID', 0);
        $search = Input::get('search', '');
        $sort = Input::get('sort', $this->defaultSort);
        $sort_dir = Input::get('sort_dir', 'DESC');
        $rowcount = (int)Config::get('custom.rowcount');
        $p = Input::get('page', 1);
        $option = (int)Input::get('option', 0);

        if (!Common::CheckApplicationOwnership($applicationID)) {
            return Redirect::to(__('route.home'));
        }

        $sqlCat = '(IFNULL((SELECT GROUP_CONCAT(`Name` ORDER BY `Name` SEPARATOR \', \')'
            . ' FROM `Category` WHERE ApplicationID=a.ApplicationID AND CategoryID IN '
            . '(SELECT CategoryID FROM `ContentCategory` WHERE ContentID = o.ContentID) AND StatusID = 1), \'\'))';

        $sql = '' .
            'SELECT ' .
            'c.CustomerID, ' .
            'c.CustomerName, '
            . 'o.OrderNo,' .
            'a.ApplicationID, ' .
            'a.Name AS ApplicationName, ' .
            'o.Name, ' .
            '(' .
            'CASE WHEN (SELECT COUNT(*) FROM `ContentCategory` WHERE ContentID = o.ContentID AND CategoryID = 0) > 0 ' .
            'THEN CONCAT(\'' . __('common.contents_category_list_general') . ', \', ' . $sqlCat . ') ' .
            'ELSE ' . $sqlCat . ' ' .
            'END' .
            ') AS CategoryName, ' .
            'o.PublishDate, ' .
            'o.UnpublishDate, ' .
            'o.IsMaster, ' .
            '(CASE o.Blocked WHEN 1 THEN \'' . __('common.contents_list_blocked1') . '\' ELSE \'' . __('common.contents_list_blocked0') . '\' END) AS Blocked, ' .
            '(CASE WHEN ('
            . 'o.Status = 1 AND '
            . '(o.PublishDate <= CURDATE()) AND '
            . '(o.IsUnpublishActive = 0 OR o.UnpublishDate > CURDATE())) '
            . 'THEN \'' . __('common.contents_list_status1') . '\' ' .
            'ELSE \'' . __('common.contents_list_status0') . '\' END) AS Status, ' .
            'o.ContentID ' .
            'FROM `Customer` AS c ' .
            'INNER JOIN `Application` AS a ON a.CustomerID=c.CustomerID AND a.StatusID=1 ' .
            'INNER JOIN `Content` AS o ON o.ApplicationID=a.ApplicationID AND o.StatusID=1 ' .
            'WHERE c.StatusID=1';
        $rs = DB::table(DB::raw('(' . $sql . ') t'))
            ->where(function ($query) use ($currentUser, $applicationID, $search) {
                /** @var Laravel\Database\Query $query */
                if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
                    if ($applicationID > 0) {
                        $query->where('ApplicationID', '=', $applicationID);
                    }

                    if (strlen(trim($search)) > 0) {
                        $query->where(function ($q) use ($search) {
                            /** @var \Laravel\Database\Query $q */
                            $q->where('CustomerName', 'LIKE', '%' . $search . '%');
                            $q->or_where('ApplicationName', 'LIKE', '%' . $search . '%');
                            $q->or_where('Blocked', 'LIKE', '%' . $search . '%');
                            $q->or_where('Status', 'LIKE', '%' . $search . '%');
                            $q->or_where('ContentID', 'LIKE', '%' . $search . '%');
                        });
                    }
                } elseif ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
                    if (Common::CheckApplicationOwnership($applicationID)) {
                        if (strlen(trim($search)) > 0) {
                            $query->where('ApplicationID', '=', $applicationID);
                            $query->where(function ($q) use ($search) {
                                /** @var \Laravel\Database\Query $q */
                                $q->where('Name', 'LIKE', '%' . $search . '%');
                                $q->or_where('CategoryName', 'LIKE', '%' . $search . '%');
                                $q->or_where('PublishDate', 'LIKE', '%' . $search . '%');
                                $q->or_where('Blocked', 'LIKE', '%' . $search . '%');
                                $q->or_where('Status', 'LIKE', '%' . $search . '%');
                                $q->or_where('ContentID', 'LIKE', '%' . $search . '%');
                            });
                        } else {
                            $query->where('ApplicationID', '=', $applicationID);
                        }
                    } else {
                        $query->where('ApplicationID', '=', -1);
                    }
                }
            })
            ->order_by($sort, $sort_dir);
        if ($sort != $this->defaultSort) {
            $rs->order_by($this->defaultSort, 'DESC');
        }

        if ($option == 1) {
            $data = array(
                'rows' => $rs->get()
            );
            return View::make('pages.' . Str::lower($this->table) . 'optionlist', $data);
        }

        $count = $rs->count();
        $results = $rs->for_page($p, $rowcount)->get();
        $rows = Paginator::make($results, $count, $rowcount);
        $categorySet = Category::where('ApplicationID', '=', $applicationID)->where("statusID", "=", eStatus::Active)->get();
        $application = Application::find($applicationID);
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
            'categorySet' => $categorySet,
            'application' => $application
        );

        if (((int)$currentUser->UserTypeID == eUserTypes::Customer)) {
            $appCount = DB::table('Application')
                ->where('CustomerID', '=', Auth::User()->CustomerID)
                ->where('ApplicationID', '=', $applicationID)
                ->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
                ->count();

            if ($appCount == 0) {

                $app = Application::find($applicationID);
                if (!$app) {
                    return Redirect::to(__('route.home'));
                }

                $data = array_merge($data, array('appName' => $app->Name));

                return View::make('pages.expiredpage', $data)
                    ->nest('filterbar', 'sections.filterbar', $data)
                    ->nest('commandbar', 'sections.commandbar', $data);
            }
        }

        return $html = View::make('pages.' . Str::lower($this->table) . 'list', $data)
            ->nest('filterbar', 'sections.filterbar', $data)
            ->nest('commandbar', 'sections.commandbar', $data);
    }

    public function get_request()
    {
        //"http://www.galepress.com/tr/icerikler/talep?W=%s&H=%s&RequestTypeID=%s&ContentID=%s";
        $RequestTypeID = (int)Input::get('RequestTypeID', 0);
        $ContentID = (int)Input::get('ContentID', 0);
        $Password = Input::get('Password', '');
        $Width = (int)Input::get('W', 0);
        $Height = (int)Input::get('H', 0);


        //http://localhost/tr/icerikler/talep?RequestTypeID=203&ApplicationID=1&ContentID=1187&Password=
        try {
            if ($RequestTypeID == PDF_FILE) {
                //get file
                $oCustomerID = 0;
                $oApplicationID = 0;
                $oContentID = 0;
                $oContentFileID = 0;
                $oContentFilePath = '';
                $oContentFileName = '';
                Common::getContentDetail($ContentID, $Password, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, $oContentFilePath, $oContentFileName);
                Common::download($RequestTypeID, $oCustomerID, $oApplicationID, $oContentID, $oContentFileID, 0, $oContentFilePath, $oContentFileName);
            } else {
                //get image
                Common::downloadImage($ContentID, $RequestTypeID, $Width, $Height);
            }
        } catch (Exception $e) {
            $r = '';
            $r .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
            $r .= "<Response>\n";
            $r .= "<Error code=\"" . $e->getCode() . "\">" . Common::xmlEscape($e->getMessage()) . "</Error>\n";
            $r .= "</Response>\n";
            return Response::make($r, 200, array('content-type' => 'text/xml'));
        }
    }

    public function get_new()
    {
        $this->route = __('route.' . $this->page) . '?applicationID=' . Input::get('applicationID', '0');

        $data = array(
            'page' => $this->page,
            'route' => $this->route,
            'caption' => $this->caption,
            'detailcaption' => $this->detailcaption,
            'showCropPage' => 0,
        );
        $applicationID = Input::get('applicationID', '0');
        $app = Application::find($applicationID);
        if (!$app) {
            return Redirect::to(__('route.home'));
        } else if ($app->ExpirationDate < date('Y-m-d')) {
            $data['appName'] = $app->Name;
            return View::make('pages.expiredpage', $data)
                ->nest('filterbar', 'sections.filterbar', $data);
        }

        $data['app'] = $app;
        return View::make('pages.' . Str::lower($this->table) . 'detail', $data)
            ->nest('filterbar', 'sections.filterbar', $data);
    }

    public function get_show($id)
    {
        $currentUser = Auth::User();
        $showCropPage = Cookie::get(SHOW_IMAGE_CROP, 0);
        Cookie::put(SHOW_IMAGE_CROP, 0);
        $row = Content::find($id);

        if (((int)$currentUser->UserTypeID == eUserTypes::Manager)) {
            $contentList = DB::table('Content')
                // ->where('ApplicationID', '=', $row->ApplicationID)
                ->where('ContentID', '<>', $id)
                // ->where('StatusID', '=', eStatus::Active)
                ->get(array('ContentID', 'Name', 'ApplicationID'));
        } else {
            //musteriler icin interactive oge kopyalamayi kapatiyorum.
//            $contentList = DB::table('Content')
//                ->where('ApplicationID', '=', $row->ApplicationID)
//                ->where('ContentID', '<>', $id)
//                ->where('StatusID', '=', eStatus::Active)
//                ->get(array('ContentID', 'Name', 'ApplicationID'));
            $contentList = array();
        }
        if ($row) {
            if (Common::CheckContentOwnership($id)) {
                $this->route = __('route.' . $this->page) . '?applicationID=' . $row->ApplicationID;


                $data = array(
                    'page' => $this->page,
                    'route' => $this->route,
                    'caption' => $this->caption,
                    'detailcaption' => $this->detailcaption,
                    'row' => $row,
                    'app' => $row->Application,
                    'showCropPage' => $showCropPage,
                    'contentList' => $contentList,
                );

                if (((int)$currentUser->UserTypeID == eUserTypes::Customer)) {
                    if ($row->Application->ExpirationDate < date('Y-m-d')) {
                        return View::make('pages.expiredpage', $data)->nest('filterbar', 'sections.filterbar', $data);
                    }
                }
                return View::make('pages.' . Str::lower($this->table) . 'detail', $data)
                    ->nest('filterbar', 'sections.filterbar', $data);
            } else {
                return Redirect::to($this->route);
            }
        } else {
            return Redirect::to($this->route);
        }
    }

    public function post_save()
    {
        set_time_limit(3000);
        $contentID = 0;
        $currentUser = Auth::User();

        $id = (int)Input::get($this->pk, '0');
        $applicationID = (int)Input::get('ApplicationID', '0');
        $chk = Common::CheckApplicationOwnership($applicationID);
        $rules = array(
            'ApplicationID' => 'required|integer|min:1',
            'Name' => 'required'
        );
        $v = Validator::make(Input::all(), $rules);
        if ($v->passes() && $chk) {
            if (!Common::AuthMaxPDF($applicationID)) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('error.auth_max_pdf'));
            }
            try {
                $content = Content::find($id);
                $selectedCategories = Input::get('chkCategoryID', array());

                if (!$content) {
                    $maxID = DB::table("Content")->where("ApplicationID", "=", $applicationID)->max('OrderNo');
                    $content = new Content();
                    $content->OrderNo = $maxID + 1;
                } else if (!Common::CheckContentOwnership($id)) {
                    throw new Exception("Unauthorized user attempt");
                }
                $content->ApplicationID = $applicationID;
                $content->Name = Input::get('Name');
                $content->Detail = Input::get('Detail');
                $content->MonthlyName = Input::get('MonthlyName');
                $content->PublishDate = date('Y-m-d', strtotime(Input::get('PublishDate', date('Y-m-d'))));
                $content->IsUnpublishActive = (int)Input::get('IsUnpublishActive');
                $content->UnpublishDate = date('Y-m-d', strtotime(Input::get('UnpublishDate', date('Y-m-d'))));
                $content->IsProtected = (int)Input::get('IsProtected');
                $content->IsBuyable = (int)Input::get('IsBuyable');
                $content->CurrencyID = (int)Input::get('CurrencyID');
                $content->Orientation = (int)Input::get('Orientation');
                $content->setPassword(Input::get('Password'));
                $content->setMaster((int)Input::get('IsMaster'));
                $content->AutoDownload = (int)Input::get('AutoDownload');
                $content->Status = (int)Input::get('Status');
                if ($content->Status == eStatus::Active) {
                    $content->RemoveFromMobile = eRemoveFromMobile::Passive;
                }

                if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
                    $content->Approval = (int)Input::get('Approval');
                    $content->Blocked = (int)Input::get('Blocked');
                }
                $content->ifModifiedDoNeccessarySettings($selectedCategories);
                $content->save();
                $content->setCategory($selectedCategories);

                $customerID = Application::find($applicationID)->CustomerID;
                $contentID = $content->ContentID;
                $contentFile = $content->processPdf($customerID);
                $content->processImage($customerID, $contentFile);
                ContentFile::makeContentInteractive($contentFile);
            } catch (Exception $e) {
                return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
            }
            $contentLink = $contentID > 0 ? "&contentID=" . base64_encode($contentID) : ("");
            return "success=" . base64_encode("true") . $contentLink;
        } else {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }
    }

    public function get_copy($id, $new)
    {
        try {
            // return Redirect::to(__('route.home'));
            $sourceContentID = $id;
            $contentFileControl = null;
            $newContentID = $new;

            $content = DB::table('Content')
                ->where('ContentID', '=', $sourceContentID)
                ->first();

            if ($new == "new") {

                $c = new Content();
                $c->ApplicationID = $content->ApplicationID;
                $c->Name = $content->Name;
                $c->Detail = $content->Detail;
                $c->MonthlyName = $content->MonthlyName;
                $c->PublishDate = $content->PublishDate;
                $c->IsUnpublishActive = $content->IsUnpublishActive;
                $c->UnpublishDate = $content->UnpublishDate;
                $c->CategoryID = $content->CategoryID;
                $c->IsProtected = $content->IsProtected;
                $c->Password = $content->Password;
                $c->IsBuyable = $content->IsBuyable;
                $c->CurrencyID = $content->CurrencyID;
                $c->IsMaster = 2;
                $c->Orientation = $content->Orientation;
                $c->AutoDownload = $content->AutoDownload;
                $c->Approval = $content->Approval;
                $c->Blocked = $content->Blocked;
                $c->Status = $content->Status;
                $c->Version = $content->Version;
                $c->PdfVersion = $content->PdfVersion;
                $c->CoverImageVersion = $content->CoverImageVersion;
                $c->TotalFileSize = $content->TotalFileSize;
                $c->StatusID = eStatus::Active;
                $c->CreatorUserID = $content->CreatorUserID;
                $c->DateCreated = new DateTime();
                $c->ProcessUserID = $content->ProcessUserID;
                $c->ProcessDate = new DateTime();
                $c->ProcessTypeID = eProcessTypes::Insert;
                $c->OrderNo = $content->OrderNo;
                $c->save();
                $newContentID = $c->ContentID;

                $contentCategory = DB::table('ContentCategory')
                    ->where('ContentID', '=', $sourceContentID)
                    ->get();

                foreach ($contentCategory as $cCategory) {
                    $cc = new ContentCategory();
                    $cc->ContentID = $newContentID;
                    $cc->CategoryID = $cCategory->CategoryID;
                    $cc->save();
                }


                /* yeni icerigin kopyalanmasi(new) */
                $c = DB::table('Content')
                    ->where('ContentID', '=', $newContentID)
                    ->first();
                $customerID = Application::find($c->ApplicationID)->CustomerID;
                $contentFile = DB::table('ContentFile')
                    ->where('ContentID', '=', $sourceContentID)
                    ->first();


                $targetFilePath = 'public/' . $contentFile->FilePath . '/' . $contentFile->FileName;

                $destinationFolder = 'public/files/customer_' . $customerID . '/application_' . $c->ApplicationID . '/content_' . $c->ContentID;

                File::mkdir($destinationFolder);
                File::copy($targetFilePath, $destinationFolder . '/' . $contentFile->FileName);
                // Log::info($targetFilePath."|||".$destinationFolder.'/'.$contentFile->FileName);

                $cf = new ContentFile();
                $cf->ContentID = $c->ContentID;
                $cf->DateAdded = $contentFile->DateAdded;
                $cf->FilePath = 'files/customer_' . $customerID . '/application_' . $c->ApplicationID . '/content_' . $c->ContentID;
                $cf->FileName = $contentFile->FileName;
                $cf->FileSize = $contentFile->FileSize;
                $cf->Transferred = $contentFile->Transferred;
                $cf->Interactivity = 0;
                $cf->HasCreated = 0;
                //$cf->InteractiveFilePath = 'files/customer_' . $customerID . '/application_' . $c->ApplicationID . '/content_' . $c->ContentID;
                $cf->InteractiveFileName = $contentFile->InteractiveFileName;
                $cf->InteractiveFileSize = $contentFile->InteractiveFileSize;
                $cf->Included = $contentFile->Included;
                $cf->StatusID = $contentFile->StatusID;
                $cf->CreatorUserID = $contentFile->CreatorUserID;
                $cf->DateCreated = new DateTime();
                $cf->ProcessUserID = $content->ProcessUserID;
                $cf->ProcessDate = new DateTime();
                $cf->ProcessTypeID = eProcessTypes::Insert;
                $cf->save();

                $contentCoverImageFile = DB::table('ContentCoverImageFile')
                    ->where('ContentFileID', '=', $contentFile->ContentFileID)
                    ->first();


                $ccif = new ContentCoverImageFile();
                $ccif->ContentFileID = $cf->ContentFileID;
                $ccif->DateAdded = $contentCoverImageFile->DateAdded;
                $ccif->FilePath = $contentCoverImageFile->FilePath;
                $ccif->SourceFileName = $contentCoverImageFile->SourceFileName;
                $ccif->FileName = $contentCoverImageFile->FileName;
                $ccif->FileName2 = $contentCoverImageFile->FileName2;
                $ccif->FileSize = $contentCoverImageFile->FileSize;
                $ccif->StatusID = $contentCoverImageFile->StatusID;
                $ccif->CreatorUserID = $contentCoverImageFile->CreatorUserID;
                $ccif->DateCreated = new DateTime();
                $ccif->ProcessUserID = $contentCoverImageFile->ProcessUserID;
                $ccif->ProcessDate = new DateTime();
                $ccif->ProcessTypeID = eProcessTypes::Insert;
                $ccif->save();


                $files = glob('public/' . $contentFile->FilePath . '/*.{jpg}', GLOB_BRACE);
                foreach ($files as $file) {
                    // echo nl2br($targetFilePath."\n");
                    File::copy('public/' . $contentFile->FilePath . '/' . basename($file), $destinationFolder . '/' . basename($file));
                }

                $this->get_copyContent($destinationFolder, $sourceContentID, $c->ContentID, $cf->ContentFileID);
            }

            $contentFileControl = DB::table('ContentFile')
                ->where('ContentID', '=', $newContentID)
                ->order_by('ContentFileID', 'DESC')
                ->first();

            $contentFilePageControl = DB::table('ContentFilePage')
                ->where('ContentFileID', '=', $contentFileControl->ContentFileID)
                ->get();

            if (sizeof($contentFilePageControl) == 0) {/* sayfalari olusmamis */
                Controller::call('interactivity@show', array($contentFileControl->ContentFileID));
                $this->get_copyContent("null", $sourceContentID, $newContentID, $contentFileControl->ContentFileID);
            } elseif ($new != "new") {/* sayfalari olusmus */
                // Controller::call('interactivity@show', array($contentFileControl->ContentFileID));
                $this->get_copyContent("null", $sourceContentID, $newContentID, $contentFileControl->ContentFileID);
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
    }

    /**
     * @param $destinationFolder
     * @param $sourceContentID
     * @param $targetContentID
     * @param $targetContentFileID
     * @return string|void
     */
    public function get_copyContent($destinationFolder, $sourceContentID, $targetContentID, $targetContentFileID)
    {
        // /***** HEDEF CONTENTIN SAYFALARI OLUSUTURLMUS OLMALI YANI INTERAKTIF TASARLAYICISI ACILMIS OLMALI!!!*****/
        // TAŞINACAK CONTENT'IN FILE ID'SI
        try {
            $contentFile = DB::table('ContentFile')
                ->where('ContentID', '=', $sourceContentID)
                ->order_by('ContentFileID', 'DESC')
                ->first();

            $contentFilePage = DB::table('ContentFilePage')
                ->where('ContentFileID', '=', $contentFile->ContentFileID)
                ->get();

            if (sizeof($contentFilePage) == 0) {
                return;
            } else {

                $contentFilePageNewCount = DB::table('ContentFilePage')
                    ->where('ContentFileID', '=', $targetContentFileID)//****************
                    ->count();

                $targetApplicationID = DB::table('Content')
                    ->where('ContentID', '=', $targetContentID)//****************
                    ->first();

                $targetCustomerID = DB::table('Application')
                    ->where('ApplicationID', '=', $targetApplicationID->ApplicationID)//****************
                    ->first();

                if ($destinationFolder != "null") { /* kopyalanacak icerigin sayfalari yok ise olusturur */
                    foreach ($contentFilePage as $ocfp) {
                        $ncfp = new ContentFilePage();
                        $ncfp->ContentFileID = (int)$targetContentFileID;
                        $ncfp->No = (int)$ocfp->No;
                        $ncfp->Width = (int)$ocfp->Width;
                        $ncfp->Height = (int)$ocfp->Height;
                        $ncfp->FilePath = (string)'files/customer_' . $targetCustomerID->CustomerID . '/application_' . $targetApplicationID->ApplicationID . '/content_' . $targetContentID . '/file_' . $targetContentFileID;
                        $ncfp->FileName = (string)$ocfp->FileName;
                        $ncfp->FileName2 = (string)$ocfp->FileName2;
                        $ncfp->FileSize = (int)$ocfp->FileSize;
                        $ncfp->StatusID = (int)$ocfp->StatusID;
                        $ncfp->CreatorUserID = (int)$ocfp->CreatorUserID;
                        $ncfp->DateCreated = new DateTime();
                        $ncfp->ProcessUserID = $ocfp->CreatorUserID;
                        $ncfp->ProcessDate = new DateTime();
                        $ncfp->ProcessTypeID = (int)eProcessTypes::Insert;
                        $ncfp->save();
                    }
                    if (!File::exists($destinationFolder . '/file_' . $targetContentFileID)) {
                        File::mkdir($destinationFolder . '/file_' . $targetContentFileID);
                    }

                    $files = glob('public/' . $contentFile->FilePath . '/file_' . $contentFile->ContentFileID . '/*.{jpg,pdf}', GLOB_BRACE);
                    foreach ($files as $file) {
                        File::copy('public/' . $contentFile->FilePath . '/file_' . $contentFile->ContentFileID . '/' . basename($file), $destinationFolder . '/file_' . $targetContentFileID . '/' . basename($file));
                    }
                }

                foreach ($contentFilePage as $cfp) {


                    $filePageComponent = DB::table('PageComponent')
                        ->where('ContentFilePageID', '=', $cfp->ContentFilePageID)
                        ->get();

                    if (sizeof($filePageComponent) == 0) {
                        continue;
                    }

                    //HANGI CONTENT'E TASINACAKSA O CONTENT'IN FILE ID'SI
                    $contentFilePageNew = DB::table('ContentFilePage')
                        ->where('ContentFileID', '=', $targetContentFileID)//****************
                        ->where('No', '=', $cfp->No)
                        ->first();

                    // var_dump(isset($contentFilePageNew));
                    if (isset($contentFilePageNew)) {
                        // Log::info("girdiiii");
                        foreach ($filePageComponent as $fpc) {
                            $s = new PageComponent();
                            $s->ContentFilePageID = $contentFilePageNew->ContentFilePageID;
                            $s->ComponentID = $fpc->ComponentID;
                            if ($destinationFolder == "null") {
                                $lastComponentNo = DB::table('PageComponent')
                                    ->where('ContentFilePageID', '=', $contentFilePageNew->ContentFilePageID)
                                    ->order_by('No', 'DESC')
                                    ->take(1)
                                    ->only('No');
                                if ($lastComponentNo == null) {
                                    $lastComponentNo = 0;
                                }
                                $s->No = $lastComponentNo + 1;
                            } else {
                                $s->No = $fpc->No;
                            }
                            // Log::info(serialize($ids));
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
                                if ($fpcp->Value > $contentFilePageNewCount && $fpcp->Name == "page") {
                                    $p->Value = 1;
                                } elseif ($fpcp->Name == "filename") {
                                    $targetPath = 'files/customer_' . $targetCustomerID->CustomerID . '/application_' . $targetApplicationID->ApplicationID . '/content_' . $targetContentID . '/file_' . $targetContentFileID . '/output/comp_' . $s->PageComponentID;
                                    $targetPathFull = path('public') . $targetPath;
                                    $p->Value = $targetPath . '/' . basename($fpcp->Value);
                                    if (!File::exists($targetPathFull)) {
                                        File::mkdir($targetPathFull);
                                    }
                                    $files = glob('public/' . dirname($fpcp->Value) . '/*.{jpg,JPG,png,PNG,tif,TIF,mp3,MP3,m4v,M4V,mp4,MP4,mov,MOV}', GLOB_BRACE);
                                    // Log::info('public/'.dirname($fpcp->Value));
                                    foreach ($files as $file) {
                                        File::copy($file, $targetPathFull . '/' . basename($file));
                                    }
                                } else {
                                    $p->Value = $fpcp->Value;
                                }
                                $p->StatusID = eStatus::Active;
                                $p->DateCreated = new DateTime();
                                $p->ProcessDate = new DateTime();
                                $p->ProcessTypeID = eProcessTypes::Insert;
                                $p->save();
                            }
                        }
                    }
                }
            }

            $targetHasCreated = ContentFile::find($targetContentFileID);
            if ($targetHasCreated) {
                $targetHasCreated->Interactivity = 1;
                $targetHasCreated->HasCreated = 0;
                $targetHasCreated->save();
            }

            interactivityQueue::trigger();

            return "success=" . base64_encode("true");
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
    }

    public function post_delete()
    {
        $id = (int)Input::get($this->pk, '0');
        $chk = Common::CheckContentOwnership($id);
        if (!$chk) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        try {
            DB::transaction(function () use ($id) {
                $s = Content::find($id);
                if ($s) {
                    $s->StatusID = eStatus::Deleted;
                    $s->ProcessUserID = Auth::User()->UserID;
                    $s->ProcessDate = new DateTime();
                    $s->ProcessTypeID = eProcessTypes::Update;
                    $s->save();
                }
            });
            return "success=" . base64_encode("true");
        } catch (Exception $e) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
    }

    public function post_uploadfile()
    {
        ob_start();
        $element = Input::get('element');
        $options = array(
            'upload_dir' => path('public') . 'files/temp/',
            'upload_url' => URL::base() . '/files/temp/',
            'param_name' => $element,
            'accept_file_types' => '/\.(pdf)$/i'
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
        $ret = Uploader::ContentsUploadFile($tempFile);
        return Response::json($ret);
    }

    public function post_uploadcoverimage()
    {
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


    public function post_order($applicationID)
    {
        $chk = Common::CheckApplicationOwnership($applicationID);
        if (!$chk) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }
        $maxID = DB::table("Content")->where("ApplicationID", "=", $applicationID)->max('OrderNo');
        $contentIDDescSet = Input::get("contentIDSet", array());
        $i = $maxID + 1;
        $contentIDSet = array_reverse($contentIDDescSet);
        foreach ($contentIDSet as $contentID) {
            $content = Content::where("ApplicationID", "=", $applicationID)->find($contentID);
            if ($content) {
                $content->OrderNo = $i++;
                $content->save(FALSE);
                //appversionu altte tek bir kere artiracagim icin burada artirmiyorum.
            }
        }

        $application = Application::find($applicationID);
        if ($application) {
            $application->incrementAppVersion();
        }
        return "success=" . base64_encode("true");
    }

    /**
     * Contenti yayindan kaldirip mobilden de kaldirilma flagini 1 yapar
     * @param int $contentID
     * @return string
     */
    public function get_remove_from_mobile($contentID)
    {
        $chk = Common::CheckContentOwnership($contentID);
        if (!$chk) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode(__('common.detailpage_validation'));
        }

        try {
            DB::transaction(function () use ($contentID) {
                $s = Content::find($contentID);
                if ($s) {
                    $s->Status = eStatus::Passive;
                    $s->RemoveFromMobile = eRemoveFromMobile::Active;
                    $s->save();
                }
            });
            return "success=" . base64_encode("true");
        } catch (Exception $e) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($e->getMessage());
        }
    }

    public function post_refresh_identifier()
    {
        $rules = array(
            "ContentID" => "required|numeric|min:1",
        );
        $v = Validator::make(Input::all(), $rules);
        if (!$v->passes()) {
            return "success=" . base64_encode("false") . "&errmsg=" . base64_encode($v->errors->first());
//	    ajaxResponse::error($v->errors->first());
        }

        $content = Content::find(Input::get("ContentID"));
        $subscriptionIdentifier = $content->getIdentifier(TRUE);
        $content->save();
        return "success=" . base64_encode("true") . "&SubscriptionIdentifier=" . base64_encode($subscriptionIdentifier);
    }

}
