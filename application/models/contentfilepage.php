<?php

/**
 * @property int ContentFilePageID
 * @property int ProcessTypeID
 * @property int ContentFileID
 * @property int No
 * @property int OperationStatus
 * @property int Width
 * @property int Height
 * @property string FilePath
 * @property string FileName
 * @property string FileName2
 * @property int FileSize
 * @property int StatusID
 * @property DateTime ProcessDate
 * @property int ProcessUserID
 * @property DateTime DateCreated
 * @property int CreatorUserID
 * @property PageComponent[] $PageComponent
 */
class ContentFilePage extends Eloquent
{
    const Video = 1;
    const Audio = 2;
    const Map = 3;
    const Link = 4;
    const Web = 5;
    const Tooltip = 6;
    const Scroller = 7;
    const Slideshow = 8;
    const slide360 = 9;
    const Bookmark = 10;
    const Animation = 11;
    const OperationContinues = 1;
    const OperationAvailable = 0;
    public static $timestamps = false;
    public static $table = 'ContentFilePage';
    public static $key = 'ContentFilePageID';

    /**
     * @param $contentFileID
     * @param $pageNo
     * @return ContentFilePage
     */
    public static function getPage($contentFileID, $pageNo)
    {
        return ContentFilePage::where('ContentFileID', '=', $contentFileID)
            ->where('No', '=', $pageNo)
            ->where('StatusID', '=', eStatus::Active)
            ->first();
    }

    public function save()
    {
        if (!$this->dirty()) {
            return true;
        }
        $userID = -1;
        if (Auth::user()) {
            $userID = Auth::user()->UserID;
        }

        if ($this->Height == 0 || $this->Width == 0) {
            $prevFilePage = $this->previousContentFilePage();
            if ($prevFilePage) {
                if ($this->Height == 0) {
                    $this->Height = $prevFilePage->Height;
                }
                if ($this->Width == 0) {
                    $this->Width = $prevFilePage->Width;
                }
            }
        }

        if ((int)$this->ContentFilePageID == 0) {
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
     * @return ContentFilePage
     */
    public function previousContentFilePage()
    {
        return ContentFilePage::where('ContentFileID', '=', $this->ContentFileID)
            ->where('No', '=', ($this->No - 1))
            ->first();
    }

    public function PageComponent()
    {
        return $this->has_many('PageComponent', $this->key())->where('StatusID', '=', eStatus::Active);
    }

    public function setComponentByType($componentType, $pageComponentID, $componentNo, $postData)
    {
        return;
        $clientProcess = Input::get('comp-' . $componentNo . '-process', '');
        if ($clientProcess == 'removed') {
            $this->removePageComponent($pageComponentID);
            return;
        } else if ($clientProcess == 'new') {
            $pageComponent = new PageComponent();
        } else if ($clientProcess == 'loaded') {
            $pageComponent = PageComponent::find($pageComponentID);
            if (!$pageComponent) {
                throw new Exception('PageComponent not found of file:' . __FILE__ . " at line " . __LINE__);
            }
            //var olan  pageComponentin onceki propertylerini silelim ???
            DB::table('PageComponentProperty')
                ->where('PageComponentID', '=', $pageComponent->PageComponentID)
                ->where('StatusID', '=', eStatus::Active)
                ->update(
                    array(
                        'StatusID' => eStatus::Deleted,
                        'ProcessUserID' => Auth::user()->UserID,
                        'ProcessDate' => new DateTime(),
                        'ProcessTypeID' => eProcessTypes::Update
                    )
                );
        } else {
            throw new Exception('Undefined process type of file:' . __FILE__ . " at line " . __LINE__);
        }

        $pageComponent->ContentFilePageID = $this->ContentFilePageID;
        $pageComponent->ComponentID = $componentType;
        $pageComponent->No = $componentNo;
        $pageComponent->save();
        $customerID = 571571;
        $applicationID = 571571;
        $contentID = 571571;
        $contentFileID = 571571;

        $componentProperies = $this->getPageComponentPropertiesAndValues($postData, $componentNo);
        foreach ($componentProperies as $name => $value) {
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
                        $targetFile = Auth::user()->UserID . '_' . date("YmdHis") . '_' . $v;
                        //360
                        if ($componentType == ContentFilePage::slide360) {
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
                        $pcp->CreatorUserID = Auth::user()->UserID;
                        $pcp->DateCreated = new DateTime();
                        $pcp->ProcessUserID = Auth::user()->UserID;
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
                    $targetFile = Auth::user()->UserID . '_' . date("YmdHis") . '_' . $value;
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
                $pcp->CreatorUserID = Auth::user()->UserID;
                $pcp->DateCreated = new DateTime();
                $pcp->ProcessUserID = Auth::user()->UserID;
                $pcp->ProcessDate = new DateTime();
                $pcp->ProcessTypeID = eProcessTypes::Insert;
                $pcp->save();
            }

        }
        switch ($componentType) {
            case self::Video:
                $this->componentFactory($pageComponentID, $componentNo, $postData);
                break;
            case self::Audio:
                break;
            case self::Map:
                break;
            case self::Link:
                break;
            case self::Web:
                break;
            case self::Tooltip:
                break;
            case self::Scroller:
                break;
            case self::Slideshow:
                break;
            case self::slide360:
                break;
            case self::Bookmark:
                break;
            case self::Animation:
                break;
            default:
                throw new Exception(__('error.unknown_component_type'));
        }
    }

    private function removePageComponent($pageComponentID)
    {
        DB::table('PageComponentProperty')
            ->where('PageComponentID', 'IN', DB::raw('(SELECT `PageComponentID` FROM `PageComponent` WHERE `PageComponentID`='
                . $pageComponentID . ' AND `ContentFilePageID`=' . $this->ContentFilePageID . ' AND `StatusID`=1)'))
            ->where('StatusID', '=', eStatus::Active)
            ->update(
                array(
                    'StatusID' => eStatus::Deleted,
                    'ProcessUserID' => Auth::user()->UserID,
                    'ProcessDate' => new DateTime(),
                    'ProcessTypeID' => eProcessTypes::Update
                )
            );

        DB::table('PageComponent')
            ->where('PageComponentID', '=', $pageComponentID)
            ->where('ContentFilePageID', '=', $this->ContentFilePageID)
            ->where('StatusID', '=', eStatus::Active)
            ->update(
                array(
                    'StatusID' => eStatus::Deleted,
                    'ProcessUserID' => Auth::user()->UserID,
                    'ProcessDate' => new DateTime(),
                    'ProcessTypeID' => eProcessTypes::Update
                )
            );
    }

    public function getPageComponentPropertiesAndValues($postData, $componentOrder)
    {
        $properties = array();
        foreach ($postData as $name => $value) {
            if (Common::startsWith($name, 'comp-' . $componentOrder)) {
                $name = str_replace('comp-' . $componentOrder . '-', "", $name);
                if (!in_array($name, PageComponent::$ignoredProperties)) {
                    $properties[$name] = $value;
                }
            }
        }
        return $properties;
    }

    private function componentFactory($componentID, $componentPageOrder, $postData)
    {
        return;
//        $componentVideo = new ComponentVideo();
//        if ($componentID > 0) {
//            $pageComponent = PageComponent::find($componentID);
//            if (!$pageComponent) {
//                throw new Exception(__('error.compoenent_not_found'));
//            }
//            $componentVideo->pageComponent = $pageComponent;
//
//        } else {
//            $componentVideo->pageComponent = new PageComponent();
//        }
//
//        $properties = array();
//        foreach ($postData as $name => $value) {
//            if (Common::startsWith($name, 'comp-' . $componentPageOrder)) {
//                $name = str_replace('comp-' . $componentPageOrder . '-', "", $name);
//                if (!in_array($name, PageComponent::$ignoredProperties)) {
//                    $properties[$name] = $value;
//                }
//            }
//        }
//
//        $clientProcess = Input::get('comp-' . $componentPageOrder . '-process', '');
//
//        ///*********************************Eski Kod  **********************////
//
//
//        foreach ($ids as $id) {
//            //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
//            $clientComponentID = (int)Input::get('comp-' . $id . '-id', '0');
//            $componentID = (int)Input::get('comp-' . $id . '-pcid', '0');
//            $clientProcess = Input::get('comp-' . $id . '-process', '');
//
//            if ($clientProcess == 'new' || $clientProcess == 'loaded') {
//                $tPageComponentExists = false;
//
//                if ($clientProcess == 'loaded' && $componentID > 0) {
//                    $tPageComponentExists = true;
//                    $pageComponent = PageComponent::find($componentID);
//                } else {
//                    $pageComponent = new PageComponent();
//                }
//
//                $pageComponent->ContentFilePageID = $contentFilePageID;
//                $pageComponent->ComponentID = $clientComponentID;
//                $pageComponent->No = $id;
//                $pageComponent->save();
//
//                //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
//                if ($tPageComponentExists) {
//                    //wtf neden statusu deleted yapiyor ????
//                    DB::table('PageComponentProperty')
//                        ->where('PageComponentID', '=', $pageComponent->PageComponentID)
//                        ->where('StatusID', '=', eStatus::Active)
//                        ->update(
//                            array(
//                                'StatusID' => eStatus::Deleted,
//                                'ProcessUserID' => $currentUser->UserID,
//                                'ProcessDate' => new DateTime(),
//                                'ProcessTypeID' => eProcessTypes::Update
//                            )
//                        );
//                }
//                //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
//
//                foreach ($componentProperties[$id] as $name => $value) {
//                    //Log::info('line:' . __LINE__ . ' comp:' . $name . ' time:' . microtime());
//
//                    //slideshow || gallery360
//                    if (($name == 'file' || $name == 'filename' || $name == 'filename2') && is_array($value)) {
//                        $index = 1;
//
//                        foreach ($value as $v) {
//                            if (Str::length($v) > 0) {
//                                $sourcePath = 'files/temp';
//                                $sourcePathFull = path('public') . $sourcePath;
//                                $sourceFile = $v;
//                                $sourceFileNameFull = $sourcePathFull . '/' . $sourceFile;
//
//                                $targetPath = 'files/customer_' . $customerID . '/application_' . $applicationID . '/content_' . $contentID . '/file_' . $contentFileID . '/output/comp_' . $pageComponent->PageComponentID;
//                                $targetPathFull = path('public') . $targetPath;
//                                $targetFile = $currentUser->UserID . '_' . date("YmdHis") . '_' . $v;
//                                //360
//                                if ($clientComponentID == 9) {
//                                    $targetFile = ($index < 10 ? '0' . $index : '' . $index) . '.jpg';
//                                }
//                                $targetFileNameFull = $targetPathFull . '/' . $targetFile;
//
//                                if (!File::exists($targetPathFull)) {
//                                    File::mkdir($targetPathFull);
//                                }
//
//                                if (File::exists($sourceFileNameFull)) {
//                                    File::move($sourceFileNameFull, $targetFileNameFull);
//                                    $v = $targetPath . '/' . $targetFile;
//                                } else {
//                                    $oldValue = DB::table('PageComponentProperty')
//                                        ->where('PageComponentID', '=', $pageComponent->PageComponentID)
//                                        ->where('Name', '=', $name)
//                                        ->where('Value', 'LIKE', '%' . $v)
//                                        ->where('StatusID', '=', eStatus::Deleted)
//                                        ->order_by('PageComponentPropertyID', 'DESC')
//                                        ->first(array('Value'));
//                                    if ($oldValue) {
//                                        $v = $oldValue->Value;
//                                    } else {
//                                        $v = $targetPath . '/' . $v;
//                                    }
//                                    //TODO:kaydete bastiktan sonra ikinci kez kaydete basilirsa veriler bozuluyor !!!
//                                    //$v = $targetPath.'/'.$v;
//                                }
//
//                                $pcp = new PageComponentProperty();
//                                $pcp->PageComponentID = $pageComponent->PageComponentID;
//                                $pcp->Name = $name;
//                                $pcp->Value = $v;
//                                $pcp->StatusID = eStatus::Active;
//                                $pcp->CreatorUserID = $currentUser->UserID;
//                                $pcp->DateCreated = new DateTime();
//                                $pcp->ProcessUserID = $currentUser->UserID;
//                                $pcp->ProcessDate = new DateTime();
//                                $pcp->ProcessTypeID = eProcessTypes::Insert;
//                                $pcp->save();
//
//                                $index = $index + 1;
//                            }
//                        }
//                    } else {
//                        if (($name == 'file' || $name == 'filename' || $name == 'filename2' || $name == 'posterimagename' || $name == 'modaliconname') && Str::length($value) > 0) {
//                            $sourcePath = 'files/temp';
//                            $sourcePathFull = path('public') . $sourcePath;
//                            $sourceFile = $value;
//                            $sourceFileNameFull = $sourcePathFull . '/' . $sourceFile;
//
//                            $targetPath = 'files/customer_' . $customerID . '/application_' . $applicationID . '/content_' . $contentID . '/file_' . $contentFileID . '/output/comp_' . $pageComponent->PageComponentID;
//                            $targetPathFull = path('public') . $targetPath;
//                            $targetFile = $currentUser->UserID . '_' . date("YmdHis") . '_' . $value;
//                            $targetFileNameFull = $targetPathFull . '/' . $targetFile;
//
//                            if (!File::exists($targetPathFull)) {
//                                File::mkdir($targetPathFull);
//                            }
//
//                            if (File::exists($sourceFileNameFull)) {
//                                File::move($sourceFileNameFull, $targetFileNameFull);
//                                $value = $targetPath . '/' . $targetFile;
//                            } else {
//                                $oldValue = DB::table('PageComponentProperty')
//                                    ->where('PageComponentID', '=', $pageComponent->PageComponentID)
//                                    ->where('Name', '=', $name)
//                                    ->where('StatusID', '=', eStatus::Deleted)
//                                    ->order_by('PageComponentPropertyID', 'DESC')
//                                    ->first(array('Value'));
//
//                                if ($oldValue) {
//                                    $value = $oldValue->Value;
//                                } else {
//                                    $value = $targetPath . '/' . $value;
//                                }
//                                //TODO:kaydete bastiktan sonra ikinci kez kaydete basilirsa veriler bozuluyor !!!
//                                //$value = $targetPath.'/'.$value;
//                            }
//                        }
//
//                        if ($name == 'url' && !Common::startsWith($value, 'http://') && !Common::startsWith($value, 'https://') && !empty($value)) {
//                            $value = 'http://' . $value;
//                        }
//                        $value = str_replace("www.youtube.com/watch?v=", "www.youtube.com/embed/", $value);
//
//                        $pcp = new PageComponentProperty();
//                        $pcp->PageComponentID = $pageComponent->PageComponentID;
//                        $pcp->Name = $name;
//                        $pcp->Value = $value;
//                        $pcp->StatusID = eStatus::Active;
//                        $pcp->CreatorUserID = $currentUser->UserID;
//                        $pcp->DateCreated = new DateTime();
//                        $pcp->ProcessUserID = $currentUser->UserID;
//                        $pcp->ProcessDate = new DateTime();
//                        $pcp->ProcessTypeID = eProcessTypes::Insert;
//                        $pcp->save();
//                    }
//
//                }
//            }
//        }
//

    }
}
