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
 * Service definition for Appengine (v1beta4).
 *
 * <p>
 * The Google App Engine Admin API enables developers to provision and manage
 * their App Engine applications.</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="https://developers.google.com/appengine/" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_Service_Appengine extends Google_Service
{
    /** View and manage your data across Google Cloud Platform services. */
    const CLOUD_PLATFORM =
        "https://www.googleapis.com/auth/cloud-platform";

    public $apps;
    public $apps_modules;
    public $apps_modules_versions;
    public $apps_operations;


    /**
     * Constructs the internal representation of the Appengine service.
     *
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        parent::__construct($client);
        $this->rootUrl = 'https://appengine.googleapis.com/';
        $this->servicePath = '';
        $this->version = 'v1beta4';
        $this->serviceName = 'appengine';

        $this->apps = new Google_Service_Appengine_Apps_Resource(
            $this,
            $this->serviceName,
            'apps',
            array(
                'methods' => array(
                    'get' => array(
                        'path' => 'v1beta4/apps/{appsId}',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'ensureResourcesExist' => array(
                                'location' => 'query',
                                'type' => 'boolean',
                            ),
                        ),
                    ),
                )
            )
        );
        $this->apps_modules = new Google_Service_Appengine_AppsModules_Resource(
            $this,
            $this->serviceName,
            'modules',
            array(
                'methods' => array(
                    'delete' => array(
                        'path' => 'v1beta4/apps/{appsId}/modules/{modulesId}',
                        'httpMethod' => 'DELETE',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'modulesId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ), 'get' => array(
                        'path' => 'v1beta4/apps/{appsId}/modules/{modulesId}',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'modulesId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ), 'list' => array(
                        'path' => 'v1beta4/apps/{appsId}/modules',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'pageSize' => array(
                                'location' => 'query',
                                'type' => 'integer',
                            ),
                            'pageToken' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                        ),
                    ), 'patch' => array(
                        'path' => 'v1beta4/apps/{appsId}/modules/{modulesId}',
                        'httpMethod' => 'PATCH',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'modulesId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'migrateTraffic' => array(
                                'location' => 'query',
                                'type' => 'boolean',
                            ),
                            'mask' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                        ),
                    ),
                )
            )
        );
        $this->apps_modules_versions = new Google_Service_Appengine_AppsModulesVersions_Resource(
            $this,
            $this->serviceName,
            'versions',
            array(
                'methods' => array(
                    'create' => array(
                        'path' => 'v1beta4/apps/{appsId}/modules/{modulesId}/versions',
                        'httpMethod' => 'POST',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'modulesId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ), 'delete' => array(
                        'path' => 'v1beta4/apps/{appsId}/modules/{modulesId}/versions/{versionsId}',
                        'httpMethod' => 'DELETE',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'modulesId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'versionsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ), 'get' => array(
                        'path' => 'v1beta4/apps/{appsId}/modules/{modulesId}/versions/{versionsId}',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'modulesId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'versionsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'view' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                        ),
                    ), 'list' => array(
                        'path' => 'v1beta4/apps/{appsId}/modules/{modulesId}/versions',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'modulesId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'pageToken' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                            'pageSize' => array(
                                'location' => 'query',
                                'type' => 'integer',
                            ),
                            'view' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                        ),
                    ),
                )
            )
        );
        $this->apps_operations = new Google_Service_Appengine_AppsOperations_Resource(
            $this,
            $this->serviceName,
            'operations',
            array(
                'methods' => array(
                    'get' => array(
                        'path' => 'v1beta4/apps/{appsId}/operations/{operationsId}',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'operationsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ), 'list' => array(
                        'path' => 'v1beta4/apps/{appsId}/operations',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'appsId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'filter' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                            'pageSize' => array(
                                'location' => 'query',
                                'type' => 'integer',
                            ),
                            'pageToken' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                        ),
                    ),
                )
            )
        );
    }
}


/**
 * The "apps" collection of methods.
 * Typical usage is:
 *  <code>
 *   $appengineService = new Google_Service_Appengine(...);
 *   $apps = $appengineService->apps;
 *  </code>
 */
class Google_Service_Appengine_Apps_Resource extends Google_Service_Resource
{

    /**
     * Gets information about an application. (apps.get)
     *
     * @param string $appsId Part of `name`. Name of the application to get. For
     * example: "apps/myapp".
     * @param array $optParams Optional parameters.
     *
     * @opt_param bool ensureResourcesExist Certain resources associated with an
     * application are created on-demand. Controls whether these resources should be
     * created when performing the `GET` operation. If specified and any resources
     * cloud not be created, the request will fail with an error code.
     * @return Google_Service_Appengine_Application
     */
    public function get($appsId, $optParams = array())
    {
        $params = array('appsId' => $appsId);
        $params = array_merge($params, $optParams);
        return $this->call('get', array($params), "Google_Service_Appengine_Application");
    }
}

/**
 * The "modules" collection of methods.
 * Typical usage is:
 *  <code>
 *   $appengineService = new Google_Service_Appengine(...);
 *   $modules = $appengineService->modules;
 *  </code>
 */
class Google_Service_Appengine_AppsModules_Resource extends Google_Service_Resource
{

    /**
     * Deletes a module and all enclosed versions. (modules.delete)
     *
     * @param string $appsId Part of `name`. Name of the resource requested. For
     * example: "apps/myapp/modules/default".
     * @param string $modulesId Part of `name`. See documentation of `appsId`.
     * @param array $optParams Optional parameters.
     * @return Google_Service_Appengine_Operation
     */
    public function delete($appsId, $modulesId, $optParams = array())
    {
        $params = array('appsId' => $appsId, 'modulesId' => $modulesId);
        $params = array_merge($params, $optParams);
        return $this->call('delete', array($params), "Google_Service_Appengine_Operation");
    }

    /**
     * Gets the current configuration of the module. (modules.get)
     *
     * @param string $appsId Part of `name`. Name of the resource requested. For
     * example: "apps/myapp/modules/default".
     * @param string $modulesId Part of `name`. See documentation of `appsId`.
     * @param array $optParams Optional parameters.
     * @return Google_Service_Appengine_Module
     */
    public function get($appsId, $modulesId, $optParams = array())
    {
        $params = array('appsId' => $appsId, 'modulesId' => $modulesId);
        $params = array_merge($params, $optParams);
        return $this->call('get', array($params), "Google_Service_Appengine_Module");
    }

    /**
     * Lists all the modules in the application. (modules.listAppsModules)
     *
     * @param string $appsId Part of `name`. Name of the resource requested. For
     * example: "apps/myapp".
     * @param array $optParams Optional parameters.
     *
     * @opt_param int pageSize Maximum results to return per page.
     * @opt_param string pageToken Continuation token for fetching the next page of
     * results.
     * @return Google_Service_Appengine_ListModulesResponse
     */
    public function listAppsModules($appsId, $optParams = array())
    {
        $params = array('appsId' => $appsId);
        $params = array_merge($params, $optParams);
        return $this->call('list', array($params), "Google_Service_Appengine_ListModulesResponse");
    }

    /**
     * Updates the configuration of the specified module. (modules.patch)
     *
     * @param string $appsId Part of `name`. Name of the resource to update. For
     * example: "apps/myapp/modules/default".
     * @param string $modulesId Part of `name`. See documentation of `appsId`.
     * @param Google_Module $postBody
     * @param array $optParams Optional parameters.
     *
     * @opt_param bool migrateTraffic Whether to use Traffic Migration to shift
     * traffic gradually. Traffic can only be migrated from a single version to
     * another single version.
     * @opt_param string mask Standard field mask for the set of fields to be
     * updated.
     * @return Google_Service_Appengine_Operation
     */
    public function patch($appsId, $modulesId, Google_Service_Appengine_Module $postBody, $optParams = array())
    {
        $params = array('appsId' => $appsId, 'modulesId' => $modulesId, 'postBody' => $postBody);
        $params = array_merge($params, $optParams);
        return $this->call('patch', array($params), "Google_Service_Appengine_Operation");
    }
}

/**
 * The "versions" collection of methods.
 * Typical usage is:
 *  <code>
 *   $appengineService = new Google_Service_Appengine(...);
 *   $versions = $appengineService->versions;
 *  </code>
 */
class Google_Service_Appengine_AppsModulesVersions_Resource extends Google_Service_Resource
{

    /**
     * Deploys new code and resource files to a version. (versions.create)
     *
     * @param string $appsId Part of `name`. Name of the resource to update. For
     * example: "apps/myapp/modules/default".
     * @param string $modulesId Part of `name`. See documentation of `appsId`.
     * @param Google_Version $postBody
     * @param array $optParams Optional parameters.
     * @return Google_Service_Appengine_Operation
     */
    public function create($appsId, $modulesId, Google_Service_Appengine_Version $postBody, $optParams = array())
    {
        $params = array('appsId' => $appsId, 'modulesId' => $modulesId, 'postBody' => $postBody);
        $params = array_merge($params, $optParams);
        return $this->call('create', array($params), "Google_Service_Appengine_Operation");
    }

    /**
     * Deletes an existing version. (versions.delete)
     *
     * @param string $appsId Part of `name`. Name of the resource requested. For
     * example: "apps/myapp/modules/default/versions/v1".
     * @param string $modulesId Part of `name`. See documentation of `appsId`.
     * @param string $versionsId Part of `name`. See documentation of `appsId`.
     * @param array $optParams Optional parameters.
     * @return Google_Service_Appengine_Operation
     */
    public function delete($appsId, $modulesId, $versionsId, $optParams = array())
    {
        $params = array('appsId' => $appsId, 'modulesId' => $modulesId, 'versionsId' => $versionsId);
        $params = array_merge($params, $optParams);
        return $this->call('delete', array($params), "Google_Service_Appengine_Operation");
    }

    /**
     * Gets application deployment information. (versions.get)
     *
     * @param string $appsId Part of `name`. Name of the resource requested. For
     * example: "apps/myapp/modules/default/versions/v1".
     * @param string $modulesId Part of `name`. See documentation of `appsId`.
     * @param string $versionsId Part of `name`. See documentation of `appsId`.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string view Controls the set of fields returned in the `Get`
     * response.
     * @return Google_Service_Appengine_Version
     */
    public function get($appsId, $modulesId, $versionsId, $optParams = array())
    {
        $params = array('appsId' => $appsId, 'modulesId' => $modulesId, 'versionsId' => $versionsId);
        $params = array_merge($params, $optParams);
        return $this->call('get', array($params), "Google_Service_Appengine_Version");
    }

    /**
     * Lists the versions of a module. (versions.listAppsModulesVersions)
     *
     * @param string $appsId Part of `name`. Name of the resource requested. For
     * example: "apps/myapp/modules/default".
     * @param string $modulesId Part of `name`. See documentation of `appsId`.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string pageToken Continuation token for fetching the next page of
     * results.
     * @opt_param int pageSize Maximum results to return per page.
     * @opt_param string view Controls the set of fields returned in the `List`
     * response.
     * @return Google_Service_Appengine_ListVersionsResponse
     */
    public function listAppsModulesVersions($appsId, $modulesId, $optParams = array())
    {
        $params = array('appsId' => $appsId, 'modulesId' => $modulesId);
        $params = array_merge($params, $optParams);
        return $this->call('list', array($params), "Google_Service_Appengine_ListVersionsResponse");
    }
}

/**
 * The "operations" collection of methods.
 * Typical usage is:
 *  <code>
 *   $appengineService = new Google_Service_Appengine(...);
 *   $operations = $appengineService->operations;
 *  </code>
 */
class Google_Service_Appengine_AppsOperations_Resource extends Google_Service_Resource
{

    /**
     * Gets the latest state of a long-running operation. Clients can use this
     * method to poll the operation result at intervals as recommended by the API
     * service. (operations.get)
     *
     * @param string $appsId Part of `name`. The name of the operation resource.
     * @param string $operationsId Part of `name`. See documentation of `appsId`.
     * @param array $optParams Optional parameters.
     * @return Google_Service_Appengine_Operation
     */
    public function get($appsId, $operationsId, $optParams = array())
    {
        $params = array('appsId' => $appsId, 'operationsId' => $operationsId);
        $params = array_merge($params, $optParams);
        return $this->call('get', array($params), "Google_Service_Appengine_Operation");
    }

    /**
     * Lists operations that match the specified filter in the request. If the
     * server doesn't support this method, it returns `UNIMPLEMENTED`. NOTE: the
     * `name` binding below allows API services to override the binding to use
     * different resource name schemes, such as `users/operations`.
     * (operations.listAppsOperations)
     *
     * @param string $appsId Part of `name`. The name of the operation collection.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string filter The standard list filter.
     * @opt_param int pageSize The standard list page size.
     * @opt_param string pageToken The standard list page token.
     * @return Google_Service_Appengine_ListOperationsResponse
     */
    public function listAppsOperations($appsId, $optParams = array())
    {
        $params = array('appsId' => $appsId);
        $params = array_merge($params, $optParams);
        return $this->call('list', array($params), "Google_Service_Appengine_ListOperationsResponse");
    }
}


class Google_Service_Appengine_ApiConfigHandler extends Google_Model
{
    public $authFailAction;
    public $login;
    public $script;
    public $securityLevel;
    public $url;
    protected $internal_gapi_mappings = array();

    public function getAuthFailAction()
    {
        return $this->authFailAction;
    }

    public function setAuthFailAction($authFailAction)
    {
        $this->authFailAction = $authFailAction;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getScript()
    {
        return $this->script;
    }

    public function setScript($script)
    {
        $this->script = $script;
    }

    public function getSecurityLevel()
    {
        return $this->securityLevel;
    }

    public function setSecurityLevel($securityLevel)
    {
        $this->securityLevel = $securityLevel;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
}

class Google_Service_Appengine_ApiEndpointHandler extends Google_Model
{
    public $scriptPath;
    protected $internal_gapi_mappings = array();

    public function getScriptPath()
    {
        return $this->scriptPath;
    }

    public function setScriptPath($scriptPath)
    {
        $this->scriptPath = $scriptPath;
    }
}

class Google_Service_Appengine_Application extends Google_Collection
{
    public $codeBucket;
    public $id;
    public $location;
    public $name;
    protected $collection_key = 'dispatchRules';
    protected $internal_gapi_mappings = array();
    protected $dispatchRulesType = 'Google_Service_Appengine_UrlDispatchRule';
    protected $dispatchRulesDataType = 'array';

    public function getCodeBucket()
    {
        return $this->codeBucket;
    }

    public function setCodeBucket($codeBucket)
    {
        $this->codeBucket = $codeBucket;
    }

    public function setDispatchRules($dispatchRules)
    {
        $this->dispatchRules = $dispatchRules;
    }

    public function getDispatchRules()
    {
        return $this->dispatchRules;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

class Google_Service_Appengine_AutomaticScaling extends Google_Model
{
    public $coolDownPeriod;
    public $maxConcurrentRequests;
    public $maxIdleInstances;
    public $maxPendingLatency;
    public $maxTotalInstances;
    public $minIdleInstances;
    public $minPendingLatency;
    public $minTotalInstances;
    protected $internal_gapi_mappings = array();
    protected $cpuUtilizationType = 'Google_Service_Appengine_CpuUtilization';
    protected $cpuUtilizationDataType = '';

    public function getCoolDownPeriod()
    {
        return $this->coolDownPeriod;
    }

    public function setCoolDownPeriod($coolDownPeriod)
    {
        $this->coolDownPeriod = $coolDownPeriod;
    }

    public function setCpuUtilization(Google_Service_Appengine_CpuUtilization $cpuUtilization)
    {
        $this->cpuUtilization = $cpuUtilization;
    }

    public function getCpuUtilization()
    {
        return $this->cpuUtilization;
    }

    public function getMaxConcurrentRequests()
    {
        return $this->maxConcurrentRequests;
    }

    public function setMaxConcurrentRequests($maxConcurrentRequests)
    {
        $this->maxConcurrentRequests = $maxConcurrentRequests;
    }

    public function getMaxIdleInstances()
    {
        return $this->maxIdleInstances;
    }

    public function setMaxIdleInstances($maxIdleInstances)
    {
        $this->maxIdleInstances = $maxIdleInstances;
    }

    public function getMaxPendingLatency()
    {
        return $this->maxPendingLatency;
    }

    public function setMaxPendingLatency($maxPendingLatency)
    {
        $this->maxPendingLatency = $maxPendingLatency;
    }

    public function getMaxTotalInstances()
    {
        return $this->maxTotalInstances;
    }

    public function setMaxTotalInstances($maxTotalInstances)
    {
        $this->maxTotalInstances = $maxTotalInstances;
    }

    public function getMinIdleInstances()
    {
        return $this->minIdleInstances;
    }

    public function setMinIdleInstances($minIdleInstances)
    {
        $this->minIdleInstances = $minIdleInstances;
    }

    public function getMinPendingLatency()
    {
        return $this->minPendingLatency;
    }

    public function setMinPendingLatency($minPendingLatency)
    {
        $this->minPendingLatency = $minPendingLatency;
    }

    public function getMinTotalInstances()
    {
        return $this->minTotalInstances;
    }

    public function setMinTotalInstances($minTotalInstances)
    {
        $this->minTotalInstances = $minTotalInstances;
    }
}

class Google_Service_Appengine_BasicScaling extends Google_Model
{
    public $idleTimeout;
    public $maxInstances;
    protected $internal_gapi_mappings = array();

    public function getIdleTimeout()
    {
        return $this->idleTimeout;
    }

    public function setIdleTimeout($idleTimeout)
    {
        $this->idleTimeout = $idleTimeout;
    }

    public function getMaxInstances()
    {
        return $this->maxInstances;
    }

    public function setMaxInstances($maxInstances)
    {
        $this->maxInstances = $maxInstances;
    }
}

class Google_Service_Appengine_ContainerInfo extends Google_Model
{
    public $image;
    protected $internal_gapi_mappings = array();

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }
}

class Google_Service_Appengine_CpuUtilization extends Google_Model
{
    public $aggregationWindowLength;
    public $targetUtilization;
    protected $internal_gapi_mappings = array();

    public function getAggregationWindowLength()
    {
        return $this->aggregationWindowLength;
    }

    public function setAggregationWindowLength($aggregationWindowLength)
    {
        $this->aggregationWindowLength = $aggregationWindowLength;
    }

    public function getTargetUtilization()
    {
        return $this->targetUtilization;
    }

    public function setTargetUtilization($targetUtilization)
    {
        $this->targetUtilization = $targetUtilization;
    }
}

class Google_Service_Appengine_Deployment extends Google_Collection
{
    protected $collection_key = 'sourceReferences';
    protected $internal_gapi_mappings = array();
    protected $containerType = 'Google_Service_Appengine_ContainerInfo';
    protected $containerDataType = '';
    protected $filesType = 'Google_Service_Appengine_FileInfo';
    protected $filesDataType = 'map';
    protected $sourceReferencesType = 'Google_Service_Appengine_SourceReference';
    protected $sourceReferencesDataType = 'array';


    public function setContainer(Google_Service_Appengine_ContainerInfo $container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setFiles($files)
    {
        $this->files = $files;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function setSourceReferences($sourceReferences)
    {
        $this->sourceReferences = $sourceReferences;
    }

    public function getSourceReferences()
    {
        return $this->sourceReferences;
    }
}

class Google_Service_Appengine_DeploymentFiles extends Google_Model
{
}

class Google_Service_Appengine_ErrorHandler extends Google_Model
{
    public $errorCode;
    public $mimeType;
    public $staticFile;
    protected $internal_gapi_mappings = array();

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function getStaticFile()
    {
        return $this->staticFile;
    }

    public function setStaticFile($staticFile)
    {
        $this->staticFile = $staticFile;
    }
}

class Google_Service_Appengine_FileInfo extends Google_Model
{
    public $mimeType;
    public $sha1Sum;
    public $sourceUrl;
    protected $internal_gapi_mappings = array();

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function getSha1Sum()
    {
        return $this->sha1Sum;
    }

    public function setSha1Sum($sha1Sum)
    {
        $this->sha1Sum = $sha1Sum;
    }

    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    public function setSourceUrl($sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;
    }
}

class Google_Service_Appengine_HealthCheck extends Google_Model
{
    public $checkInterval;
    public $disableHealthCheck;
    public $healthyThreshold;
    public $host;
    public $restartThreshold;
    public $timeout;
    public $unhealthyThreshold;
    protected $internal_gapi_mappings = array();

    public function getCheckInterval()
    {
        return $this->checkInterval;
    }

    public function setCheckInterval($checkInterval)
    {
        $this->checkInterval = $checkInterval;
    }

    public function getDisableHealthCheck()
    {
        return $this->disableHealthCheck;
    }

    public function setDisableHealthCheck($disableHealthCheck)
    {
        $this->disableHealthCheck = $disableHealthCheck;
    }

    public function getHealthyThreshold()
    {
        return $this->healthyThreshold;
    }

    public function setHealthyThreshold($healthyThreshold)
    {
        $this->healthyThreshold = $healthyThreshold;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getRestartThreshold()
    {
        return $this->restartThreshold;
    }

    public function setRestartThreshold($restartThreshold)
    {
        $this->restartThreshold = $restartThreshold;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    public function getUnhealthyThreshold()
    {
        return $this->unhealthyThreshold;
    }

    public function setUnhealthyThreshold($unhealthyThreshold)
    {
        $this->unhealthyThreshold = $unhealthyThreshold;
    }
}

class Google_Service_Appengine_Library extends Google_Model
{
    public $name;
    public $version;
    protected $internal_gapi_mappings = array();

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }
}

class Google_Service_Appengine_ListModulesResponse extends Google_Collection
{
    public $nextPageToken;
    protected $collection_key = 'modules';
    protected $internal_gapi_mappings = array();
    protected $modulesType = 'Google_Service_Appengine_Module';
    protected $modulesDataType = 'array';

    public function setModules($modules)
    {
        $this->modules = $modules;
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }

    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
}

class Google_Service_Appengine_ListOperationsResponse extends Google_Collection
{
    public $nextPageToken;
    protected $collection_key = 'operations';
    protected $internal_gapi_mappings = array();
    protected $operationsType = 'Google_Service_Appengine_Operation';
    protected $operationsDataType = 'array';

    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }

    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }

    public function setOperations($operations)
    {
        $this->operations = $operations;
    }

    public function getOperations()
    {
        return $this->operations;
    }
}

class Google_Service_Appengine_ListVersionsResponse extends Google_Collection
{
    public $nextPageToken;
    protected $collection_key = 'versions';
    protected $internal_gapi_mappings = array();
    protected $versionsType = 'Google_Service_Appengine_Version';
    protected $versionsDataType = 'array';

    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }

    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }

    public function setVersions($versions)
    {
        $this->versions = $versions;
    }

    public function getVersions()
    {
        return $this->versions;
    }
}

class Google_Service_Appengine_ManualScaling extends Google_Model
{
    public $instances;
    protected $internal_gapi_mappings = array();

    public function getInstances()
    {
        return $this->instances;
    }

    public function setInstances($instances)
    {
        $this->instances = $instances;
    }
}

class Google_Service_Appengine_Module extends Google_Model
{
    public $id;
    public $name;
    protected $internal_gapi_mappings = array();
    protected $splitType = 'Google_Service_Appengine_TrafficSplit';
    protected $splitDataType = '';

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSplit(Google_Service_Appengine_TrafficSplit $split)
    {
        $this->split = $split;
    }

    public function getSplit()
    {
        return $this->split;
    }
}

class Google_Service_Appengine_Network extends Google_Collection
{
    public $forwardedPorts;
    public $instanceTag;
    public $name;
    protected $collection_key = 'forwardedPorts';
    protected $internal_gapi_mappings = array();

    public function getForwardedPorts()
    {
        return $this->forwardedPorts;
    }

    public function setForwardedPorts($forwardedPorts)
    {
        $this->forwardedPorts = $forwardedPorts;
    }

    public function getInstanceTag()
    {
        return $this->instanceTag;
    }

    public function setInstanceTag($instanceTag)
    {
        $this->instanceTag = $instanceTag;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

class Google_Service_Appengine_Operation extends Google_Model
{
    public $done;
    public $metadata;
    public $name;
    public $response;
    protected $internal_gapi_mappings = array();
    protected $errorType = 'Google_Service_Appengine_Status';
    protected $errorDataType = '';

    public function getDone()
    {
        return $this->done;
    }

    public function setDone($done)
    {
        $this->done = $done;
    }

    public function setError(Google_Service_Appengine_Status $error)
    {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }
}

class Google_Service_Appengine_OperationMetadata extends Google_Model
{
    public $endTime;
    public $insertTime;
    public $method;
    public $operationType;
    public $target;
    public $user;
    protected $internal_gapi_mappings = array();

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function getInsertTime()
    {
        return $this->insertTime;
    }

    public function setInsertTime($insertTime)
    {
        $this->insertTime = $insertTime;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getOperationType()
    {
        return $this->operationType;
    }

    public function setOperationType($operationType)
    {
        $this->operationType = $operationType;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
}

class Google_Service_Appengine_OperationResponse extends Google_Model
{
}

class Google_Service_Appengine_Resources extends Google_Model
{
    public $cpu;
    public $diskGb;
    public $memoryGb;
    protected $internal_gapi_mappings = array();

    public function getCpu()
    {
        return $this->cpu;
    }

    public function setCpu($cpu)
    {
        $this->cpu = $cpu;
    }

    public function getDiskGb()
    {
        return $this->diskGb;
    }

    public function setDiskGb($diskGb)
    {
        $this->diskGb = $diskGb;
    }

    public function getMemoryGb()
    {
        return $this->memoryGb;
    }

    public function setMemoryGb($memoryGb)
    {
        $this->memoryGb = $memoryGb;
    }
}

class Google_Service_Appengine_ScriptHandler extends Google_Model
{
    public $scriptPath;
    protected $internal_gapi_mappings = array();

    public function getScriptPath()
    {
        return $this->scriptPath;
    }

    public function setScriptPath($scriptPath)
    {
        $this->scriptPath = $scriptPath;
    }
}

class Google_Service_Appengine_SourceReference extends Google_Model
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

class Google_Service_Appengine_StaticDirectoryHandler extends Google_Model
{
    public $applicationReadable;
    public $directory;
    public $expiration;
    public $httpHeaders;
    public $mimeType;
    public $requireMatchingFile;
    protected $internal_gapi_mappings = array();

    public function getApplicationReadable()
    {
        return $this->applicationReadable;
    }

    public function setApplicationReadable($applicationReadable)
    {
        $this->applicationReadable = $applicationReadable;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    public function getExpiration()
    {
        return $this->expiration;
    }

    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
    }

    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }

    public function setHttpHeaders($httpHeaders)
    {
        $this->httpHeaders = $httpHeaders;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function getRequireMatchingFile()
    {
        return $this->requireMatchingFile;
    }

    public function setRequireMatchingFile($requireMatchingFile)
    {
        $this->requireMatchingFile = $requireMatchingFile;
    }
}

class Google_Service_Appengine_StaticDirectoryHandlerHttpHeaders extends Google_Model
{
}

class Google_Service_Appengine_StaticFilesHandler extends Google_Model
{
    public $applicationReadable;
    public $expiration;
    public $httpHeaders;
    public $mimeType;
    public $path;
    public $requireMatchingFile;
    public $uploadPathRegex;
    protected $internal_gapi_mappings = array();

    public function getApplicationReadable()
    {
        return $this->applicationReadable;
    }

    public function setApplicationReadable($applicationReadable)
    {
        $this->applicationReadable = $applicationReadable;
    }

    public function getExpiration()
    {
        return $this->expiration;
    }

    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
    }

    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }

    public function setHttpHeaders($httpHeaders)
    {
        $this->httpHeaders = $httpHeaders;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getRequireMatchingFile()
    {
        return $this->requireMatchingFile;
    }

    public function setRequireMatchingFile($requireMatchingFile)
    {
        $this->requireMatchingFile = $requireMatchingFile;
    }

    public function getUploadPathRegex()
    {
        return $this->uploadPathRegex;
    }

    public function setUploadPathRegex($uploadPathRegex)
    {
        $this->uploadPathRegex = $uploadPathRegex;
    }
}

class Google_Service_Appengine_StaticFilesHandlerHttpHeaders extends Google_Model
{
}

class Google_Service_Appengine_Status extends Google_Collection
{
    public $code;
    public $details;
    public $message;
    protected $collection_key = 'details';
    protected $internal_gapi_mappings = array();

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function setDetails($details)
    {
        $this->details = $details;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}

class Google_Service_Appengine_StatusDetails extends Google_Model
{
}

class Google_Service_Appengine_TrafficSplit extends Google_Model
{
    public $allocations;
    public $shardBy;
    protected $internal_gapi_mappings = array();

    public function getAllocations()
    {
        return $this->allocations;
    }

    public function setAllocations($allocations)
    {
        $this->allocations = $allocations;
    }

    public function getShardBy()
    {
        return $this->shardBy;
    }

    public function setShardBy($shardBy)
    {
        $this->shardBy = $shardBy;
    }
}

class Google_Service_Appengine_TrafficSplitAllocations extends Google_Model
{
}

class Google_Service_Appengine_UrlDispatchRule extends Google_Model
{
    public $domain;
    public $module;
    public $path;
    protected $internal_gapi_mappings = array();

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setModule($module)
    {
        $this->module = $module;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }
}

class Google_Service_Appengine_UrlMap extends Google_Model
{
    public $authFailAction;
    public $login;
    public $redirectHttpResponseCode;
    public $securityLevel;
    public $urlRegex;
    protected $internal_gapi_mappings = array();
    protected $apiEndpointType = 'Google_Service_Appengine_ApiEndpointHandler';
    protected $apiEndpointDataType = '';
    protected $scriptType = 'Google_Service_Appengine_ScriptHandler';
    protected $scriptDataType = '';
    protected $staticDirectoryType = 'Google_Service_Appengine_StaticDirectoryHandler';
    protected $staticDirectoryDataType = '';
    protected $staticFilesType = 'Google_Service_Appengine_StaticFilesHandler';
    protected $staticFilesDataType = '';

    public function setApiEndpoint(Google_Service_Appengine_ApiEndpointHandler $apiEndpoint)
    {
        $this->apiEndpoint = $apiEndpoint;
    }

    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    public function getAuthFailAction()
    {
        return $this->authFailAction;
    }

    public function setAuthFailAction($authFailAction)
    {
        $this->authFailAction = $authFailAction;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getRedirectHttpResponseCode()
    {
        return $this->redirectHttpResponseCode;
    }

    public function setRedirectHttpResponseCode($redirectHttpResponseCode)
    {
        $this->redirectHttpResponseCode = $redirectHttpResponseCode;
    }

    public function setScript(Google_Service_Appengine_ScriptHandler $script)
    {
        $this->script = $script;
    }

    public function getScript()
    {
        return $this->script;
    }

    public function getSecurityLevel()
    {
        return $this->securityLevel;
    }

    public function setSecurityLevel($securityLevel)
    {
        $this->securityLevel = $securityLevel;
    }

    public function setStaticDirectory(Google_Service_Appengine_StaticDirectoryHandler $staticDirectory)
    {
        $this->staticDirectory = $staticDirectory;
    }

    public function getStaticDirectory()
    {
        return $this->staticDirectory;
    }

    public function setStaticFiles(Google_Service_Appengine_StaticFilesHandler $staticFiles)
    {
        $this->staticFiles = $staticFiles;
    }

    public function getStaticFiles()
    {
        return $this->staticFiles;
    }

    public function getUrlRegex()
    {
        return $this->urlRegex;
    }

    public function setUrlRegex($urlRegex)
    {
        $this->urlRegex = $urlRegex;
    }
}

class Google_Service_Appengine_Version extends Google_Collection
{
    public $betaSettings;
    public $creationTime;
    public $defaultExpiration;
    public $deployer;
    public $env;
    public $envVariables;
    public $id;
    public $inboundServices;
    public $instanceClass;
    public $name;
    public $nobuildFilesRegex;
    public $runtime;
    public $servingStatus;
    public $threadsafe;
    public $vm;
    protected $collection_key = 'libraries';
    protected $internal_gapi_mappings = array();
    protected $apiConfigType = 'Google_Service_Appengine_ApiConfigHandler';
    protected $apiConfigDataType = '';
    protected $automaticScalingType = 'Google_Service_Appengine_AutomaticScaling';
    protected $automaticScalingDataType = '';
    protected $basicScalingType = 'Google_Service_Appengine_BasicScaling';
    protected $basicScalingDataType = '';
    protected $deploymentType = 'Google_Service_Appengine_Deployment';
    protected $deploymentDataType = '';
    protected $errorHandlersType = 'Google_Service_Appengine_ErrorHandler';
    protected $errorHandlersDataType = 'array';
    protected $handlersType = 'Google_Service_Appengine_UrlMap';
    protected $handlersDataType = 'array';
    protected $healthCheckType = 'Google_Service_Appengine_HealthCheck';
    protected $healthCheckDataType = '';
    protected $librariesType = 'Google_Service_Appengine_Library';
    protected $librariesDataType = 'array';
    protected $manualScalingType = 'Google_Service_Appengine_ManualScaling';
    protected $manualScalingDataType = '';
    protected $networkType = 'Google_Service_Appengine_Network';
    protected $networkDataType = '';
    protected $resourcesType = 'Google_Service_Appengine_Resources';
    protected $resourcesDataType = '';

    public function setApiConfig(Google_Service_Appengine_ApiConfigHandler $apiConfig)
    {
        $this->apiConfig = $apiConfig;
    }

    public function getApiConfig()
    {
        return $this->apiConfig;
    }

    public function setAutomaticScaling(Google_Service_Appengine_AutomaticScaling $automaticScaling)
    {
        $this->automaticScaling = $automaticScaling;
    }

    public function getAutomaticScaling()
    {
        return $this->automaticScaling;
    }

    public function setBasicScaling(Google_Service_Appengine_BasicScaling $basicScaling)
    {
        $this->basicScaling = $basicScaling;
    }

    public function getBasicScaling()
    {
        return $this->basicScaling;
    }

    public function getBetaSettings()
    {
        return $this->betaSettings;
    }

    public function setBetaSettings($betaSettings)
    {
        $this->betaSettings = $betaSettings;
    }

    public function getCreationTime()
    {
        return $this->creationTime;
    }

    public function setCreationTime($creationTime)
    {
        $this->creationTime = $creationTime;
    }

    public function getDefaultExpiration()
    {
        return $this->defaultExpiration;
    }

    public function setDefaultExpiration($defaultExpiration)
    {
        $this->defaultExpiration = $defaultExpiration;
    }

    public function getDeployer()
    {
        return $this->deployer;
    }

    public function setDeployer($deployer)
    {
        $this->deployer = $deployer;
    }

    public function setDeployment(Google_Service_Appengine_Deployment $deployment)
    {
        $this->deployment = $deployment;
    }

    public function getDeployment()
    {
        return $this->deployment;
    }

    public function getEnv()
    {
        return $this->env;
    }

    public function setEnv($env)
    {
        $this->env = $env;
    }

    public function getEnvVariables()
    {
        return $this->envVariables;
    }

    public function setEnvVariables($envVariables)
    {
        $this->envVariables = $envVariables;
    }

    public function setErrorHandlers($errorHandlers)
    {
        $this->errorHandlers = $errorHandlers;
    }

    public function getErrorHandlers()
    {
        return $this->errorHandlers;
    }

    public function setHandlers($handlers)
    {
        $this->handlers = $handlers;
    }

    public function getHandlers()
    {
        return $this->handlers;
    }

    public function setHealthCheck(Google_Service_Appengine_HealthCheck $healthCheck)
    {
        $this->healthCheck = $healthCheck;
    }

    public function getHealthCheck()
    {
        return $this->healthCheck;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getInboundServices()
    {
        return $this->inboundServices;
    }

    public function setInboundServices($inboundServices)
    {
        $this->inboundServices = $inboundServices;
    }

    public function getInstanceClass()
    {
        return $this->instanceClass;
    }

    public function setInstanceClass($instanceClass)
    {
        $this->instanceClass = $instanceClass;
    }

    public function setLibraries($libraries)
    {
        $this->libraries = $libraries;
    }

    public function getLibraries()
    {
        return $this->libraries;
    }

    public function setManualScaling(Google_Service_Appengine_ManualScaling $manualScaling)
    {
        $this->manualScaling = $manualScaling;
    }

    public function getManualScaling()
    {
        return $this->manualScaling;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setNetwork(Google_Service_Appengine_Network $network)
    {
        $this->network = $network;
    }

    public function getNetwork()
    {
        return $this->network;
    }

    public function getNobuildFilesRegex()
    {
        return $this->nobuildFilesRegex;
    }

    public function setNobuildFilesRegex($nobuildFilesRegex)
    {
        $this->nobuildFilesRegex = $nobuildFilesRegex;
    }

    public function setResources(Google_Service_Appengine_Resources $resources)
    {
        $this->resources = $resources;
    }

    public function getResources()
    {
        return $this->resources;
    }

    public function getRuntime()
    {
        return $this->runtime;
    }

    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;
    }

    public function getServingStatus()
    {
        return $this->servingStatus;
    }

    public function setServingStatus($servingStatus)
    {
        $this->servingStatus = $servingStatus;
    }

    public function getThreadsafe()
    {
        return $this->threadsafe;
    }

    public function setThreadsafe($threadsafe)
    {
        $this->threadsafe = $threadsafe;
    }

    public function getVm()
    {
        return $this->vm;
    }

    public function setVm($vm)
    {
        $this->vm = $vm;
    }
}

class Google_Service_Appengine_VersionBetaSettings extends Google_Model
{
}

class Google_Service_Appengine_VersionEnvVariables extends Google_Model
{
}
