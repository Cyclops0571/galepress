<?php

class Webservice_Contents_Controller extends Base_Controller
{
    public $restful = true;

    public function get_version($serviceVersion, $contentID)
    {
        return Ws::render(function () use ($contentID) {
            $content = Ws::getContent($contentID);
            return Response::json(array(
                'status' => 0,
                'error' => "",
                'ContentID' => (int)$content->ContentID,
                'ContentBlocked' => ((int)$content->Blocked == 1 ? true : false),
                'ContentStatus' => ((int)$content->Status == 1 ? true : false),
                'ContentVersion' => (int)$content->Version
            ));
        });
    }

    public function get_detail($serviceVersion, $contentID)
    {
        return Ws::render(function () use ($contentID, $serviceVersion) {
            /** @var Content $content */
            $content = Ws::getContent($contentID, $serviceVersion);
            $categories = Ws::getContentCategories($contentID);

            if($content->ApplicationID == 10 || $content->ApplicationID == 146) {
                foreach($categories as &$category) {
                    if($category['CategoryName'] == 'Genel') {
                        $category['CategoryName'] = 'General';
                    }
                }
            }
            return Response::json(array(
                'status' => 0,
                'error' => "",
                'ContentID' => (int)$content->ContentID,
                'ContentOrderNo' => (int)$content->OrderNo,
                'ContentName' => $content->Name,
                'ContentDetail' => $content->Detail,
                'ContentCategories' => $categories,
                'ContentMonthlyName' => $content->MonthlyName,
                'ContentIsProtected' => ((int)$content->IsProtected == 1 ? true : false),
                'ContentIsBuyable' => ((int)$content->IsBuyable == 1 ? true : false),
                'ContentPrice' => '',
                'ContentCurrency' => $content->Currency(1),
                'ContentIdentifier' => $content->getIdentifier(),
                'ContentIsMaster' => ((int)$content->IsMaster == 1 ? true : false),
                'ContentOrientation' => (int)$content->Orientation,
                'ContentAutoDownload' => ((int)$content->AutoDownload == 1 ? true : false),
                'ContentBlocked' => (bool)$content->Blocked,
                'ContentStatus' => (bool)$content->Status,
                'ContentVersion' => (int)$content->Version,
                'ContentPdfVersion' => (1000 + ($content->PdfVersion === null ? 1 : (int)$content->PdfVersion)),
                'ContentCoverImageVersion' => (1000 + ($content->CoverImageVersion === null ? 1 : (int)$content->CoverImageVersion)),
                'RemoveFromMobile' => (bool)$content->RemoveFromMobile
            ));
        });
    }

    public function get_coverImage($serviceVersion, $contentID)
    {
        return Ws::render(function () use ($contentID) {

            $height = (int)Input::get('height', '0');
            $width = (int)Input::get('width', '0');
            $requestTypeID = ((int)Input::get('size', '0')) == 1 ? SMALL_IMAGE_FILE : NORMAL_IMAGE_FILE;
            $content = Ws::getContent($contentID);
            $urlPatern = Config::get('custom.url') . "/tr/icerikler/talep?W=%s&H=%s&RequestTypeID=%s&ContentID=%s";
            $url = sprintf($urlPatern, $height, $width, $requestTypeID, (int)$content->ContentID);
            return Response::json(array(
                'status' => 0,
                'error' => "",
                'ContentID' => (int)$content->ContentID,
                'Url' => $url
            ));
        });
    }

    public function get_file($serviceVersion, $contentID)
    {
        return Ws::render(function () use ($contentID) {
            $content = Ws::getContent($contentID);
            return Response::json(array(
                'status' => 0,
                'error' => "",
                'ContentID' => (int)$content->ContentID,
                'Url' => Config::get('custom.url') . "/tr/icerikler/talep?RequestTypeID=1001&ContentID=" . (int)$content->ContentID . "&Password=" . Input::get('password', '')
            ));
        });
    }
}