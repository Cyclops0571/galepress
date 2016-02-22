<?php

class Template_Controller extends Base_Controller {

	public $restful = true;

	public function get_index($applicationID) {
		$application = Application::find($applicationID);
		if (!$application) {
			return Redirect::to(__('route.home'));
		}

		if (!$application->CheckOwnership()) {
			return Redirect::to(__('route.home'));
		}
		/* START SQL FOR TEMPLATE-CHOOSER */
		$sqlTemlateChooser = 'SELECT * FROM ('
            . 'SELECT a.Name AS ApplicationName, c.ContentID, c.Name, c.Detail, c.MonthlyName, '
				. 'cf.ContentFileID,cf.FilePath, cf.InteractiveFilePath, '
				. 'ccf.ContentCoverImageFileID, ccf.FileName '
				. 'FROM `Application` AS a '
				. 'LEFT JOIN `Content` AS c ON c.ApplicationID=a.ApplicationID AND c.StatusID=1 '
				. 'LEFT JOIN `ContentFile` AS cf ON c.ContentID=cf.ContentID '
				. 'LEFT JOIN `ContentCoverImageFile` AS ccf ON ccf.ContentFileID=cf.ContentFileID '
				. 'WHERE a.ApplicationID= ' . $applicationID . ' '
				. 'order by  c.ContentID DESC, cf.ContentFileID DESC, ccf.ContentCoverImageFileID DESC) as innerTable '
				. 'group by innerTable.ContentID '
				. 'order by innerTable.ContentID DESC '
				. 'LIMIT 9';

		$templateResults = DB::table(DB::raw('(' . $sqlTemlateChooser . ') t'))->order_by('ContentID', 'Desc')->get();
		$data = array();
		$data['application'] = $application;
		$data["templateResults"] = $templateResults;
        $data['bannerSet'] = Banner::getAppBanner($applicationID, FALSE);
		return View::make('sections.templatepreview', $data);
	}

}
