<?php

/**
 * @property int $ContentCoverImageFileID Description
 * @property int $ContentFileID Description
 * @property int $DateAdded Description
 * @property int $FilePath Description
 * @property int $SourceFileName Description
 * @property int $FileName Description
 * @property int $FileName2 Description
 * @property int $FileSize Description
 * @property int $StatusID Description
 * @property int $CreatorUserID Description
 * @property int $DateCreated Description
 * @property int $ProcessUserID Description
 * @property int $ProcessDate Description
 * @property int $ProcessTypeID Description
 */
class ContentCoverImageFile extends Eloquent {

	public static $timestamps = false;
	public static $table = 'ContentCoverImageFile';
	public static $key = 'ContentCoverImageFileID';

	/*
	  public function Content()
	  {
	  return $this->belongs_to('Content', 'ContentID');
	  }
	 */
}
