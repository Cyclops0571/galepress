<?php

/**
 * Class PageComponent
 * @method static PageComponent find(int $ID)
 * @property mixed PageComponentID
 * @property int ProcessTypeID
 * @property DateTime ProcessDate
 * @property DateTime DateCreated
 * @property int StatusID
 * @property int No
 * @property int ComponentID
 * @property int ContentFilePageID
 * @property int CreatorUserID
 * @property int ProcessUserID
 * @property PageComponentProperty[] PageComponentProperty
 * @property ContentFilePage ContentFilePage
 * @property Component $Component
 */
class PageComponent extends Eloquent
{

    public static $timestamps = false;
    public static $table = 'PageComponent';
    public static $key = 'PageComponentID';
    public static $ignoredProperties = array('id', 'process', 'fileselected', 'posterimageselected', 'modaliconselected');

    public function Component()
    {
        return $this->belongs_to('Component', 'ComponentID');
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

        if ((int)$this->PageComponentID == 0) {
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
     * @param ContentFile $newContentFile
     * @param ContentFile $oldContentFile
     */
    public function moveToNewContentFile(ContentFile $newContentFile, ContentFile $oldContentFile)
    {
        $myPath = '/output/comp_' . $this->PageComponentID;
        if (File::exists($oldContentFile->pdfFolderPathAbsolute() . $myPath)) {
            File::mvdir($oldContentFile->pdfFolderPathAbsolute() . $myPath, $newContentFile->pdfFolderPathAbsolute() . $myPath);
        }
        $myHtml = $myPath . '.html';
        if (File::exists($oldContentFile->pdfFolderPathAbsolute() . $myHtml)) {
            File::move($oldContentFile->pdfFolderPathAbsolute() . $myHtml, $newContentFile->pdfFolderPathAbsolute() . $myHtml);
        }
    }

    /**
     * @return \Laravel\Database\Eloquent\Query
     */
    public function PageComponentProperty()
    {
        return $this->has_many('PageComponentProperty', self::$key)->where('StatusID', '=', eStatus::Active);
    }

    /**
     * @return \Laravel\Database\Eloquent\Query
     */
    public function ContentFilePage() {
        return $this->belongs_to('ContentFilePage', 'ContentFilePageID');
    }

}
