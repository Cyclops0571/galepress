<?php

/**
 * @property int $ContentID Description
 * @property int $ApplicationID Description
 * @property int $OrderNo Description
 * @property int $Name Description
 * @property int $Detail Description
 * @property int $MonthlyName Description
 * @property int $PublishDate Description
 * @property int $UnpublishDate Description
 * @property int $IsUnpublishActive Description
 * @property int $CategoryID Description
 * @property int $IsProtected Description
 * @property int $Password Description
 * @property int $IsBuyable Description
 * @property int $Price Description
 * @property int $CurrencyID Description
 * @property int $IsMaster Description
 * @property int $Orientation Description
 * @property int $Identifier Description
 * @property int $AutoDownload Description
 * @property int $Approval Description
 * @property int $Blocked Description
 * @property int $Status Description
 * @property int $RemoveFromMobile Description
 * @property int $Version Description
 * @property int $PdfVersion Description
 * @property int $CoverImageVersion Description
 * @property int $TotalFileSize Description
 * @property int $TopicStatus Description
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 * @property Application $Application Description
 * @property ContentTopic[] $ContentTopics Description
 * @property ContentFile $ContentFile Description
 */
class Content extends Eloquent
{

    public static $timestamps = false;
    public static $table = 'Content';
    public static $key = 'ContentID';

    /*
      public function Application()
      {
      return $this->belongs_to('Application', 'ApplicationID');
      }

      public function Category()
      {
      return $this->belongs_to('Category', 'CategoryID');
      }
     */

    public function Currency($languageID)
    {
        //return $this->belongs_to('GroupCode', 'GroupCodeID')->first();
        $gc = GroupCode::where('GroupCodeID', '=', $this->CurrencyID)->first();
        if ($gc) {
            return $gc->DisplayName($languageID);
        }
        return '';
    }

    public function Files($statusID)
    {
        return $this->has_many('ContentFile', $this->key())->where('StatusID', '=', $statusID)->get();
    }

    public function ActiveFile()
    {
        return $this->has_many('ContentFile', $this->key())->where('StatusID', '=', eStatus::Active)->first();
    }

    public function CoverImageFiles($statusID)
    {
        return $this->has_many('ContentCoverImageFile', $this->key())->where('StatusID', '=', $statusID)->get();
    }

    public function Tags()
    {
        return $this->has_many('ContentTag', $this->key());
    }

    public function ifModifiedDoNeccessarySettings($selectedCategories)
    {
        $currentCategories = array();
        $rows = $this->getCategoryIDSet();
        foreach ($rows as $row) {
            $categoryIDArray = array($row->CategoryID != CATEGORY_GENEL_ID ? $row->CategoryID : "");
            $currentCategories = array_merge($currentCategories, $categoryIDArray);
        }

        $pdfUploaded = (int)Input::get('hdnFileSelected', 0);
        $imageUploaded = (int)Input::get('hdnCoverImageFileSelected', 0);
        if ($this->dirty() || $pdfUploaded || $imageUploaded || $currentCategories != $selectedCategories) {
            $this->Version = (int)$this->Version + 1;
        }
    }

    public function getCategoryIDSet()
    {
        return DB::table('ContentCategory')
            ->where('ContentID', '=', $this->ContentID)
            ->get();
    }

    public function setPassword($password)
    {
        if (strlen(trim($password)) > 0) {
            $this->Password = Hash::make(Input::get('Password'));
        }
    }

    public function setMaster($isMaster)
    {
        $this->IsMaster = $isMaster;
        if ($isMaster) {
            //Unset IsProtected & password field due to https://github.com/galepress/gp/issues/7
            $this->IsProtected = 0;
            $this->Password = '';
            $contents = DB::table('Content')->where('ApplicationID', '=', $this->ApplicationID)->get();
            foreach ($contents as $content) {
                //INFO:Added due to https://github.com/galepress/gp/issues/18
                if ((int)$this->ContentID !== (int)$content->ContentID) {
                    $a = Content::find($content->ContentID);
                    $a->IsMaster = 0;
                    $a->Version = (int)$a->Version + 1;
                    $a->ProcessUserID = Auth::user()->UserID;
                    $a->ProcessDate = new DateTime();
                    $a->ProcessTypeID = eProcessTypes::Update;
                    $a->save();
                }
            }
        }
    }

    /**
     *
     * @param int $contentID
     * @param array $columns
     * @return Content
     */
    public static function find($contentID, $columns = array('*'))
    {
        return Content::where(self::$key, "=", $contentID)->first($columns);
    }

    public function save($updateAppVersion = TRUE)
    {
        if (!$this->dirty()) {
            return true;
        }
        $userID = -1;
        if (Auth::user()) {
            $userID = Auth::user()->UserID;
        }

        if ((int)$this->ContentID == 0) {
            $this->DateCreated = new DateTime();
            $this->ProcessTypeID = eProcessTypes::Insert;
            $this->CreatorUserID = $userID;
            $this->StatusID = eStatus::Active;
            $this->PdfVersion = 1;
            $this->CoverImageVersion = 1;
        } else {
            $this->ProcessTypeID = eProcessTypes::Update;
        }

        $this->ProcessUserID = $userID;
        $this->Version = (int)$this->Version + 1;
        $this->ProcessDate = new DateTime();
        if ($updateAppVersion) {
            $contentApp = Application::find($this->ApplicationID);
            if ($contentApp) {
                $contentApp->incrementAppVersion();
            }
        }
        parent::save();
    }

    public function setCategory($selectedCategories)
    {
        //content categories
        DB::table('ContentCategory')->where('ContentID', '=', $this->ContentID)->delete();
        foreach ($selectedCategories as $value) {
            //add category
            $cat = new ContentCategory();
            $cat->ContentID = $this->ContentID;
            $cat->CategoryID = (int)$value;
            $cat->save();
        }
    }

    /**
     * @param int $customerID
     * @return ContentFile|int|null
     */
    public function processPdf()
    {
        if ((int)Input::get('hdnFileSelected', 0) != 1) {
            return ContentFile::where('ContentID', '=', $this->ContentID)
                ->where('StatusID', '=', eStatus::Active)
                ->order_by('ContentFileID', 'DESC')
                ->first();
        }

        $ContentFile = null;
        $sourceFileName = Input::get('hdnFileName');
        $sourceFilePath = 'files/temp';
        $sourceRealPath = path('public') . $sourceFilePath;
        $sourceFileNameFull = $sourceRealPath . '/' . $sourceFileName;

        $targetFileName = Auth::user()->UserID . '_' . date("YmdHis") . '_' . $sourceFileName;
        $targetFilePath = 'files/customer_' . $this->Application->CustomerID . '/application_' . $this->ApplicationID . '/content_' . $this->ContentID;
        $destinationFolder = path('public') . $targetFilePath;
        $targetFileNameFull = $destinationFolder . '/' . $targetFileName;

        if (File::exists($sourceFileNameFull)) {
            if (!File::exists($destinationFolder)) {
                File::mkdir($destinationFolder);
            }

            $this->PdfVersion += 1;
            $this->save();

            $originalImageFileName = pathinfo($sourceFileNameFull, PATHINFO_FILENAME) . IMAGE_ORJ_EXTENSION;
            File::move($sourceFileNameFull, $targetFileNameFull);
            if (File::exists($sourceRealPath . "/" . $originalImageFileName)) {
                File::move($sourceRealPath . "/" . $originalImageFileName, $destinationFolder . "/" . IMAGE_ORIGINAL . IMAGE_EXTENSION);
            }


            $ContentFile = new ContentFile();
            $ContentFile->ContentID = $this->ContentID;
            $ContentFile->DateAdded = new DateTime();
            $ContentFile->FilePath = $targetFilePath;
            $ContentFile->FileName = $targetFileName;
            $ContentFile->FileSize = File::size($targetFileNameFull);
            $ContentFile->Transferred = (int)Input::get('Transferred', '0');
            $ContentFile->StatusID = eStatus::Active;
            $ContentFile->CreatorUserID = Auth::user()->UserID;
            $ContentFile->DateCreated = new DateTime();
            $ContentFile->ProcessUserID = Auth::user()->UserID;
            $ContentFile->ProcessDate = new DateTime();
            $ContentFile->ProcessTypeID = eProcessTypes::Insert;
            $ContentFile->save();
        }

        return $ContentFile;
    }

    /**
     * @desc Calls an outer service for indexing pdfs
     * @param ContentFile $contentFile
     */
    public function callIndexingService(ContentFile $contentFile)
    {
        //http://37.9.205.205/indexing?path=customer_127/application_135/content_5207/file_6688/file.pdf'

        $contentFile->Indexed = 0;
        $pdfPath = 'customer_' . $this->Application->CustomerID . '/application_' . $this->ApplicationID . '/content_' . $this->ContentID . '/file_' . $contentFile->ContentFileID . '/file.pdf';
        $requestUrl = 'http://37.9.205.205/indexing?path=' . $pdfPath;
        @$ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (!empty($result)) {
            $resultJson = json_decode($result, true);
            if (isset($resultJson['status']) && $resultJson['status'] == 1) {
                $contentFile->Indexed = 1;
            }
        }

        if ($contentFile->Indexed == 0) {
            $error = new ServerErrorLog();
            $error->ErrorMessage = "Indexing error - ContentFileID: " . $contentFile->ContentFileID . " -  response: " . json_encode($result);
            $error->Parameters = $requestUrl;
            $error->save();
        }
        $contentFile->save();
    }

    /**
     * @param int $customerID
     * @param ContentFile $contentFile
     * @param int $coverImageFileSelected
     * @param string $coverImageFileName
     * @throws Exception
     */
    public function processImage($contentFile, $coverImageFileSelected, $coverImageFileName)
    {

        if (!$contentFile) {
            return;
        }

        if ($coverImageFileSelected != 1) {
            return;
        }

        $sourceFileName = $coverImageFileName;
        $sourceFilePath = 'files/temp';
        $sourceRealPath = path('public') . $sourceFilePath;
        $sourceFileNameFull = $sourceRealPath . '/' . $sourceFileName;

        $targetFileName = Auth::user()->UserID . '_' . date("YmdHis") . '_' . $sourceFileName;
        $targetFilePath = 'files/customer_' . $this->Application->CustomerID . '/application_' . $this->ApplicationID . '/content_' . $this->ContentID;
        $destinationFolder = path('public') . $targetFilePath;
        $targetFileNameFull = $destinationFolder . '/' . $targetFileName;

        $targetMainFileName = $targetFileName . '_main';
        $targetThumbFileName = $targetFileName . '_thumb';

        if (File::exists($sourceFileNameFull) && is_file($sourceFileNameFull)) {
            if (!File::exists($destinationFolder)) {
                File::mkdir($destinationFolder);
            }


            //<editor-fold desc="Delete Old Images">
            foreach (scandir($destinationFolder . "/") as $fileName) {
                if (substr($fileName, 0, strlen(IMAGE_CROPPED_NAME)) === IMAGE_CROPPED_NAME) {
                    unlink($destinationFolder . "/" . $fileName);
                }
            }
            //</editor-fold>

            File::move($sourceFileNameFull, $targetFileNameFull);
            if ((int)Input::get('hdnFileSelected', 0) == 0) {
                sleep(1);
                File::copy($targetFileNameFull, $destinationFolder . '/' . IMAGE_ORIGINAL . IMAGE_EXTENSION);
            }
            $pictureInfoSet = array();
            $pictureInfoSet[] = array("width" => 110, "height" => 157, "imageName" => $targetMainFileName);
            $pictureInfoSet[] = array("width" => 468, "height" => 667, "imageName" => $targetThumbFileName);
            foreach ($pictureInfoSet as $pInfo) {
                ImageClass::cropImage($targetFileNameFull, $destinationFolder, $pInfo["width"], $pInfo["height"], $pInfo["imageName"], FALSE);
            }

            /** @var Crop[] $cropSet */
            $cropSet = Crop::get();
            $sourceFile = $destinationFolder . "/" . IMAGE_ORIGINAL . IMAGE_EXTENSION;
            foreach ($cropSet as $crop) {
                //create neccessary image versions
                ImageClass::cropImage($sourceFile, $destinationFolder, $crop->Width, $crop->Height);
            }

            $this->CoverImageVersion += 1;
            $this->save();

            $c = new ContentCoverImageFile();
            $c->ContentFileID = $contentFile->ContentFileID;
            $c->DateAdded = new DateTime();
            $c->FilePath = $targetFilePath;
            $c->SourceFileName = $targetFileName;
            $c->FileName = $targetMainFileName . IMAGE_EXTENSION;
            $c->FileName2 = $targetThumbFileName . IMAGE_EXTENSION;
            $c->FileSize = File::size($destinationFolder . "/" . $targetMainFileName . ".jpg");
            $c->StatusID = eStatus::Active;
            $c->CreatorUserID = Auth::user()->UserID;
            $c->DateCreated = new DateTime();
            $c->ProcessUserID = Auth::user()->UserID;
            $c->ProcessDate = new DateTime();
            $c->ProcessTypeID = eProcessTypes::Insert;
            $c->save();
            Cookie::put(SHOW_IMAGE_CROP, SHOW_IMAGE_CROP);
        }
    }

    public function getIdentifier($refreshIdentifier = false)
    {
        if (!$this->ContentID) {
            return $this->Identifier;
        }
        if (empty($this->Identifier) || $refreshIdentifier) {
            if (empty($this->Application->BundleText)) {
                $identifier = "www.galepress.com." . $this->ContentID . "t" . time();
            } else {
                $identifier = strtolower($this->Application->BundleText) . "." . $this->ContentID . "t" . time();
            }
            if (empty($this->Identifier)) {
                $this->Identifier = $identifier;
                $this->save();
            } else {
                $this->Identifier = $identifier;
            }
        }
        return $this->Identifier;
    }

    /**
     *
     * @return Application
     */
    public function Application()
    {
        return $this->belongs_to('Application', 'ApplicationID');
    }

    /**
     * @desc Returns content categories for webservice
     * @param int $ServiceVersion
     * @return array
     */
    public function WebserviceCategories($ServiceVersion)
    {
        $categories = array();
        $sql = '' .
            'SELECT ct.CategoryID, ct.Name ' .
            'FROM `ContentCategory` cc ' .
            'LEFT OUTER JOIN `Category` ct ON cc.`CategoryID` = ct.`CategoryID` AND ct.`StatusID` = 1 ' .
            'WHERE cc.`ContentID`=' . (int)$this->ContentID . ' ' .
            'ORDER BY ct.`Name` ASC';
        $rs = DB::query($sql);
        foreach ($rs as $r) {
            array_push($categories, array(
                'CategoryID' => (int)$r->CategoryID,
                'CategoryName' => ((int)$r->CategoryID === 0 ? (string)Lang::line('common.contents_category_list_general', array(), $this->Application->ApplicationLanguage) : $r->Name)
            ));
        }
        return $categories;
    }

    public function ContentTopics()
    {
        return $this->has_many('ContentTopic', 'ContentID');
    }

    /**
     * @desc Saves Topic - Content relations to ContentTopic table
     * @param array $topicIds
     */
    public function setTopics($topicIds)
    {
        if ($this->TopicStatus != eStatus::Active) {
            return;
        }

        if (empty($topicIds)) {
            foreach ($this->ContentTopics as $contentTopic) {
                $contentTopic->delete();
            }
            return;
        }
        $myTopicIds = array();
        foreach ($this->ContentTopics as $contentTopic) {
            $myTopicIds[] = $contentTopic->TopicID;
        }


        foreach ($topicIds as $topicId) {
            foreach ($this->ContentTopics as $contentTopic) {
                if (!in_array($contentTopic->TopicID, $topicIds)) {
                    $contentTopic->delete();
                }
            }
            if (!in_array($topicId, $myTopicIds)) {
                $contentTopic = new ContentTopic();
                $contentTopic->ContentID = $this->ContentID;
                $contentTopic->TopicID = $topicId;
                $contentTopic->save();
            }
        }
    }

    public function ContentFile()
    {
        return $this->has_one('ContentFile', 'ContentID')
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('ContentFileID', 'DESC')->take(1);
    }


    public function serveContent()
    {
        $serveContent = $this->PublishDate <= date("Y-m-d H:i:s");
        $serveContent = $serveContent && ($this->IsUnpublishActive == 0 || $this->UnpublishDate > date("Y-m-d"));
        $serveContent = $serveContent || ($this->RemoveFromMobile == eRemoveFromMobile::Active);
        return $serveContent;
    }

    public function getServiceData($addStatusCode = true)
    {
        $result = array(
            'ContentID' => (int)$this->ContentID,
            'ApplicationID' => (int)$this->ApplicationID,
            'ContentOrderNo' => (int)$this->OrderNo,
            'ContentName' => $this->Name,
            'ContentDetail' => $this->Detail,
            'ContentMonthlyName' => $this->MonthlyName,
            'ContentIsProtected' => ((int)$this->IsProtected == 1 ? true : false),
            'ContentIsBuyable' => ((int)$this->IsBuyable == 1 ? true : false),
            'ContentPrice' => '',
            'ContentCurrency' => $this->Currency(1),
            'ContentIdentifier' => $this->getIdentifier(),
            'ContentIsMaster' => ((int)$this->IsMaster == 1 ? true : false),
            'ContentOrientation' => (int)$this->Orientation,
            'ContentAutoDownload' => ((int)$this->AutoDownload == 1 ? true : false),
            'ContentBlocked' => (bool)$this->Blocked,
            'ContentStatus' => (bool)$this->Status,
            'ContentVersion' => (int)$this->Version,
            'ContentPdfVersion' => (int)$this->PdfVersion,
            'ContentCoverImageVersion' => (int)$this->CoverImageVersion,
            'RemoveFromMobile' => (bool)$this->RemoveFromMobile
        );
        if($addStatusCode) {
            $status = array();
            $status["status"] = 0;
            $status["error"] = "";
            $result = array_merge($result, $status);
        }
        return $result;
    }

    public function getServiceDataDetailed($serviceVersion)
    {
        return array_merge($this->getServiceData(), array('ContentCategories' => $this->WebserviceCategories($serviceVersion)));
    }
}

