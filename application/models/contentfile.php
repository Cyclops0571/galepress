<?php

/**
 * @method static \ContentFile find(int $ID)
 * @property int $ContentFileID Description
 * @property int $ContentID Description
 * @property int $DateAdded Description
 * @property int $FilePath Description
 * @property int $FileName Description
 * @property int $FileName2 Description
 * @property int $FileSize Description
 * @property int $PageCreateProgress Description
 * @property int $Transferred Description
 * @property int $Interactivity Description
 * @property int $HasCreated Description
 * @property int $ErrorCount Description
 * @property int $LastErrorDetail Description
 * @property int $InteractiveFilePath Description
 * @property int $InteractiveFileName Description
 * @property int $InteractiveFileName2 Description
 * @property int $InteractiveFileSize Description
 * @property int $Included Description
 * @property int $StatusID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 * @property int $CreatorUserID
 * @property ContentFilePage[] $ContentFilePage
 */
class ContentFile extends Eloquent
{
    const ContentFileInUse = 1;
    const ContentFileAvailable = 0;
    public static $timestamps = false;
    public static $table = 'ContentFile';
    public static $key = 'ContentFileID';
    private static $_bookmarkAdded = false;
    private $_pfdName = '';
    /*
      public function Content()
      {
      return $this->belongs_to('Content', 'ContentID');
      }
     */

    /**
     *
     * @param ContentFile $cf
     * @return string
     */
    public static function createPdfPages(&$cf)
    {
        if (!$cf) {
            return;
        }

        $expMessage = '';
        if (count($cf->ContentFilePage) > 0) {
            //contentFile coktan interactif yapilmis bisey yapmadan donelim.
            return '';
        }

        $cf->PageCreateProgress = ContentFile::ContentFileInUse;
        $cf->save();


        //create folder if doesnt exist
        if (!File::exists($cf->pdfFolderPathAbsolute())) {
            File::mkdir($cf->pdfFolderPathAbsolute());
        }

        try {
            $targetFileNameFull = path('public') . $cf->FilePath . '/' . $cf->FileName;
            //extract zip file
            $zip = new ZipArchive();
            $res = $zip->open($targetFileNameFull);
            if ($res === true) {
                $zip->extractTo($cf->pdfFolderPathAbsolute());
                $zip->close();
            }
            $pdfFileNameFull = $cf->pdfFolderPathAbsolute() . '/' . $cf->getPdfName();

            $myPcos = new MyPcos($pdfFileNameFull);
            $cf->createPdfSnapShots();
            $myPcos->checkPageSnapshots();
            for ($i = 0; $i < $myPcos->pageCount(); $i++) {
                $cfp = new ContentFilePage();
                $cfp->ContentFileID = $cf->ContentFileID;
                $cfp->No = $i + 1;
                $cfp->Width = $myPcos->width($i);
                $cfp->Height = $myPcos->height($i);
                $cfp->FilePath = $cf->pdfFolderPathRelative();
                $cfp->FileName = $myPcos->getImageFileName($i);
                $cfp->FileSize = File::size($cf->pdfFolderPathAbsolute() . '/' . $cfp->FileName);
                $cfp->save();
                if ($cf->Transferred != 1) {
                    $myPcos->arrangeBookmarkNew($cfp);
                    $myPcos->arrangeAnnotationNew($cfp, $i);
                }

            }
            $cf = ContentFile::find($cf->ContentFileID);
            $cf->comparePages();
            $myPcos->closePdf();
        } catch (PDFlibException $e) {
            $expMessage = "PDFlib exception occurred in :<br/>" .
                "File:" . $e->getFile() . "<br/>" .
                "Line:" . $e->getLine() . "<br/>" .
                "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " . $e->get_errmsg();
        } catch (Exception $e) {
            $expMessage = "File:" . $e->getFile() . "\r\n";
            $expMessage .= "Line:" . $e->getLine() . "\r\n";
            $expMessage .= "Message:" . $e->getMessage() . "\r\n";
        }
//        $cf->PageCreateProgress  = ContentFile::ContentFileAvailable;
//        $cf->save();
        return $expMessage;
    }

    public function save($closing = false)
    {
        if ($closing) {
            $this->Included = 1;
            $this->Interactivity = Interactivity::ProcessQueued;
            $this->HasCreated = 0;
            $this->ErrorCount = 0;
            $this->InteractiveFilePath = '';
            $this->InteractiveFileName = '';
            $this->InteractiveFileName2 = '';
            $this->InteractiveFileSize = 0;
        }

        if (!$this->dirty()) {
            return true;
        }
        $userID = -1;
        if (Auth::User()) {
            $userID = Auth::User()->UserID;
        }

        if ((int)$this->ContentFileID == 0) {
            $this->DateCreated = new DateTime();
            $this->CreatorUserID = $userID;
            $this->StatusID = eStatus::Active;
            $this->ProcessTypeID = eProcessTypes::Insert;
        } else {
            $this->ProcessTypeID = eProcessTypes::Update;
        }

        $this->ProcessUserID = $userID;
        $this->ProcessDate = new DateTime();
        parent::save();
    }

    /**
     *
     * @return string absolute folder path of the pdf
     */
    public function pdfFolderPathAbsolute()
    {
        return path('public') . $this->FilePath . '/file_' . $this->ContentFileID;
    }

    public function getPdfName()
    {
        if (!empty($this->_pfdName)) {
            return $this->_pfdName;
        }
        $fileFolder = $this->pdfFolderPathAbsolute();
        $files = scandir($fileFolder);
        foreach ($files as $file) {
            if (is_file($fileFolder . '/' . $file) && Common::endsWith($file, '.pdf')) {
                $this->_pfdName = $file;
                break;
            }
        }
        return $this->_pfdName;
    }

    public function createPdfSnapShots()
    {
        $pdfAbsolutePath = $this->pdfFolderPathAbsolute() . '/' . $this->getPdfName();
        $gsCommand = array();
        $gsCommand[] = 'gs';
        $gsCommand[] = '-o \'' . $this->pdfFolderPathAbsolute() . '/' . File::name($pdfAbsolutePath) . '_%d.jpg\'';
        $gsCommand[] = '-sDEVICE=jpeg';
        $gsCommand[] = '-dUseCrop\Box';
        $gsCommand[] = '-dJPEGQ=100';
        $gsCommand[] = '-r72x72';
        $gsCommand[] = "'" . $pdfAbsolutePath . "'";
        shell_exec(implode(" ", $gsCommand));
    }

    public function pdfFolderPathRelative()
    {
        return $this->FilePath . '/file_' . $this->ContentFileID;
    }

    public function comparePages()
    {
        // Eski pdfin interactif ogelerini yeni pdfe aktar secili ise...
        if (!$this->Transferred) {
            return;
        }
        $oldContentFile = $this->oldContentFile();
        if (!$oldContentFile) {
            return;
        }
        if (!$this->ContentFilePage) {
            return;
        }


        $matches = array();
        for ($i = 0; $i < count($oldContentFile->ContentFilePage); $i++) {
            $matches[$i] = -1;
            try {
                $oldContentFilePage = $oldContentFile->ContentFilePage[$i];
                if (count($oldContentFilePage->PageComponent) == 0) {
                    continue;
                }
                $oldPage = new imagick(path('public') . $oldContentFilePage->FilePath . '/' . $oldContentFilePage->FileName);
                for ($j = 0; $j < count($this->ContentFilePage); $j++) {
                    try {
                        $newContentFilePage = $this->ContentFilePage[$i];
                        $newPagePath = $this->pdfFolderPathAbsolute() . "/" . $newContentFilePage->FileName;
                        $newPage = new imagick($newPagePath);
                        $result = $newPage->compareImages($oldPage, Imagick::METRIC_MEANSQUAREERROR);
                        if (!isset($result)) {
                            continue;
                        }
                        $newPage->clear();
                        $newPage->destroy();
                        $smilarity = 1 - (float)$result[1];
                        if ($smilarity > 0.7 && !in_array($j, $matches)) {
                            //1- ilk buldugun sayfayla match et...
                            //2- eski sayfanin componentlerini yeni sayfasina tasi
                            //3- eski sayfanin componentinlerinin fiziksel dosyalarini yeni sayfasina tasi.
                            $matches[$i] = $j;
                            foreach ($oldContentFilePage->PageComponent as $pageComponent) {
                                $pageComponent->ContentFilePageID = $newContentFilePage->ContentFilePageID;
                                $pageComponent->save();
                                foreach ($pageComponent->PageComponentProperty as $pageComponentProperty) {
                                    // /file_ID/ varsa icinde degistir...
                                    $pageComponentProperty->Value = str_replace('/file_' . $oldContentFile->ContentFileID . '/', '/file_' . $this->ContentFileID . '/', $pageComponentProperty->Value);
                                    $pageComponentProperty->save();
                                }
                                $pageComponent->moveToNewContentFile($this, $oldContentFile);

                            }


                            break;
                        }
                    } catch (Exception $e) {
                        if (isset($newPage)) {
                            $newPage->clear();
                            $newPage->destroy();
                        }
                    }
                }
            } catch (Exception $e) {
                if (isset($oldPage)) {
                    $oldPage->clear();
                    $oldPage->destroy();
                }
            }
        }
    }

    /**
     * @return ContentFile
     */
    public function oldContentFile()
    {
        return ContentFile::where('ContentFileID', '<', $this->ContentFileID)
            ->where('ContentID', '=', $this->ContentID)
            ->where('Interactivity', '=', 1)
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('ContentFileID', 'DESC')
            ->first();
    }

    public function pdfOriginalLink()
    {
        return '/' . $this->pdfFolderPathRelative() . '/file.pdf';
    }

    public function Pages($statusID)
    {
        return $this->has_many('ContentFilePage', $this->key())->where('StatusID', '=', $statusID)->get();
    }

    public function ActivePages()
    {
        return $this->has_many('ContentFilePage', $this->key())->where('StatusID', '=', eStatus::Active)->get();
    }

    public function ActiveCoverImageFile()
    {
        return $this->has_many('ContentCoverImageFile', $this->key())->where('StatusID', '=', eStatus::Active)->first();
    }

    /**
     * @return \Laravel\Database\Eloquent\Query
     */
    public function ContentFilePage()
    {
        return $this->has_many('ContentFilePage', $this->key())->where('StatusID', '=', eStatus::Active);
    }


}
