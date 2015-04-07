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

}
