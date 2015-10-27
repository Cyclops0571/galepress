<?php

/**
 * @property int $ContentFileID Description
 * @property int $ContentID Description
 * @property int $DateAdded Description
 * @property int $FilePath Description
 * @property int $FileName Description
 * @property int $FileName2 Description
 * @property int $FileSize Description
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
 */
class ContentFile extends Eloquent {

    public static $timestamps = false;
    public static $table = 'ContentFile';
    public static $key = 'ContentFileID';
    private $_pfdName = '';
    private static $_bookmarkAdded = false;

    /*
      public function Content()
      {
      return $this->belongs_to('Content', 'ContentID');
      }
     */

    public function Pages($statusID) {
	return $this->has_many('ContentFilePage', $this->key())->where('StatusID', '=', $statusID)->get();
    }

    public function ActivePages() {
	return $this->has_many('ContentFilePage', $this->key())->where('StatusID', '=', eStatus::Active)->get();
    }

    public function ActiveCoverImageFile() {
	return $this->has_many('ContentCoverImageFile', $this->key())->where('StatusID', '=', eStatus::Active)->first();
    }

    public function save() {
	if (!$this->dirty()) {
	    return true;
	}
	$userID = -1;
	if (Auth::User()) {
	    $userID = Auth::User()->UserID;
	}

	if ((int) $this->ContentFileID == 0) {
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

    public function pdfFolderPathRelative() {
	return $this->FilePath . '/file_' . $this->ContentFileID;
    }

    /**
     * 
     * @return absolute folder path of the pdf
     */
    public function pdfFolderPathAbsolute() {
	return path('public') . $this->FilePath . '/file_' . $this->ContentFileID;
    }

    public function getPdfName() {
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

    public function createPdfSnapShots() {
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

    public static function comparePages($newPagePath, $oldContentFileID) {
	if ($oldContentFileID <= 0) {
	    return;
	}

	$oldPagesSimilarity = array();
	$newPage = new imagick($newPagePath);
	$ocfp = DB::table('ContentFilePage')
		->where('ContentFileID', '=', $oldContentFileID)
		->where('StatusID', '=', eStatus::Active)
		->get();

	foreach ($ocfp as $oc) {
	    try {
		$oldPage = new imagick(path('public') . $oc->FilePath . '/' . $oc->FileName);
		$result = $newPage->compareImages($oldPage, Imagick::METRIC_MEANSQUAREERROR);
		array_push($oldPagesSimilarity, (1 - (float) $result[1]));
		$oldPage->clear();
		$oldPage->destroy();
		unset($oldPage);
	    } catch (Exception $e) {
		array_push($oldPagesSimilarity, 0);
	    }
	}

	$newPage->clear();
	$newPage->destroy();
	unset($newPage);
	$maxSimilarity = max($oldPagesSimilarity);

	if ($maxSimilarity > 0.7) {
	    $oldPageIndex = array_search($maxSimilarity, $oldPagesSimilarity);
	    $oldPageNo = $oldPageIndex + 1;
	    $oldContentFilePageID = (int) DB::table('ContentFilePage')
			    ->where('ContentFileID', '=', $oldContentFileID)
			    ->where('No', '=', $oldPageNo)
			    ->where('StatusID', '=', eStatus::Active)
			    ->take(1)
			    ->only('ContentFilePageID');

	    $oldComponents = DB::table('PageComponent')
		    ->where('ContentFilePageID', '=', $oldContentFilePageID)
		    ->where('StatusID', '=', eStatus::Active)
		    ->get();

	    foreach ($oldComponents as $oldComponent) {
		//insert
		$newPageComponent = new PageComponent();
		$newPageComponent->ContentFilePageID = $cfp->ContentFilePageID;
		$newPageComponent->ComponentID = $oldComponent->ComponentID;
		$newPageComponent->No = $oldPageNo; //modified by hknsrr, no değerler, aynı oldğu zaman sayfadaki kompenentler sayfaya yapışıyordu...
		$newPageComponent->save();

		$oldComponentProperties = DB::table('PageComponentProperty')
			->where('PageComponentID', '=', $oldComponent->PageComponentID)
			->where('StatusID', '=', eStatus::Active)
			->get();

		foreach ($oldComponentProperties as $oldComponentProperty) {
		    //insert
		    $newPageComponentProperty = new PageComponentProperty();
		    $newPageComponentProperty->PageComponentID = $newPageComponent->PageComponentID;
		    $newPageComponentProperty->Name = $oldComponentProperty->Name;
		    $newPageComponentProperty->Value = $oldComponentProperty->Value;
		    $newPageComponentProperty->save();
		}

		$oldPageNo++;
	    }
	}
    }

    public static function arrangeAnnotation($cfp, $doc, $pdfLib, $pageNo) {
	try {
	    //added by hknsrr, weblink, pagelink ve bookmark annotation içeren 
	    //pdf'lerin sisteme yüklendikleri zaman bu annotationların sisteme kaydedilerek interaktif tasarlayıcıda gösterilmesi.

	    $annotations_path = "pages[" . $pageNo . "]/annots";
	    $anncount = (int) $pdfLib->pcos_get_number($doc, "length:" . $annotations_path);
	    if ($anncount > 0) {
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
		    $linkDest = (int) $pdfLib->pcos_get_number($doc, $annotation_path . "/destpage");
		    $pcosmode = $pdfLib->pcos_get_string($doc, "pcosmode");
		    $subtype = $pdfLib->pcos_get_string($doc, $annotation_path . "/Subtype");
		    $objectType = $pdfLib->pcos_get_string($doc, "type:" . $annotation_path . "/A/URI");
		    $uri = $pdfLib->pcos_get_string($doc, $annotation_path . "/A/URI");
		    $rect_path = $annotation_path . "/Rect";
		    $pageHeight = (float) $pdfLib->pcos_get_number($doc, "pages[" . $pageNo . "]/height");
		    $rectX = abs($pdfLib->pcos_get_number($doc, $rect_path . "[0]"));
		    $rectY = abs($pageHeight - (int) $pdfLib->pcos_get_number($doc, $rect_path . "[3]"));
		    $rectWidth = abs($pdfLib->pcos_get_number($doc, $rect_path . "[2]") - $rectX);
		    $rectHeight = abs($pageHeight - (int) $pdfLib->pcos_get_number($doc, $rect_path . "[1]") - $rectY);

		    $lastComponentNo = (int) DB::table('PageComponent')
				    ->where('ContentFilePageID', '=', $cfp->ContentFilePageID)
				    ->where('StatusID', '=', eStatus::Active)
				    ->order_by('No', 'DESC')
				    ->take(1)
				    ->only('No');

		    //Web Link
		    if ($objectType != "string" && ($pcosmode == "URI" || $pcosmode == ">>")) {
			continue;
		    } else if (($pcosmode == "URI" || $pcosmode == ">>") && $subtype == "Link" && substr($uri, 0, 2) != "yl") {
			$linkAnnotPageComponent = new PageComponent();
			$linkAnnotPageComponent->ContentFilePageID = $cfp->ContentFilePageID;
			$linkAnnotPageComponent->ComponentID = 4;
			$linkAnnotPageComponent->No = $lastComponentNo + 1;
			$linkAnnotPageComponent->save();

			$y = isset($indesignFind[0]) ? $rectY - $rectHeight : $rectY;

			//Weblink Component
			$annotationPageComponentProperties = array(
			    "pcid" => "0",
			    "type" => "2",
			    "page" => $cfp->No,
			    "url" => $uri,
			    "x" => $rectX,
			    "y" => $y,
			    "w" => $rectWidth,
			    "h" => $rectHeight,
			);
			PageComponentProperty::batchInsert($linkAnnotPageComponent->PageComponentID, $annotationPageComponentProperties);
		    } else if ($pdfLib->pcos_get_string($doc, $annotation_path . "/Subtype") == "Link") {
			//Page Link
			$linkAnnotPageComponent = new PageComponent();
			$linkAnnotPageComponent->ContentFilePageID = $cfp->ContentFilePageID;
			$linkAnnotPageComponent->ComponentID = 4;
			$linkAnnotPageComponent->No = $lastComponentNo + 1;
			$linkAnnotPageComponent->save();

			//Weblink Component
			$y = isset($indesignFind[0]) ? $rectY - $rectHeight : $rectY;
			$linkAnnotPageComponentProperties = array(
			    "pcid" => "0",
			    "type" => "1",
			    "page" => $linkDest,
			    "url" => "http://",
			    "x" => $rectX,
			    "y" => $y,
			    "w" => $rectWidth,
			    "h" => $rectHeight,
			);
			PageComponentProperty::batchInsert($linkAnnotPageComponent->PageComponentID, $linkAnnotPageComponentProperties);
		    }
		}
	    }
	} catch (Exception $e) {
	    $msg = __('common.task_message', array(
		'task' => '`interactivity`',
		'detail' => $e->getMessage()
		    )
	    );
	    Common::sendErrorMail($msg);
	}
    }

    public static function arrangeBookmark($cfp, $doc, $pdfLib) {
	if (self::$_bookmarkAdded) {
	    return;
	}

	try {
	    //added by hknsrr, weblink, pagelink ve bookmark annotation içeren 
	    //pdf'lerin sisteme yüklendikleri zaman bu annotationların sisteme kaydedilerek interaktif tasarlayıcıda gösterilmesi.
	    $bookmarkCount = (int) $pdfLib->pcos_get_number($doc, "length:bookmarks");
	    if ($bookmarkCount > 0) {
		for ($bookmarkIndex = 0; $bookmarkIndex < $bookmarkCount; $bookmarkIndex++) {
		    $bookmarkDestpage = (int) $pdfLib->pcos_get_number($doc, "bookmarks[" . $bookmarkIndex . "]/destpage");
		    $bookmarkTitle = $pdfLib->pcos_get_string($doc, "bookmarks[" . $bookmarkIndex . "]/Title");
		    $lastComponentNo = (int) DB::table('PageComponent')
				    ->where('ContentFilePageID', '=', $cfp->ContentFilePageID + $bookmarkDestpage - 1)
				    ->where('StatusID', '=', eStatus::Active)
				    ->order_by('No', 'DESC')
				    ->take(1)
				    ->only('No');

		    $linkAnnotPageComponent = new PageComponent();
		    $linkAnnotPageComponent->ContentFilePageID = $cfp->ContentFilePageID + $bookmarkDestpage - 1;
		    $linkAnnotPageComponent->ComponentID = 10;
		    $linkAnnotPageComponent->No = $lastComponentNo + 1;
		    $linkAnnotPageComponent->save();

		    //Bookmark Component
		    $pageCompenentProperties = array(
			"pcid" => "0",
			"text" => $bookmarkTitle,
			"trigger-x" => 10,
			"trigger-y" => 10
		    );
		    PageComponentProperty::batchInsert($linkAnnotPageComponent->PageComponentID, $pageCompenentProperties);
		}
		self::$_bookmarkAdded = true;
	    }
	} catch (Exception $e) {
	    $msg = __('common.task_message', array(
		'task' => '`interactivity`',
		'detail' => $e->getMessage()
		    )
	    );
	    Common::sendErrorMail($msg);
	}
    }

    public static function makeContentInteractive($ContentID, $contentFileID, $oldContentFileID) {
	//start from here to narrow down
	$cf = ContentFile::find($contentFileID);
	if ($cf->Interactivity == 2) {
	    return Redirect::to('/' . __('route.contents') . '/' . $ContentID . '?error=' . __('error.interactivity_conflict'));
	} else if ($cf->Interactivity !== 1) {
	    if (Laravel\Request::env() == ENV_LIVE) {
		$cf->Interactivity = 2;
	    }
	    $cf->save();
	}

	$targetFileNameFull = path('public') . $cf->FilePath . '/' . $cf->FileName;

	//create folder if doesnt exist
	if (!File::exists($cf->pdfFolderPathAbsolute())) {
	    File::mkdir($cf->pdfFolderPathAbsolute());
	}

	try {
	    DB::transaction(function() use ($cf, $contentFileID, $oldContentFileID, $targetFileNameFull) {
		/* @var $cf ContentFile */
		$cf->Interactivity = 1;
		$cf->save();

		//extract zip file
		$zip = new ZipArchive();
		$res = $zip->open($targetFileNameFull);
		if ($res === true) {
		    $zip->extractTo($cf->pdfFolderPathAbsolute());
		    $zip->close();
		}


		$pdfFileNameFull = $cf->pdfFolderPathAbsolute() . '/' . $cf->getPdfName();
		$pdfLib = new pdflib();
		$pdfLib->set_option("license=" . Config::get('custom.pdflib_license'));
		$pdfLib->set_option("errorpolicy=return");
		$doc = $pdfLib->open_pdi_document($pdfFileNameFull, "");
		if ($doc == 0) {
		    throw new Exception($pdfLib->get_errmsg());
		}

		$cf->createPdfSnapShots();

		$pageCount = (int) $pdfLib->pcos_get_number($doc, "length:pages");
		for ($pageNo = 0; $pageNo < $pageCount; $pageNo++) {
		    $width = (float) $pdfLib->pcos_get_number($doc, "pages[" . $pageNo . "]/width");
		    $height = (float) $pdfLib->pcos_get_number($doc, "pages[" . $pageNo . "]/height");

		    $imageFile = File::name($pdfFileNameFull) . '_' . ($pageNo + 1) . '.jpg';
		    if (!File::exists($cf->pdfFolderPathAbsolute() . '/' . $imageFile)) {
			throw new Exception("File does not exits: " . $cf->pdfFolderPathAbsolute() . '/' . $imageFile);
		    }

		    //generate pages
		    // <editor-fold defaultstate="collapsed" desc="Generate Pages">
		    $cfp = new ContentFilePage();
		    $cfp->ContentFileID = $contentFileID;
		    $cfp->No = $pageNo + 1;
		    $cfp->Width = $width;
		    $cfp->Height = $height;
		    $cfp->FilePath = $cf->pdfFolderPathRelative();
		    $cfp->FileName = $imageFile;
		    $cfp->FileSize = File::size($cf->pdfFolderPathAbsolute() . '/' . $imageFile);
		    $cfp->save();
		    // </editor-fold>
		    if ($cf->Transferred != 1) {
			ContentFile::arrangeBookmark($cfp, $doc, $pdfLib);
			ContentFile::arrangeAnnotation($cfp, $doc, $pdfLib, $pageNo);
		    }

		    ContentFile::comparePages($cf->pdfFolderPathAbsolute() . '/' . $imageFile, $oldContentFileID);
		}
		$pdfLib->close_pdi_document($doc);
	    });
	    if(Laravel\Request::env() == ENV_LIVE) {
		interactivityQueue::trigger();
	    }
	} catch (PDFlibException $e) {
	    $data = array(
		'errmsg' => "PDFlib exception occurred in starter_pcos sample:<br/>[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " . $e->get_errmsg()
	    );
	    return View::make('interactivity.error', $data);
	} catch (Exception $e) {
	    if (Laravel\Request::env() != ENV_LIVE) {
		$expMessage = "File:" . $e->getFile() . "\r\n";
		$expMessage .= "Line:" . $e->getLine() . "\r\n";
		$expMessage .= "Message:" . $e->getMessage() . "\r\n";
		echo $expMessage;
		dd($e->getTraceAsString());
	    }
	    $data = array(
		'errmsg' => $e->getMessage()
	    );
	    return View::make('interactivity.error', $data);
	}
    }

}
