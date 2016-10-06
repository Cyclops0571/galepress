<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 27.09.2016
 * Time: 11:54
 * @property int trigger_x
 * @property int trigger_y
 * @property int x
 * @property int y
 * @property int w
 * @property int h
 * @property int propertyImport
 * @property int propertyModal
 * @property int propertyType
 * @property string propertyUrl
 * @property string propertyMail
 * @property int propertyPage
 * @property string propertyText
 * @property string propertyLat
 * @property string propertyLon
 * @property float propertyZoom
 * @property int trigger_w
 * @property int trigger_h
 * @property array data
 * @property string qs
 */
class PageComponentDecorator
{
    /** @var  PageComponent $pageComponent */
    private $pageComponent;

    /** @var PDFlib $pdfLib */
    private $pdfLib;
    /** @var ContentFile $contentFile */
    private $contentFile;

    private $data = array();

    const LINK_PAGE = 1;
    const LINK_HTML = 2;
    const LINK_MAIL = 3;


    public function __construct(PageComponent $pc, PDFlib $pdfLib, ContentFile $contentFile)
    {
        $this->pageComponent = $pc;
        $this->pdfLib = $pdfLib;
        $this->contentFile = $contentFile;
        $this->data = array(
            'preview' => false,
            'baseDirectory' => '',
            'id' => $this->pageComponent->PageComponentID
        );
        $this->mapMyProperties();
    }

    public function createPdfComponent()
    {
        if ($this->propertyModal == 1) {
            $image_url = path('public') . $this->data["modaliconname"];
            if (File::exists($image_url) && is_file($image_url)) {
                $image_url = Config::get("custom.url") . "/" . $this->data["modaliconname"];
            } else {
                $image_url = Config::get("custom.url") . "/files/components/" . $this->pageComponent->Component->Class . "/icon.png";
            }
            $imageData = file_get_contents($image_url);
            if ($imageData == false) {
                throw new Exception("Error: file_get_contents($image_url) failed");
            }
            $this->pdfLib->create_pvf("/pvf/image", $imageData, "");
            $triggerImage = $this->pdfLib->load_image("auto", "/pvf/image", "");
            if ($triggerImage == 0) {
                throw new Exception($this->pdfLib->get_errmsg());
            }

            $optlist = "boxsize={" . $this->w . " " . $this->h . "} position={center} fitmethod=meet";
            $this->pdfLib->fit_image($triggerImage, $this->x, $this->y, $optlist);
            $this->pdfLib->close_image($triggerImage);
            $this->pdfLib->delete_pvf("/pvf/image");
        }


        switch ($this->pageComponent->ComponentID) {
            case Component::ComponentVideo:
                $this->createVideo();
                break;
            case Component::ComponentAudio:
                $this->createAudio();
                break;
            case Component::ComponentAnimation:
                $this->createAnimation();
                break;
            case Component::ComponentTooltip:
                $this->createTooltip();
                break;
            case Component::ComponentScroller:
                $this->createScroll();
                break;
            case Component::ComponentSlideShow:
                $this->createSlideShow();
                break;
            case Component::Component360:
                $this->create360();
                break;
            case Component::ComponentMap:
                $this->createMap();
                break;
            case Component::ComponentLink:
                $this->createLink();
                break;
            case Component::ComponentWeb:
                $this->createWeb();
                break;
            case 'bookmark':
                $this->createBookmark();
                break;
        }

    }

    private function createVideo()
    {
        $outputPath = $this->contentFile->pdfFolderPathAbsolute() . '/output';

        //video url youtube embed
        if (!(strpos($this->propertyUrl, 'www.youtube.com/embed') === false)) {

            if (strpos($this->propertyUrl, '?') !== false) {
                $this->qs = str_replace('?', '&', $this->qs);
            }
            $this->propertyUrl = str_replace("http", "ylweb", $this->propertyUrl . $this->qs);
            $action = $this->pdfLib->create_action("URI", "url {" . $this->propertyUrl . "}");
            $this->pdfLib->create_annotation(
                $this->x,
                $this->y,
                $this->x + $this->w,
                $this->y + $this->h,
                "Link", "linewidth=0 action {activate $action}"
            );
        } else {
            $this->createComponentFolder();
            $this->copyComponentZipFiles();
            $content = View::make('interactivity.components.' . $this->pageComponent->Component->Class . '.dynamic', $this->data)->render();
            File::put($outputPath . '/comp_' . $this->pageComponent->PageComponentID . '.html', $content);
            $action = $this->pdfLib->create_action("URI", "url {" . $this->getUrl() . "}");
            $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
        }
    }

    private function createAudio()
    {
        $outputPath = $this->contentFile->pdfFolderPathAbsolute() . '/output';
        $this->createComponentFolder();
        $this->copyComponentZipFiles();

        $this->x = $this->trigger_x;
        $this->y = $this->trigger_y - $this->trigger_h;
        $this->w = $this->trigger_w;
        $this->h = $this->trigger_h;

        $content = View::make('interactivity.components.' . $this->pageComponent->Component->Class . '.dynamic', $this->data)->render();
        File::put($outputPath . '/comp_' . $this->pageComponent->PageComponentID . '.html', $content);
        $action = $this->pdfLib->create_action("URI", "url {" . $this->getUrl() . "}");
        $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
    }

    private function createAnimation()
    {
        $outputPath = $this->contentFile->pdfFolderPathAbsolute() . '/output';
        $this->createComponentFolder();
        $this->copyComponentZipFiles();
        $content = View::make('interactivity.components.' . $this->pageComponent->Component->Class . '.dynamic', $this->data)->render();
        File::put($outputPath . '/comp_' . $this->pageComponent->PageComponentID . '.html', $content);
        $action = $this->pdfLib->create_action("URI", "url {" . $this->getUrl() . "}");
        $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
    }

    private function createTooltip()
    {
        $outputPath = $this->contentFile->pdfFolderPathAbsolute() . '/output';
        $this->createComponentFolder();
        $this->copyComponentZipFiles();
        $content = View::make('interactivity.components.' . $this->pageComponent->Component->Class . '.dynamic', $this->data)->render();
        File::put($outputPath . '/comp_' . $this->pageComponent->PageComponentID . '.html', $content);
        $action = $this->pdfLib->create_action("URI", "url {" . $this->getUrl() . "}");
        $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
    }

    private function createScroll()
    {
        $outputPath = $this->contentFile->pdfFolderPathAbsolute() . '/output';
        $this->createComponentFolder();
        $this->copyComponentZipFiles();
        $content = View::make('interactivity.components.' . $this->pageComponent->Component->Class . '.dynamic', $this->data)->render();
        File::put($outputPath . '/comp_' . $this->pageComponent->PageComponentID . '.html', $content);
        $action = $this->pdfLib->create_action("URI", "url {" . $this->getUrl() . "}");
        $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
    }

    private function createSlideShow()
    {
        $outputPath = $this->contentFile->pdfFolderPathAbsolute() . '/output';
        $this->createComponentFolder();
        $this->copyComponentZipFiles();

        $files = DB::table('PageComponentProperty')
            ->where('PageComponentID', '=', $this->pageComponent->PageComponentID)
            ->where('Name', '=', 'filename')
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('PageComponentPropertyID', 'ASC')
            ->get();
        $arr = array();
        foreach ($files as $file) {
            array_push($arr, $file->Value);
        }
        $this->data = array_merge($this->data, array('files' => $arr));

        $content = View::make('interactivity.components.' . $this->pageComponent->Component->Class . '.dynamic', $this->data)->render();
        File::put($outputPath . '/comp_' . $this->pageComponent->PageComponentID . '.html', $content);
        $action = $this->pdfLib->create_action("URI", "url {" . $this->getUrl() . "}");
        $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
    }

    private function create360()
    {
        $outputPath = $this->contentFile->pdfFolderPathAbsolute() . '/output';
        $this->createComponentFolder();
        $this->copyComponentZipFiles();
        $files = DB::table('PageComponentProperty')
            ->where('PageComponentID', '=', $this->pageComponent->PageComponentID)
            ->where('Name', '=', 'filename')
            ->where('StatusID', '=', eStatus::Active)
            ->order_by('PageComponentPropertyID', 'ASC')
            ->get();
        $arr = array();
        foreach ($files as $file) {
            array_push($arr, $file->Value);
        }
        $this->data = array_merge($this->data, array('files' => $arr));

        $content = View::make('interactivity.components.' . $this->pageComponent->Component->Class . '.dynamic', $this->data)->render();
        File::put($outputPath . '/comp_' . $this->pageComponent->PageComponentID . '.html', $content);
        $action = $this->pdfLib->create_action("URI", "url {" . $this->getUrl() . "}");
        $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
    }

    private function createMap()
    {
        $mapType = 'standard';

        if ($this->propertyType == 2) {
            $mapType = 'hybrid';
        } else if ($this->propertyType == 3) {
            $mapType = 'satellite';
        }
        $zoom = ((100 - ($this->propertyZoom * 1000)) / 1000);
        $propertyUrl = 'ylmap://' . $mapType . $this->qs . '&lat=' . $this->propertyLat . '&lon=' . $this->propertyLon . '&slat=' . $zoom . '&slon=' . $zoom;
        $action = $this->pdfLib->create_action("URI", "url {" . $propertyUrl . "}");
        $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
        //map
    }

    private function createLink()
    {
        switch ($this->propertyType) {
            case self::LINK_PAGE:
                $optlist = "destination={page=" . $this->propertyPage . " type=fixed left=10 top=10 zoom=1}";
                $action = $this->pdfLib->create_action("GOTO", $optlist);
                break;
            case self::LINK_HTML:
                if (strpos($this->propertyUrl, '?') !== false) {
                    $this->qs = str_replace('?', '&', $this->qs);
                }
                $action = $this->pdfLib->create_action("URI", "url {" . $this->propertyUrl . $this->qs . "}");
                break;
            case self::LINK_MAIL:
                $this->propertyMail = "mailto:" . $this->propertyMail;
                $action = $this->pdfLib->create_action("URI", "url {" . $this->propertyMail . "}");
                break;
        }
        $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
    }

    private function createWeb()
    {
        if (strpos($this->propertyUrl, '?') !== false) {
            $this->qs = str_replace('?', '&', $this->qs);
        }
        $this->propertyUrl = str_replace("http", "ylweb", $this->propertyUrl . $this->qs);
        $action = $this->pdfLib->create_action("URI", "url {" . $this->propertyUrl . "}");
        $this->pdfLib->create_annotation($this->x, $this->y, $this->x + $this->w, $this->y + $this->h, "Link", "linewidth=0 action {activate $action}");
    }

    private function createBookmark()
    {
        $this->propertyText = pack('H*', 'feff') . mb_convert_encoding($this->propertyText, 'UTF-16', 'UTF-8');
        $this->trigger_x = $this->trigger_x > 0 ? $this->trigger_x : 0;
        $this->trigger_y = $this->trigger_y > 0 ? $this->trigger_y : 0;
        $this->pdfLib->create_bookmark($this->propertyText, "destination={page=" . ($this->pageComponent->ContentFilePage->No) . " type=fixed left=" . $this->trigger_x . " top=" . $this->trigger_y . " zoom=1}");
    }

    private function getPath() {
        return $this->getOutputPath() . '/comp_' . $this->pageComponent->PageComponentID;

    }

    private function getOutputPath() {
        return $this->contentFile->pdfFolderPathAbsolute() . '/output';
    }

    private function createComponentFolder() {

        if (!File::exists($this->getPath())) {
            File::mkdir($this->getPath());
        }
    }

    public function copyComponentZipFiles() {
        $componentZipPath = $this->getOutputPath() . '/' . mb_strtolower($this->pageComponent->Component->Class);
        if(File::exists($componentZipPath)) {
            if(!is_file($componentZipPath)) {
                File::rmdir($componentZipPath);
            }
        }
        File::mkdir($componentZipPath);

        //extract zip file
        $zipFile = $this->pageComponent->Component->getZipPath();
        $zip = new ZipArchive();
        $res = $zip->open($zipFile);
        if ($res === true) {
            $zip->extractTo($componentZipPath);
            $zip->close();
        }
    }

    private function getUrl()
    {
        if ($this->contentFile->Included == 1 || $this->propertyImport == 1) {
            return 'ylweb://localhost/comp_' . $this->pageComponent->PageComponentID . '.html' . $this->qs;
        }

        $link = array();
        $link[] = 'ylweb://www.galepress.com/files';
        $link[] = 'customer_' . $this->contentFile->Content->Application->CustomerID;
        $link[] = 'application_' . $this->contentFile->Content->ApplicationID;
        $link[] = 'content_' . $this->contentFile->ContentID;
        $link[] = 'file_' . $this->contentFile->ContentFileID;
        $link[] = 'output/comp_' . $this->pageComponent->PageComponentID . '.html' . $this->qs;
        return implode('/', $link);
    }

//    private function getWebUrl() {
//        if($this->propertyUrl != '' || $this->propertyUrl != 'http://' || $this->propertyUrl != 'https://') {
//            if (strpos($this->propertyUrl, '?') !== false) {
//                $this->qs = str_replace('?', '&', $this->qs);
//            }
//            return $this->propertyUrl . $this->qs;
//        }
//    }

    private function mapMyProperties()
    {

        $this->trigger_x = 0;
        $this->trigger_y = 0;
        $this->trigger_w = 60;
        $this->trigger_h = 60;
        $this->x = 60;
        $this->y = 0;
        $this->w = 0;
        $this->h = 0;
        $this->propertyImport = 0;
        $this->propertyModal = 0;
        $this->propertyType = 0;
        $this->propertyUrl = '';
        $this->propertyMail = '';
        $this->propertyPage = 0;
        $this->propertyText = '';
        $this->propertyLat = '';
        $this->propertyLon = '';
        $this->propertyZoom = 0.09;

        foreach ($this->pageComponent->PageComponentProperty as $cp) {
            if ($cp->Name == 'trigger-x') {
                $this->trigger_x = (int)$cp->Value;
            } elseif ($cp->Name == 'trigger-y') {
                $this->trigger_y = (int)$cp->Value;
            } elseif ($cp->Name == 'x') {
                $this->x = (int)$cp->Value;
            } elseif ($cp->Name == 'y') {
                $this->y = (int)$cp->Value;
            } elseif ($cp->Name == 'w') {
                $this->w = (int)$cp->Value;
            } elseif ($cp->Name == 'h') {
                $this->h = (int)$cp->Value;
            } elseif ($cp->Name == 'import') {
                $this->propertyImport = (int)$cp->Value;
            } elseif ($cp->Name == 'modal') {
                $this->propertyModal = (int)$cp->Value;
            } elseif ($cp->Name == 'type') {
                $this->propertyType = (int)$cp->Value;
            } elseif ($cp->Name == 'url') {
                $this->propertyUrl = $cp->Value;
            } elseif ($cp->Name == 'mail') {
                $this->propertyMail = $cp->Value;
            } elseif ($cp->Name == 'page') {
                $this->propertyPage = (int)$cp->Value;
            } elseif ($cp->Name == 'text') {
                $this->propertyText = $cp->Value;
            } elseif ($cp->Name == 'lat') {
                $this->propertyLat = $cp->Value;
            } elseif ($cp->Name == 'lon') {
                $this->propertyLon = $cp->Value;
            } elseif ($cp->Name == 'zoom') {
                $this->propertyZoom = (float)$cp->Value;
            }

            if ($this->propertyModal == 1) {
                $this->trigger_w = 52;
                $this->trigger_h = 52;
            }

            $this->data = array_merge($this->data, array($cp->Name => $cp->Value));
        }

        //reverse y
        $this->y = $this->pageComponent->ContentFilePage->Height - $this->y - $this->h;
        $this->trigger_y = $this->pageComponent->ContentFilePage->Height - $this->trigger_y;

        $paramQS = array();
        $paramQS[] = 'componentTypeID=' . $this->pageComponent->ComponentID;
        $paramQS[] = 'modal=' . $this->propertyModal;
        $this->qs = '?' . implode("&", $paramQS);
    }

    public function addToZip(ZipArchive $zip) {

    }
}