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
 * Service definition for Doubleclicksearch (v2).
 *
 * <p>
 * Report and modify your advertising data in DoubleClick Search (for example,
 * campaigns, ad groups, keywords, and conversions).</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="https://developers.google.com/doubleclick-search/" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_Service_Doubleclicksearch extends Google_Service
{
    /** View and manage your advertising data in DoubleClick Search. */
    const DOUBLECLICKSEARCH =
        "https://www.googleapis.com/auth/doubleclicksearch";

    public $conversion;
    public $reports;
    public $savedColumns;


    /**
     * Constructs the internal representation of the Doubleclicksearch service.
     *
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        parent::__construct($client);
        $this->rootUrl = 'https://www.googleapis.com/';
        $this->servicePath = 'doubleclicksearch/v2/';
        $this->version = 'v2';
        $this->serviceName = 'doubleclicksearch';

        $this->conversion = new Google_Service_Doubleclicksearch_Conversion_Resource(
            $this,
            $this->serviceName,
            'conversion',
            array(
                'methods' => array(
                    'get' => array(
                        'path' => 'agency/{agencyId}/advertiser/{advertiserId}/engine/{engineAccountId}/conversion',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'agencyId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'advertiserId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'engineAccountId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'endDate' => array(
                                'location' => 'query',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'rowCount' => array(
                                'location' => 'query',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'startDate' => array(
                                'location' => 'query',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'startRow' => array(
                                'location' => 'query',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'adGroupId' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                            'campaignId' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                            'adId' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                            'criterionId' => array(
                                'location' => 'query',
                                'type' => 'string',
                            ),
                        ),
                    ), 'insert' => array(
                        'path' => 'conversion',
                        'httpMethod' => 'POST',
                        'parameters' => array(),
                    ), 'patch' => array(
                        'path' => 'conversion',
                        'httpMethod' => 'PATCH',
                        'parameters' => array(
                            'advertiserId' => array(
                                'location' => 'query',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'agencyId' => array(
                                'location' => 'query',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'endDate' => array(
                                'location' => 'query',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'engineAccountId' => array(
                                'location' => 'query',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'rowCount' => array(
                                'location' => 'query',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'startDate' => array(
                                'location' => 'query',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'startRow' => array(
                                'location' => 'query',
                                'type' => 'integer',
                                'required' => true,
                            ),
                        ),
                    ), 'update' => array(
                        'path' => 'conversion',
                        'httpMethod' => 'PUT',
                        'parameters' => array(),
                    ), 'updateAvailability' => array(
                        'path' => 'conversion/updateAvailability',
                        'httpMethod' => 'POST',
                        'parameters' => array(),
                    ),
                )
            )
        );
        $this->reports = new Google_Service_Doubleclicksearch_Reports_Resource(
            $this,
            $this->serviceName,
            'reports',
            array(
                'methods' => array(
                    'generate' => array(
                        'path' => 'reports/generate',
                        'httpMethod' => 'POST',
                        'parameters' => array(),
                    ), 'get' => array(
                        'path' => 'reports/{reportId}',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'reportId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ), 'getFile' => array(
                        'path' => 'reports/{reportId}/files/{reportFragment}',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'reportId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'reportFragment' => array(
                                'location' => 'path',
                                'type' => 'integer',
                                'required' => true,
                            ),
                        ),
                    ), 'request' => array(
                        'path' => 'reports',
                        'httpMethod' => 'POST',
                        'parameters' => array(),
                    ),
                )
            )
        );
        $this->savedColumns = new Google_Service_Doubleclicksearch_SavedColumns_Resource(
            $this,
            $this->serviceName,
            'savedColumns',
            array(
                'methods' => array(
                    'list' => array(
                        'path' => 'agency/{agencyId}/advertiser/{advertiserId}/savedcolumns',
                        'httpMethod' => 'GET',
                        'parameters' => array(
                            'agencyId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'advertiserId' => array(
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ),
                )
            )
        );
    }
}


/**
 * The "conversion" collection of methods.
 * Typical usage is:
 *  <code>
 *   $doubleclicksearchService = new Google_Service_Doubleclicksearch(...);
 *   $conversion = $doubleclicksearchService->conversion;
 *  </code>
 */
class Google_Service_Doubleclicksearch_Conversion_Resource extends Google_Service_Resource
{

    /**
     * Retrieves a list of conversions from a DoubleClick Search engine account.
     * (conversion.get)
     *
     * @param string $agencyId Numeric ID of the agency.
     * @param string $advertiserId Numeric ID of the advertiser.
     * @param string $engineAccountId Numeric ID of the engine account.
     * @param int $endDate Last date (inclusive) on which to retrieve conversions.
     * Format is yyyymmdd.
     * @param int $rowCount The number of conversions to return per call.
     * @param int $startDate First date (inclusive) on which to retrieve
     * conversions. Format is yyyymmdd.
     * @param string $startRow The 0-based starting index for retrieving conversions
     * results.
     * @param array $optParams Optional parameters.
     *
     * @opt_param string adGroupId Numeric ID of the ad group.
     * @opt_param string campaignId Numeric ID of the campaign.
     * @opt_param string adId Numeric ID of the ad.
     * @opt_param string criterionId Numeric ID of the criterion.
     * @return Google_Service_Doubleclicksearch_ConversionList
     */
    public function get($agencyId, $advertiserId, $engineAccountId, $endDate, $rowCount, $startDate, $startRow, $optParams = array())
    {
        $params = array('agencyId' => $agencyId, 'advertiserId' => $advertiserId, 'engineAccountId' => $engineAccountId, 'endDate' => $endDate, 'rowCount' => $rowCount, 'startDate' => $startDate, 'startRow' => $startRow);
        $params = array_merge($params, $optParams);
        return $this->call('get', array($params), "Google_Service_Doubleclicksearch_ConversionList");
    }

    /**
     * Inserts a batch of new conversions into DoubleClick Search.
     * (conversion.insert)
     *
     * @param Google_ConversionList $postBody
     * @param array $optParams Optional parameters.
     * @return Google_Service_Doubleclicksearch_ConversionList
     */
    public function insert(Google_Service_Doubleclicksearch_ConversionList $postBody, $optParams = array())
    {
        $params = array('postBody' => $postBody);
        $params = array_merge($params, $optParams);
        return $this->call('insert', array($params), "Google_Service_Doubleclicksearch_ConversionList");
    }

    /**
     * Updates a batch of conversions in DoubleClick Search. This method supports
     * patch semantics. (conversion.patch)
     *
     * @param string $advertiserId Numeric ID of the advertiser.
     * @param string $agencyId Numeric ID of the agency.
     * @param int $endDate Last date (inclusive) on which to retrieve conversions.
     * Format is yyyymmdd.
     * @param string $engineAccountId Numeric ID of the engine account.
     * @param int $rowCount The number of conversions to return per call.
     * @param int $startDate First date (inclusive) on which to retrieve
     * conversions. Format is yyyymmdd.
     * @param string $startRow The 0-based starting index for retrieving conversions
     * results.
     * @param Google_ConversionList $postBody
     * @param array $optParams Optional parameters.
     * @return Google_Service_Doubleclicksearch_ConversionList
     */
    public function patch($advertiserId, $agencyId, $endDate, $engineAccountId, $rowCount, $startDate, $startRow, Google_Service_Doubleclicksearch_ConversionList $postBody, $optParams = array())
    {
        $params = array('advertiserId' => $advertiserId, 'agencyId' => $agencyId, 'endDate' => $endDate, 'engineAccountId' => $engineAccountId, 'rowCount' => $rowCount, 'startDate' => $startDate, 'startRow' => $startRow, 'postBody' => $postBody);
        $params = array_merge($params, $optParams);
        return $this->call('patch', array($params), "Google_Service_Doubleclicksearch_ConversionList");
    }

    /**
     * Updates a batch of conversions in DoubleClick Search. (conversion.update)
     *
     * @param Google_ConversionList $postBody
     * @param array $optParams Optional parameters.
     * @return Google_Service_Doubleclicksearch_ConversionList
     */
    public function update(Google_Service_Doubleclicksearch_ConversionList $postBody, $optParams = array())
    {
        $params = array('postBody' => $postBody);
        $params = array_merge($params, $optParams);
        return $this->call('update', array($params), "Google_Service_Doubleclicksearch_ConversionList");
    }

    /**
     * Updates the availabilities of a batch of floodlight activities in DoubleClick
     * Search. (conversion.updateAvailability)
     *
     * @param Google_UpdateAvailabilityRequest $postBody
     * @param array $optParams Optional parameters.
     * @return Google_Service_Doubleclicksearch_UpdateAvailabilityResponse
     */
    public function updateAvailability(Google_Service_Doubleclicksearch_UpdateAvailabilityRequest $postBody, $optParams = array())
    {
        $params = array('postBody' => $postBody);
        $params = array_merge($params, $optParams);
        return $this->call('updateAvailability', array($params), "Google_Service_Doubleclicksearch_UpdateAvailabilityResponse");
    }
}

/**
 * The "reports" collection of methods.
 * Typical usage is:
 *  <code>
 *   $doubleclicksearchService = new Google_Service_Doubleclicksearch(...);
 *   $reports = $doubleclicksearchService->reports;
 *  </code>
 */
class Google_Service_Doubleclicksearch_Reports_Resource extends Google_Service_Resource
{

    /**
     * Generates and returns a report immediately. (reports.generate)
     *
     * @param Google_ReportRequest $postBody
     * @param array $optParams Optional parameters.
     * @return Google_Service_Doubleclicksearch_Report
     */
    public function generate(Google_Service_Doubleclicksearch_ReportRequest $postBody, $optParams = array())
    {
        $params = array('postBody' => $postBody);
        $params = array_merge($params, $optParams);
        return $this->call('generate', array($params), "Google_Service_Doubleclicksearch_Report");
    }

    /**
     * Polls for the status of a report request. (reports.get)
     *
     * @param string $reportId ID of the report request being polled.
     * @param array $optParams Optional parameters.
     * @return Google_Service_Doubleclicksearch_Report
     */
    public function get($reportId, $optParams = array())
    {
        $params = array('reportId' => $reportId);
        $params = array_merge($params, $optParams);
        return $this->call('get', array($params), "Google_Service_Doubleclicksearch_Report");
    }

    /**
     * Downloads a report file encoded in UTF-8. (reports.getFile)
     *
     * @param string $reportId ID of the report.
     * @param int $reportFragment The index of the report fragment to download.
     * @param array $optParams Optional parameters.
     */
    public function getFile($reportId, $reportFragment, $optParams = array())
    {
        $params = array('reportId' => $reportId, 'reportFragment' => $reportFragment);
        $params = array_merge($params, $optParams);
        return $this->call('getFile', array($params));
    }

    /**
     * Inserts a report request into the reporting system. (reports.request)
     *
     * @param Google_ReportRequest $postBody
     * @param array $optParams Optional parameters.
     * @return Google_Service_Doubleclicksearch_Report
     */
    public function request(Google_Service_Doubleclicksearch_ReportRequest $postBody, $optParams = array())
    {
        $params = array('postBody' => $postBody);
        $params = array_merge($params, $optParams);
        return $this->call('request', array($params), "Google_Service_Doubleclicksearch_Report");
    }
}

/**
 * The "savedColumns" collection of methods.
 * Typical usage is:
 *  <code>
 *   $doubleclicksearchService = new Google_Service_Doubleclicksearch(...);
 *   $savedColumns = $doubleclicksearchService->savedColumns;
 *  </code>
 */
class Google_Service_Doubleclicksearch_SavedColumns_Resource extends Google_Service_Resource
{

    /**
     * Retrieve the list of saved columns for a specified advertiser.
     * (savedColumns.listSavedColumns)
     *
     * @param string $agencyId DS ID of the agency.
     * @param string $advertiserId DS ID of the advertiser.
     * @param array $optParams Optional parameters.
     * @return Google_Service_Doubleclicksearch_SavedColumnList
     */
    public function listSavedColumns($agencyId, $advertiserId, $optParams = array())
    {
        $params = array('agencyId' => $agencyId, 'advertiserId' => $advertiserId);
        $params = array_merge($params, $optParams);
        return $this->call('list', array($params), "Google_Service_Doubleclicksearch_SavedColumnList");
    }
}


class Google_Service_Doubleclicksearch_Availability extends Google_Model
{
    public $advertiserId;
    public $agencyId;
    public $availabilityTimestamp;
    public $segmentationId;
    public $segmentationName;
    public $segmentationType;
    protected $internal_gapi_mappings = array();

    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }

    public function setAdvertiserId($advertiserId)
    {
        $this->advertiserId = $advertiserId;
    }

    public function getAgencyId()
    {
        return $this->agencyId;
    }

    public function setAgencyId($agencyId)
    {
        $this->agencyId = $agencyId;
    }

    public function getAvailabilityTimestamp()
    {
        return $this->availabilityTimestamp;
    }

    public function setAvailabilityTimestamp($availabilityTimestamp)
    {
        $this->availabilityTimestamp = $availabilityTimestamp;
    }

    public function getSegmentationId()
    {
        return $this->segmentationId;
    }

    public function setSegmentationId($segmentationId)
    {
        $this->segmentationId = $segmentationId;
    }

    public function getSegmentationName()
    {
        return $this->segmentationName;
    }

    public function setSegmentationName($segmentationName)
    {
        $this->segmentationName = $segmentationName;
    }

    public function getSegmentationType()
    {
        return $this->segmentationType;
    }

    public function setSegmentationType($segmentationType)
    {
        $this->segmentationType = $segmentationType;
    }
}

class Google_Service_Doubleclicksearch_Conversion extends Google_Collection
{
    public $adGroupId;
    public $adId;
    public $advertiserId;
    public $agencyId;
    public $attributionModel;
    public $campaignId;
    public $channel;
    public $clickId;
    public $conversionId;
    public $conversionModifiedTimestamp;
    public $conversionTimestamp;
    public $countMillis;
    public $criterionId;
    public $currencyCode;
    public $deviceType;
    public $dsConversionId;
    public $engineAccountId;
    public $floodlightOrderId;
    public $inventoryAccountId;
    public $productCountry;
    public $productGroupId;
    public $productId;
    public $productLanguage;
    public $quantityMillis;
    public $revenueMicros;
    public $segmentationId;
    public $segmentationName;
    public $segmentationType;
    public $state;
    public $storeId;
    public $type;
    protected $collection_key = 'customMetric';
    protected $internal_gapi_mappings = array();
    protected $customDimensionType = 'Google_Service_Doubleclicksearch_CustomDimension';
    protected $customDimensionDataType = 'array';
    protected $customMetricType = 'Google_Service_Doubleclicksearch_CustomMetric';
    protected $customMetricDataType = 'array';

    public function getAdGroupId()
    {
        return $this->adGroupId;
    }

    public function setAdGroupId($adGroupId)
    {
        $this->adGroupId = $adGroupId;
    }

    public function getAdId()
    {
        return $this->adId;
    }

    public function setAdId($adId)
    {
        $this->adId = $adId;
    }

    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }

    public function setAdvertiserId($advertiserId)
    {
        $this->advertiserId = $advertiserId;
    }

    public function getAgencyId()
    {
        return $this->agencyId;
    }

    public function setAgencyId($agencyId)
    {
        $this->agencyId = $agencyId;
    }

    public function getAttributionModel()
    {
        return $this->attributionModel;
    }

    public function setAttributionModel($attributionModel)
    {
        $this->attributionModel = $attributionModel;
    }

    public function getCampaignId()
    {
        return $this->campaignId;
    }

    public function setCampaignId($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    public function getClickId()
    {
        return $this->clickId;
    }

    public function setClickId($clickId)
    {
        $this->clickId = $clickId;
    }

    public function getConversionId()
    {
        return $this->conversionId;
    }

    public function setConversionId($conversionId)
    {
        $this->conversionId = $conversionId;
    }

    public function getConversionModifiedTimestamp()
    {
        return $this->conversionModifiedTimestamp;
    }

    public function setConversionModifiedTimestamp($conversionModifiedTimestamp)
    {
        $this->conversionModifiedTimestamp = $conversionModifiedTimestamp;
    }

    public function getConversionTimestamp()
    {
        return $this->conversionTimestamp;
    }

    public function setConversionTimestamp($conversionTimestamp)
    {
        $this->conversionTimestamp = $conversionTimestamp;
    }

    public function getCountMillis()
    {
        return $this->countMillis;
    }

    public function setCountMillis($countMillis)
    {
        $this->countMillis = $countMillis;
    }

    public function getCriterionId()
    {
        return $this->criterionId;
    }

    public function setCriterionId($criterionId)
    {
        $this->criterionId = $criterionId;
    }

    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    public function setCustomDimension($customDimension)
    {
        $this->customDimension = $customDimension;
    }

    public function getCustomDimension()
    {
        return $this->customDimension;
    }

    public function setCustomMetric($customMetric)
    {
        $this->customMetric = $customMetric;
    }

    public function getCustomMetric()
    {
        return $this->customMetric;
    }

    public function getDeviceType()
    {
        return $this->deviceType;
    }

    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;
    }

    public function getDsConversionId()
    {
        return $this->dsConversionId;
    }

    public function setDsConversionId($dsConversionId)
    {
        $this->dsConversionId = $dsConversionId;
    }

    public function getEngineAccountId()
    {
        return $this->engineAccountId;
    }

    public function setEngineAccountId($engineAccountId)
    {
        $this->engineAccountId = $engineAccountId;
    }

    public function getFloodlightOrderId()
    {
        return $this->floodlightOrderId;
    }

    public function setFloodlightOrderId($floodlightOrderId)
    {
        $this->floodlightOrderId = $floodlightOrderId;
    }

    public function getInventoryAccountId()
    {
        return $this->inventoryAccountId;
    }

    public function setInventoryAccountId($inventoryAccountId)
    {
        $this->inventoryAccountId = $inventoryAccountId;
    }

    public function getProductCountry()
    {
        return $this->productCountry;
    }

    public function setProductCountry($productCountry)
    {
        $this->productCountry = $productCountry;
    }

    public function getProductGroupId()
    {
        return $this->productGroupId;
    }

    public function setProductGroupId($productGroupId)
    {
        $this->productGroupId = $productGroupId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function getProductLanguage()
    {
        return $this->productLanguage;
    }

    public function setProductLanguage($productLanguage)
    {
        $this->productLanguage = $productLanguage;
    }

    public function getQuantityMillis()
    {
        return $this->quantityMillis;
    }

    public function setQuantityMillis($quantityMillis)
    {
        $this->quantityMillis = $quantityMillis;
    }

    public function getRevenueMicros()
    {
        return $this->revenueMicros;
    }

    public function setRevenueMicros($revenueMicros)
    {
        $this->revenueMicros = $revenueMicros;
    }

    public function getSegmentationId()
    {
        return $this->segmentationId;
    }

    public function setSegmentationId($segmentationId)
    {
        $this->segmentationId = $segmentationId;
    }

    public function getSegmentationName()
    {
        return $this->segmentationName;
    }

    public function setSegmentationName($segmentationName)
    {
        $this->segmentationName = $segmentationName;
    }

    public function getSegmentationType()
    {
        return $this->segmentationType;
    }

    public function setSegmentationType($segmentationType)
    {
        $this->segmentationType = $segmentationType;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getStoreId()
    {
        return $this->storeId;
    }

    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}

class Google_Service_Doubleclicksearch_ConversionList extends Google_Collection
{
    public $kind;
    protected $collection_key = 'conversion';
    protected $internal_gapi_mappings = array();
    protected $conversionType = 'Google_Service_Doubleclicksearch_Conversion';
    protected $conversionDataType = 'array';

    public function setConversion($conversion)
    {
        $this->conversion = $conversion;
    }

    public function getConversion()
    {
        return $this->conversion;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }
}

class Google_Service_Doubleclicksearch_CustomDimension extends Google_Model
{
    public $name;
    public $value;
    protected $internal_gapi_mappings = array();

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}

class Google_Service_Doubleclicksearch_CustomMetric extends Google_Model
{
    public $name;
    public $value;
    protected $internal_gapi_mappings = array();

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}

class Google_Service_Doubleclicksearch_Report extends Google_Collection
{
    public $id;
    public $isReportReady;
    public $kind;
    public $rowCount;
    public $rows;
    public $statisticsCurrencyCode;
    public $statisticsTimeZone;
    protected $collection_key = 'rows';
    protected $internal_gapi_mappings = array();
    protected $filesType = 'Google_Service_Doubleclicksearch_ReportFiles';
    protected $filesDataType = 'array';
    protected $requestType = 'Google_Service_Doubleclicksearch_ReportRequest';
    protected $requestDataType = '';

    public function setFiles($files)
    {
        $this->files = $files;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIsReportReady()
    {
        return $this->isReportReady;
    }

    public function setIsReportReady($isReportReady)
    {
        $this->isReportReady = $isReportReady;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function setRequest(Google_Service_Doubleclicksearch_ReportRequest $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function setRowCount($rowCount)
    {
        $this->rowCount = $rowCount;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    public function getStatisticsCurrencyCode()
    {
        return $this->statisticsCurrencyCode;
    }

    public function setStatisticsCurrencyCode($statisticsCurrencyCode)
    {
        $this->statisticsCurrencyCode = $statisticsCurrencyCode;
    }

    public function getStatisticsTimeZone()
    {
        return $this->statisticsTimeZone;
    }

    public function setStatisticsTimeZone($statisticsTimeZone)
    {
        $this->statisticsTimeZone = $statisticsTimeZone;
    }
}

class Google_Service_Doubleclicksearch_ReportApiColumnSpec extends Google_Model
{
    public $columnName;
    public $customDimensionName;
    public $customMetricName;
    public $endDate;
    public $groupByColumn;
    public $headerText;
    public $platformSource;
    public $savedColumnName;
    public $startDate;
    protected $internal_gapi_mappings = array();

    public function getColumnName()
    {
        return $this->columnName;
    }

    public function setColumnName($columnName)
    {
        $this->columnName = $columnName;
    }

    public function getCustomDimensionName()
    {
        return $this->customDimensionName;
    }

    public function setCustomDimensionName($customDimensionName)
    {
        $this->customDimensionName = $customDimensionName;
    }

    public function getCustomMetricName()
    {
        return $this->customMetricName;
    }

    public function setCustomMetricName($customMetricName)
    {
        $this->customMetricName = $customMetricName;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getGroupByColumn()
    {
        return $this->groupByColumn;
    }

    public function setGroupByColumn($groupByColumn)
    {
        $this->groupByColumn = $groupByColumn;
    }

    public function getHeaderText()
    {
        return $this->headerText;
    }

    public function setHeaderText($headerText)
    {
        $this->headerText = $headerText;
    }

    public function getPlatformSource()
    {
        return $this->platformSource;
    }

    public function setPlatformSource($platformSource)
    {
        $this->platformSource = $platformSource;
    }

    public function getSavedColumnName()
    {
        return $this->savedColumnName;
    }

    public function setSavedColumnName($savedColumnName)
    {
        $this->savedColumnName = $savedColumnName;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }
}

class Google_Service_Doubleclicksearch_ReportFiles extends Google_Model
{
    public $byteCount;
    public $url;
    protected $internal_gapi_mappings = array();

    public function getByteCount()
    {
        return $this->byteCount;
    }

    public function setByteCount($byteCount)
    {
        $this->byteCount = $byteCount;
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

class Google_Service_Doubleclicksearch_ReportRequest extends Google_Collection
{
    public $downloadFormat;
    public $includeDeletedEntities;
    public $includeRemovedEntities;
    public $maxRowsPerFile;
    public $reportType;
    public $rowCount;
    public $startRow;
    public $statisticsCurrency;
    public $verifySingleTimeZone;
    protected $collection_key = 'orderBy';
    protected $internal_gapi_mappings = array();
    protected $columnsType = 'Google_Service_Doubleclicksearch_ReportApiColumnSpec';
    protected $columnsDataType = 'array';
    protected $filtersType = 'Google_Service_Doubleclicksearch_ReportRequestFilters';
    protected $filtersDataType = 'array';
    protected $orderByType = 'Google_Service_Doubleclicksearch_ReportRequestOrderBy';
    protected $orderByDataType = 'array';
    protected $reportScopeType = 'Google_Service_Doubleclicksearch_ReportRequestReportScope';
    protected $reportScopeDataType = '';
    protected $timeRangeType = 'Google_Service_Doubleclicksearch_ReportRequestTimeRange';
    protected $timeRangeDataType = '';

    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getDownloadFormat()
    {
        return $this->downloadFormat;
    }

    public function setDownloadFormat($downloadFormat)
    {
        $this->downloadFormat = $downloadFormat;
    }

    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getIncludeDeletedEntities()
    {
        return $this->includeDeletedEntities;
    }

    public function setIncludeDeletedEntities($includeDeletedEntities)
    {
        $this->includeDeletedEntities = $includeDeletedEntities;
    }

    public function getIncludeRemovedEntities()
    {
        return $this->includeRemovedEntities;
    }

    public function setIncludeRemovedEntities($includeRemovedEntities)
    {
        $this->includeRemovedEntities = $includeRemovedEntities;
    }

    public function getMaxRowsPerFile()
    {
        return $this->maxRowsPerFile;
    }

    public function setMaxRowsPerFile($maxRowsPerFile)
    {
        $this->maxRowsPerFile = $maxRowsPerFile;
    }

    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    public function getOrderBy()
    {
        return $this->orderBy;
    }

    public function setReportScope(Google_Service_Doubleclicksearch_ReportRequestReportScope $reportScope)
    {
        $this->reportScope = $reportScope;
    }

    public function getReportScope()
    {
        return $this->reportScope;
    }

    public function getReportType()
    {
        return $this->reportType;
    }

    public function setReportType($reportType)
    {
        $this->reportType = $reportType;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function setRowCount($rowCount)
    {
        $this->rowCount = $rowCount;
    }

    public function getStartRow()
    {
        return $this->startRow;
    }

    public function setStartRow($startRow)
    {
        $this->startRow = $startRow;
    }

    public function getStatisticsCurrency()
    {
        return $this->statisticsCurrency;
    }

    public function setStatisticsCurrency($statisticsCurrency)
    {
        $this->statisticsCurrency = $statisticsCurrency;
    }

    public function setTimeRange(Google_Service_Doubleclicksearch_ReportRequestTimeRange $timeRange)
    {
        $this->timeRange = $timeRange;
    }

    public function getTimeRange()
    {
        return $this->timeRange;
    }

    public function getVerifySingleTimeZone()
    {
        return $this->verifySingleTimeZone;
    }

    public function setVerifySingleTimeZone($verifySingleTimeZone)
    {
        $this->verifySingleTimeZone = $verifySingleTimeZone;
    }
}

class Google_Service_Doubleclicksearch_ReportRequestFilters extends Google_Collection
{
    public $operator;
    public $values;
    protected $collection_key = 'values';
    protected $internal_gapi_mappings = array();
    protected $columnType = 'Google_Service_Doubleclicksearch_ReportApiColumnSpec';
    protected $columnDataType = '';

    public function setColumn(Google_Service_Doubleclicksearch_ReportApiColumnSpec $column)
    {
        $this->column = $column;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function setOperator($operator)
    {
        $this->operator = $operator;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function setValues($values)
    {
        $this->values = $values;
    }
}

class Google_Service_Doubleclicksearch_ReportRequestOrderBy extends Google_Model
{
    public $sortOrder;
    protected $internal_gapi_mappings = array();
    protected $columnType = 'Google_Service_Doubleclicksearch_ReportApiColumnSpec';
    protected $columnDataType = '';

    public function setColumn(Google_Service_Doubleclicksearch_ReportApiColumnSpec $column)
    {
        $this->column = $column;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }
}

class Google_Service_Doubleclicksearch_ReportRequestReportScope extends Google_Model
{
    public $adGroupId;
    public $adId;
    public $advertiserId;
    public $agencyId;
    public $campaignId;
    public $engineAccountId;
    public $keywordId;
    protected $internal_gapi_mappings = array();

    public function getAdGroupId()
    {
        return $this->adGroupId;
    }

    public function setAdGroupId($adGroupId)
    {
        $this->adGroupId = $adGroupId;
    }

    public function getAdId()
    {
        return $this->adId;
    }

    public function setAdId($adId)
    {
        $this->adId = $adId;
    }

    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }

    public function setAdvertiserId($advertiserId)
    {
        $this->advertiserId = $advertiserId;
    }

    public function getAgencyId()
    {
        return $this->agencyId;
    }

    public function setAgencyId($agencyId)
    {
        $this->agencyId = $agencyId;
    }

    public function getCampaignId()
    {
        return $this->campaignId;
    }

    public function setCampaignId($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function getEngineAccountId()
    {
        return $this->engineAccountId;
    }

    public function setEngineAccountId($engineAccountId)
    {
        $this->engineAccountId = $engineAccountId;
    }

    public function getKeywordId()
    {
        return $this->keywordId;
    }

    public function setKeywordId($keywordId)
    {
        $this->keywordId = $keywordId;
    }
}

class Google_Service_Doubleclicksearch_ReportRequestTimeRange extends Google_Model
{
    public $changedAttributesSinceTimestamp;
    public $changedMetricsSinceTimestamp;
    public $endDate;
    public $startDate;
    protected $internal_gapi_mappings = array();

    public function getChangedAttributesSinceTimestamp()
    {
        return $this->changedAttributesSinceTimestamp;
    }

    public function setChangedAttributesSinceTimestamp($changedAttributesSinceTimestamp)
    {
        $this->changedAttributesSinceTimestamp = $changedAttributesSinceTimestamp;
    }

    public function getChangedMetricsSinceTimestamp()
    {
        return $this->changedMetricsSinceTimestamp;
    }

    public function setChangedMetricsSinceTimestamp($changedMetricsSinceTimestamp)
    {
        $this->changedMetricsSinceTimestamp = $changedMetricsSinceTimestamp;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }
}

class Google_Service_Doubleclicksearch_ReportRow extends Google_Model
{
}

class Google_Service_Doubleclicksearch_SavedColumn extends Google_Model
{
    public $kind;
    public $savedColumnName;
    public $type;
    protected $internal_gapi_mappings = array();

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getSavedColumnName()
    {
        return $this->savedColumnName;
    }

    public function setSavedColumnName($savedColumnName)
    {
        $this->savedColumnName = $savedColumnName;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}

class Google_Service_Doubleclicksearch_SavedColumnList extends Google_Collection
{
    public $kind;
    protected $collection_key = 'items';
    protected $internal_gapi_mappings = array();
    protected $itemsType = 'Google_Service_Doubleclicksearch_SavedColumn';
    protected $itemsDataType = 'array';

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }
}

class Google_Service_Doubleclicksearch_UpdateAvailabilityRequest extends Google_Collection
{
    protected $collection_key = 'availabilities';
    protected $internal_gapi_mappings = array();
    protected $availabilitiesType = 'Google_Service_Doubleclicksearch_Availability';
    protected $availabilitiesDataType = 'array';


    public function setAvailabilities($availabilities)
    {
        $this->availabilities = $availabilities;
    }

    public function getAvailabilities()
    {
        return $this->availabilities;
    }
}

class Google_Service_Doubleclicksearch_UpdateAvailabilityResponse extends Google_Collection
{
    protected $collection_key = 'availabilities';
    protected $internal_gapi_mappings = array();
    protected $availabilitiesType = 'Google_Service_Doubleclicksearch_Availability';
    protected $availabilitiesDataType = 'array';


    public function setAvailabilities($availabilities)
    {
        $this->availabilities = $availabilities;
    }

    public function getAvailabilities()
    {
        return $this->availabilities;
    }
}