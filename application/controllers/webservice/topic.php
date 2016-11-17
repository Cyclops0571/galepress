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
            $height = (int)Input::get('height', '0');
            $width = (int)Input::get('width', '0');
            $imageUrlPattern = Config::get("custom.url") . "/tr/icerikler/talep?W=%s&H=%s&RequestTypeID=%s&ContentID=%s";

            /** @var ApplicationTopic[] $applicationsWhichHaveATopics */
            $applicationsWhichHaveATopics = ApplicationTopic::group_by("ApplicationID")->get();
            $response = array();
            $response["applications"] = array();
            foreach($applicationsWhichHaveATopics as $applicationsWhichHaveATopic ) {
                $application = Application::find($applicationsWhichHaveATopic->ApplicationID);
                $responseChunk = array();
                if($application->TopicStatus != eStatus::Active) {
                    continue;
                }
                /** @var ApplicationTopic[] $topics */
                $applicationTopics = ApplicationTopic::where("ApplicationID", "=", $application->ApplicationID)->get();
                $responseChunk["Topics"] = array();
                foreach($applicationTopics as $applicationTopic) {
                    $sql = "SELECT Content.* FROM Content INNER JOIN ContentTopic ON Content.ContentID = ContentTopic.ContentID
                        WHERE Content.StatusID = 1 AND 
                        Content.PublishDate <= curdate() AND 
                        ContentTopic.TopicID = ? AND 
                        Content.ApplicationID = ?
                        ORDER BY Content.ProcessDate DESC LIMIT 0, 1";
                    $results = DB::query($sql, array($applicationTopic->TopicID, $applicationTopic->ApplicationID));
                    foreach($results as $result) {
                        $content = new Content();
                        Common::Cast($content, $result);
                        $responseTopicChunk = array();
                        $responseTopicChunk["TopicID"] = $applicationTopic->TopicID;
                        $responseTopicChunk["CoverImageUrl"] = sprintf($imageUrlPattern, $height, $width, eRequestType::SMALL_IMAGE_FILE, $content->ContentID);
                        $responseTopicChunk["Order"] = strtotime($content->ProcessDate);
                        $responseChunk["Topics"][] = $responseTopicChunk;
                    }
                }
                if(!empty($responseChunk["Topics"])) {
                    $responseChunk["ApplicationID"] = $application->ApplicationID;
                    $responseChunk["ApplicationName"] = $application->Name;
                    $responseChunk["Version"] = $application->Version;
                    $response["applications"][] = $responseChunk;
                }
            }

            $topics = Topic::where('StatusID', '=', eStatus::Active)->order_by('Order')->get();
            $response["topics"] = array_map(function(/** @var Topic $o */$o) {return $o->getServiceData();}, $topics);
            $response["status"] = 0;
            $response["error"] = "";
            return Response::json($response);
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
                    $serviceData["contents"][] = $content->getServiceData(false);
                }
            }

            $serviceData["status"] = 0;
            $serviceData["error"] = "";
            return Response::json($serviceData);
        });
    }

}