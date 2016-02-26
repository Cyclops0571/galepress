<?php
/*
 * Copyright 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * Service definition for Logging (v2beta1).
 *
 * <p>
 * Google Cloud Logging API lets you create logs, ingest log entries, and manage
 * log sinks.</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="https://cloud.google.com/logging/docs/" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_Service_Logging extends Google_Service
{


    /**
     * Constructs the internal representation of the Logging service.
     *
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        parent::__construct($client);
        $this->rootUrl = 'https://logging.googleapis.com/';
        $this->servicePath = '';
        $this->version = 'v2beta1';
        $this->serviceName = 'logging';

    }
}


class Google_Service_Logging_LogLine extends Google_Model
{
    public $logMessage;
    public $severity;
    public $time;
    protected $internal_gapi_mappings = array();
    protected $sourceLocationType = 'Google_Service_Logging_SourceLocation';
    protected $sourceLocationDataType = '';

    public function getLogMessage()
    {
        return $this->logMessage;
    }

    public function setLogMessage($logMessage)
    {
        $this->logMessage = $logMessage;
    }

    public function getSeverity()
    {
        return $this->severity;
    }

    public function setSeverity($severity)
    {
        $this->severity = $severity;
    }

    public function setSourceLocation(Google_Service_Logging_SourceLocation $sourceLocation)
    {
        $this->sourceLocation = $sourceLocation;
    }

    public function getSourceLocation()
    {
        return $this->sourceLocation;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }
}

class Google_Service_Logging_RequestLog extends Google_Collection
{
    public $appEngineRelease;
    public $appId;
    public $cost;
    public $endTime;
    public $finished;
    public $host;
    public $httpVersion;
    public $instanceId;
    public $instanceIndex;
    public $ip;
    public $latency;
    public $megaCycles;
    public $method;
    public $moduleId;
    public $nickname;
    public $pendingTime;
    public $referrer;
    public $requestId;
    public $resource;
    public $responseSize;
    public $startTime;
    public $status;
    public $taskName;
    public $taskQueueName;
    public $traceId;
    public $urlMapEntry;
    public $userAgent;
    public $versionId;
    public $wasLoadingRequest;
    protected $collection_key = 'sourceReference';
    protected $internal_gapi_mappings = array();
    protected $lineType = 'Google_Service_Logging_LogLine';
    protected $lineDataType = 'array';
    protected $sourceReferenceType = 'Google_Service_Logging_SourceReference';
    protected $sourceReferenceDataType = 'array';

    public function getAppEngineRelease()
    {
        return $this->appEngineRelease;
    }

    public function setAppEngineRelease($appEngineRelease)
    {
        $this->appEngineRelease = $appEngineRelease;
    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function getFinished()
    {
        return $this->finished;
    }

    public function setFinished($finished)
    {
        $this->finished = $finished;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getHttpVersion()
    {
        return $this->httpVersion;
    }

    public function setHttpVersion($httpVersion)
    {
        $this->httpVersion = $httpVersion;
    }

    public function getInstanceId()
    {
        return $this->instanceId;
    }

    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;
    }

    public function getInstanceIndex()
    {
        return $this->instanceIndex;
    }

    public function setInstanceIndex($instanceIndex)
    {
        $this->instanceIndex = $instanceIndex;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function getLatency()
    {
        return $this->latency;
    }

    public function setLatency($latency)
    {
        $this->latency = $latency;
    }

    public function setLine($line)
    {
        $this->line = $line;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function getMegaCycles()
    {
        return $this->megaCycles;
    }

    public function setMegaCycles($megaCycles)
    {
        $this->megaCycles = $megaCycles;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getModuleId()
    {
        return $this->moduleId;
    }

    public function setModuleId($moduleId)
    {
        $this->moduleId = $moduleId;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getPendingTime()
    {
        return $this->pendingTime;
    }

    public function setPendingTime($pendingTime)
    {
        $this->pendingTime = $pendingTime;
    }

    public function getReferrer()
    {
        return $this->referrer;
    }

    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;
    }

    public function getRequestId()
    {
        return $this->requestId;
    }

    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getResponseSize()
    {
        return $this->responseSize;
    }

    public function setResponseSize($responseSize)
    {
        $this->responseSize = $responseSize;
    }

    public function setSourceReference($sourceReference)
    {
        $this->sourceReference = $sourceReference;
    }

    public function getSourceReference()
    {
        return $this->sourceReference;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getTaskName()
    {
        return $this->taskName;
    }

    public function setTaskName($taskName)
    {
        $this->taskName = $taskName;
    }

    public function getTaskQueueName()
    {
        return $this->taskQueueName;
    }

    public function setTaskQueueName($taskQueueName)
    {
        $this->taskQueueName = $taskQueueName;
    }

    public function getTraceId()
    {
        return $this->traceId;
    }

    public function setTraceId($traceId)
    {
        $this->traceId = $traceId;
    }

    public function getUrlMapEntry()
    {
        return $this->urlMapEntry;
    }

    public function setUrlMapEntry($urlMapEntry)
    {
        $this->urlMapEntry = $urlMapEntry;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    public function getVersionId()
    {
        return $this->versionId;
    }

    public function setVersionId($versionId)
    {
        $this->versionId = $versionId;
    }

    public function getWasLoadingRequest()
    {
        return $this->wasLoadingRequest;
    }

    public function setWasLoadingRequest($wasLoadingRequest)
    {
        $this->wasLoadingRequest = $wasLoadingRequest;
    }
}

class Google_Service_Logging_SourceLocation extends Google_Model
{
    public $file;
    public $functionName;
    public $line;
    protected $internal_gapi_mappings = array();

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getFunctionName()
    {
        return $this->functionName;
    }

    public function setFunctionName($functionName)
    {
        $this->functionName = $functionName;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function setLine($line)
    {
        $this->line = $line;
    }
}

class Google_Service_Logging_SourceReference extends Google_Model
{
    public $repository;
    public $revisionId;
    protected $internal_gapi_mappings = array();

    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    public function getRevisionId()
    {
        return $this->revisionId;
    }

    public function setRevisionId($revisionId)
    {
        $this->revisionId = $revisionId;
    }
}
