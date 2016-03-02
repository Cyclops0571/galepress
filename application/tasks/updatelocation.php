<?php

class UpdateLocation_Task
{

    public function run()
    {
        try {
            $apiRequest = 0;
            $arr = array();

            $st = DB::table('Statistic')
                ->where_null('Country')
                ->order_by('StatisticID', 'DESC')
                ->get();
            //->or_where('Country', '=', '')
            /*
            $st = DB::table('Statistic')
                    ->where('StatisticID', '=', 1)
                    ->where_null('Country')
                    ->get();
            */
            foreach ($st as $s) {
                if ((float)$s->Lat > 0 && (float)$s->Long > 0) {

                    $currentLocation = DB::table('Statistic')
                        ->where('Lat', '=', $s->Lat)
                        ->where('Long', '=', $s->Long)
                        ->where_not_null('Country')
                        ->first();
                    if ($currentLocation) {
                        $c = Statistic::find((int)$s->StatisticID);
                        $c->Country = $currentLocation->Country;
                        $c->City = $currentLocation->City;
                        $c->District = $currentLocation->District;
                        $c->Quarter = $currentLocation->Quarter;
                        $c->Avenue = $currentLocation->Avenue;
                        $c->save();
                    } else {
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
//							$apiKey = Config::get('custom.api_key'.$apiIndex);
                        $apiKey = Config::get('custom.google_api_key');
                        $apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
                        $url = sprintf('%s?latlng=%s,%s&sensor=false&key=%s',
                            $apiUrl,
                            $s->Lat,
                            $s->Long,
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
                                //break;
                            }
                        }
                        //}
                        //catch (Exception $e)
                        //{
                        //	//asd;
                        //}

                        $c = Statistic::find((int)$s->StatisticID);
                        $c->Country = $country;
                        $c->City = $city;
                        $c->District = $district;
                        $c->Quarter = $quarter;
                        $c->Avenue = $avenue;
                        $c->save();
                    }
                } else {
                    Log::warning("Can not locate specified latitude & longitude. Id=" . $s->StatisticID);
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