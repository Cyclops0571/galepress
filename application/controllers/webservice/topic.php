<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 18.10.2016
 * Time: 18:25
 */
class Webservice_Topic_Controller extends Controller
{
    public $restful = false;

    public function action_topic($serviceVersion)
    {
        return webService::render(function () use ($serviceVersion) {
            webService::checkServiceVersion($serviceVersion);
            $topicID = Input::get('topicID', 1);
            $sql = "SELECT tmp.*, Application.Name AS ApplicationName FROM 
                      (SELECT Content.*, ContentTopic.TopicID FROM Content INNER JOIN ContentTopic ON Content.ContentID = ContentTopic.ContentID
                        WHERE Content.StatusID = 1 AND 
                        Content.PublishDate < curdate() AND 
                        ContentTopic.TopicID = ? 
                        ORDER BY Content.ProcessDate DESC) tmp 
                  JOIN Application ON Application.ApplicationID = tmp.ApplicationID 
                  JOIN ApplicationTopic ON ApplicationTopic.ApplicationID = tmp.ApplicationID
                  WHERE  
                          Application.ExpirationDate > curdate() AND
                          Application.TopicStatus = ? AND 
                          Application.StatusID = ? AND 
                          ApplicationTopic.ApplicationTopicID = ?
                      GROUP BY tmp.ApplicationID";
            $results = DB::query($sql, array($topicID, eStatus::Active, eStatus::Active, $topicID));
            $response = array();
            $response["contents"] = array();
            foreach ($results as $result) {
                $content = new Content();
                Common::Cast($content, $result);
                $response["contents"][] = array_merge($content->getServiceDataDetailed($serviceVersion), array('ApplicationName' => $result->ApplicationName));
            }
            $topics = Topic::where('StatusID', '=', eStatus::Active)->order_by('Order')->get();
            $response["topics"] = array_map(function(/** @var Topic $o */$o) {return $o->getServiceData();}, $topics);
            return json_encode($response);
        });


    }

    public function action_applicationTopic($serviceVersion)
    {
        return webService::render(function () use ($serviceVersion) {
            $applicationID = Input::get("applicationID", 0);
            webService::checkServiceVersion($serviceVersion);
            $application = webService::getCheckApplication($serviceVersion, $applicationID);
            $topicID = Input::get("topicID", 1);
            $contents = Content::join('ContentTopic', 'Content.ContentID', '=', 'ContentTopic.ContentID')
                ->where('ContentTopic.TopicID', '=', $topicID)
                ->where("Content.ApplicationID", '=', $applicationID)
                ->order_by('Content.ProcessDate', "DESC")->get();

            if(empty($contents)) {
                throw eServiceError::getException(eServiceError::ContentNotFound);
            }

            $serviceData = array();
            /** @var Content[] $contents */
            foreach ($contents as $content) {
                if ($content->serveContent()) {
                    //currently ignoring buyable contents...
                    $serviceData[] = $content->getServiceData();
                }
            }

            return json_encode($serviceData);
        });
    }

}