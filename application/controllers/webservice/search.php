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
            "query" => 'required'
            );
        $v = \Laravel\Validator::make(Input::all(), $rules);
        if($v->fails()) {
            return ajaxResponse::error($v->errors->first());
        }
        $url = 'http://192.168.10.9:8080/inmemory';
        $applicationID = Input::get('applicationID');
        $application = Application::find($applicationID);
        $query = Input::get('query');
        $parameters = array(
            'id' => 'customer_' . $application->CustomerID . '/application_' . $application->ApplicationID,
            'query' => $query,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }
}