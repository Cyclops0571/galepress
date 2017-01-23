<?php

class UpdateLocation_Task
{

    public function run()
    {
        try {
            $apiRequest = 0;
            $arr = array();

            $statistics = Statistic::where_not_null('Lat')
                ->where_not_null('Long')
                ->where_null('Country')
                ->order_by('StatisticID', 'DESC')
                ->take(1000)
                ->get();

            foreach ($statistics as $statistic) {
                if ((float)$statistic->Lat > 0 && (float)$statistic->Long > 0) {


                    $country = '';
                    $city = '';
                    $district = '';
                    $quarter = '';
                    $avenue = '';

                    //try
                    //{
                    $apiIndex = intval($apiRequest / 1000);
                    if ($apiIndex > 9) {
                        $apiIndex = 1;
                    }

//					$apiKey = Config::get('custom.api_key'.$apiIndex);
                    $apiKey = Config::get('custom.google_api_key');
                    $apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
                    $url = sprintf('%s?latlng=%s,%s&sensor=false&key=%s',
                        $apiUrl,
                        $statistic->Lat,
                        $statistic->Long,
                        $apiKey
                    );

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $apiRequest += 1;
                    curl_close($ch);

                    $json = json_decode($response, true);
                    if ($json["status"] == "OK") {
                        $results = $json["results"];
                        foreach ($results as $result) {
                            $addresses = $result["address_components"];
                            foreach ($addresses as $address) {
                                $types = $address["types"];

                                if (in_array("country", $types) && empty($country)) {
                                    $country = $address["long_name"];
                                } else if (in_array("locality", $types) && empty($city)) {
                                    $city = $address["long_name"];
                                } else if (in_array("sublocality", $types) && empty($district)) {
                                    $district = $address["long_name"];
                                } else if (in_array("neighborhood", $types) && empty($quarter)) {
                                    $quarter = $address["long_name"];
                                } else if (in_array("route", $types) && empty($avenue)) {
                                    $avenue = $address["long_name"];
                                }
                            }
                        }
                    }


                    $statistic->Country = $country;
                    $statistic->City = $city;
                    $statistic->District = $district;
                    $statistic->Quarter = $quarter;
                    $statistic->Avenue = $avenue;
                    $statistic->save();
                } else {
                    Log::warning("Can not locate specified latitude & longitude. Id=" . $statistic->StatisticID);
                }
            }
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`UpdateLocation`',
                    'detail' => $e->getMessage()
                )
            );

            Common::sendErrorMail($msg);
        }
    }
}