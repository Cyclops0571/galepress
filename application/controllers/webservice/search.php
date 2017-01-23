<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 15.08.2016
 * Time: 12:11
 */
class Webservice_Search_Controller extends Base_Controller
{
    public $restful = true;
    public function __construct()
    {
        parent::__construct();
    }

    public function post_search() {
        $rules = array(
            "applicationID" => 'required|integer|exists:Application,ApplicationID',
            "contentID" => 'integer|exists:Content,ContentID',
            "query" => 'required'
            );
        $v = \Laravel\Validator::make(Input::all(), $rules);
        if($v->fails()) {
            return ajaxResponse::error($v->errors->first());
        }
        $url = 'http://37.9.205.205/search';
        $applicationID = Input::get('applicationID');
        $application = Application::find($applicationID);
        $contentID = Input::get('contentID', 0);
        $query = Input::get('query');
        if($contentID) {
            $id = 'customer_' . $application->CustomerID . '/application_' . $application->ApplicationID . '/content_' . $contentID;
        } else {
            $id = 'customer_' . $application->CustomerID . '/application_' . $application->ApplicationID;
        }
        $parameters = array(
            'id' => $id,
            'query' => $query,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }

    public function post_searchgraff(){
        $rules = array(
            "applicationIds" => 'required',
            "query" => 'required'
        );
        $v = \Laravel\Validator::make(Input::all(), $rules);
        if($v->fails()) {
            return ajaxResponse::error($v->errors->first());
        }
        $url = 'http://37.9.205.205/search';
        $applicationIds = json_decode(Input::get('applicationIds'));
        $applications = Application::where_in('ApplicationID', $applicationIds)->get();
        $paths = array();
        foreach ($applications as $application) {
            $paths[] = 'customer_' . $application->CustomerID . '/application_' . $application->ApplicationID;
        }
        $query = Input::get('query');

        $parameters = array(
            'id' => implode(',', $paths),
            'query' => $query,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $rawResponse = curl_exec($ch);
        curl_close($ch);
        if(empty($rawResponse)) {
            return Response::json(array());
        }
        $response = json_decode($rawResponse);

        $contentIds = array();
        if(isset($response->result)) {
            foreach ($response->result as $key => $result) {
                $contentIds[] = $result->contentId;
            }
            $availableContents = Content::getAccessibleTopicContents($contentIds);
            $availableContentsKeyWithContentID = array();

    //        var_dump($response); exit;
            array_map(function(Content $content) use (&$availableContentsKeyWithContentID) { $availableContentsKeyWithContentID[$content->ContentID] = $content->ApplicationID; }, $availableContents);
            $availableContentIds = array_map(function(Content $content){return $content->ContentID;}, $availableContents);
            //var_dump($availableContentIds); exit;
            foreach ($response->result as $key => &$result) {
    //                var_dump($response->result[$key]); exit;
                if(!in_array($result->contentId, $availableContentIds)) {
                    unset($response->result[$key]);
                } else {
                    $response->result[$key]->applicationId = $availableContentsKeyWithContentID[$response->result[$key]->contentId];
                }
            }
        } else {
            $response = array('status' => 0, 'error' => '', 'result' => array());
        }
        return Response::json($response);
    }
}