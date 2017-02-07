<?php

/**
 * Created by PhpStorm.
 * User: p1027
 * Date: 07.11.2016
 * Time: 16:19
 */
class mobileService
{
    /**
     * @param PushNotification $pushNotification
     */
    public static function androidInternal(PushNotification $pushNotification)
    {
        $deviceType = 'android';
        $postData = array();
        $postData["data"] = array("message" => $pushNotification->NotificationText);
//        $postData["dry_run"] = Laravel\Request::env() == ENV_LOCAL;
        $pushNotificationDevicesAll = PushNotificationDevice::where('Sent', '=', 0)
            ->where('ErrorCount', '=', 0)
            ->where('PushNotificationID', '=', $pushNotification->PushNotificationID)
            ->where('DeviceType', '=', $deviceType)
            ->where('StatusID', '=', eStatus::Active)->get();

        foreach (array_chunk($pushNotificationDevicesAll, 1000) as $pushNotificationDevices) {
            /** @var PushNotificationDevice[] $pushNotificationDevices */
            $postData['registration_ids'] = array_map(function (PushNotificationDevice $o) {
                return $o->DeviceToken;
            }, $pushNotificationDevices);
            $googleApiKey = 'AIzaSyCj2v2727lBWLeXbgM_Hw_VEQgzjDgb8KY';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: key=' . $googleApiKey, 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            $response = curl_exec($ch);
            curl_close($ch);
            if ($response === false) {
                ServerErrorLog::logAndSave(571, 'Push Notification', "Curl Failde");
                continue;
            }


            $responseArray = json_decode($response, TRUE);
            if (!isset($responseArray['results'])) {
                ServerErrorLog::logAndSave(571, 'Push Notification', '$responseArray["results"] is empty');
                continue;
            }

            $results = $responseArray['results'];
            $resultCount = count($results);
            if ($resultCount != count($pushNotificationDevices)) {
                $errorText = '$resultCount:' . $resultCount;
                $errorText .= ' -- $pushNotificationDevicesCount:' . count($pushNotificationDevices);
                foreach ($pushNotificationDevices as $pushNotificationDevice) {

                    $pushNotificationDevice->ErrorCount++;
                    $pushNotificationDevice->LastErrorDetail = $errorText;
                    $pushNotificationDevice->save();
                }
                $errorText .= ' -- response: ' . $response;
                ServerErrorLog::logAndSave(571, 'Push Notification', $errorText);
                continue;
            }

            for ($i = 0; $i < $resultCount; $i++) {
                if (isset($results[$i]['message_id'])) {
                    $pushNotificationDevices[$i]->Sent = 1;
                } else if (isset($results[$i]['error'])) {
                    $pushNotificationDevices[$i]->ErrorCount = $pushNotificationDevices[$i]->ErrorCount + 1;
                    $pushNotificationDevices[$i]->LastErrorDetail = $results[$i]['error'];
                    if($results[$i]['error'] == "NotRegistered") {
                        /** @var Token[] $notRegisteredTokens */
                        $notRegisteredTokens = Token::where('DeviceToken', '=', $pushNotificationDevices[$i]->DeviceToken)
                            ->where('DeviceType', '=', $deviceType)->get();
                        foreach($notRegisteredTokens as $notRegisteredToken) {
                            $notRegisteredToken->StatusID = eStatus::Deleted;
                            $notRegisteredToken->save();
                        }
                    }
                }
                $pushNotificationDevices[$i]->save();

                if (isset($results[$i]['registration_id'])) {
                    //registration token should be updated from old token to new one.
                    /** @var Token $token */
                    $token = Token::where('DeviceToken', '=', $results[$i]['registration_id'])
                        ->where('DeviceType', '=', $deviceType)->first();
                    /** @var Token $oldToken */
                    $oldToken = Token::where('DeviceToken', '=', $pushNotificationDevices[$i]->DeviceToken)
                        ->where('DeviceType', '=', $deviceType)->first();
                    if ($token) {
                        //token already exists just delete the old token
                        if ($oldToken) {
                            $oldToken->StatusID = eStatus::Deleted;
                            $oldToken->save();
                        }
                    } else if ($oldToken) {
                        //token not exists update the old one to new canonical token.
                        $oldToken->DeviceToken = $results[$i]['registration_id'];
                        $oldToken->save();
                    }
                }
            }
        }
    }

    public static function iosInternal(PushNotification $pushNotification)
    {

        $cert = path('public') . 'files/customer_' . $pushNotification->Application->CustomerID
            . '/application_' . $pushNotification->Application->ApplicationID
            . '/' . $pushNotification->Application->CkPem;
        if (!File::exists($cert)) {
            Common::sendErrorMail("ApplicationID:" . $pushNotification->ApplicationID . " does not have a CkPem");
        }
        /** @var PushNotificationDevice[] $pushNotificationDevicesAll */
        $pushNotificationDevicesAll = PushNotificationDevice::where('Sent', '=', 0)
            ->where('ErrorCount', '=', 0)
            ->where('PushNotificationID', '=', $pushNotification->PushNotificationID)
            ->where('DeviceType', '=', "ios")
            ->where('StatusID', '=', eStatus::Active)->order_by("PushNotificationDeviceID", "DESC")->get();
//	$appID = 424;
//	$udid1 = 'E6A7CFD9-FE39-4C33-B7F4-6651404ED040';
//	$deviceToken1 = '22d08c4579f9a0d0e07fe7fdcd0a064989ecb93b06f7a1cf7c3a5f130b36c776';
        $success = false;

        // Put your private key's passphrase here:
        $passphrase = Config::get('custom.passphrase');


        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if ($fp) {
            // Create the payload body
            $body['aps'] = array(
                'alert' => $pushNotification->NotificationText,
                'sound' => 'default',
                'badge' => 0
            );

            // Encode the payload as JSON
            $payload = json_encode($body);
            foreach ($pushNotificationDevicesAll as $pushNotificationDevice) {
                // Build the binary notification
                $msg = chr(0) . pack('n', 32) . pack('H*', $pushNotificationDevice->DeviceToken) . pack('n', strlen($payload)) . $payload;

                $result = fwrite($fp, $msg, strlen($msg));
                if(!$result) {
                    for($i = 0; $i < 3; $i++) {
                        fclose($fp);
                        sleep(1);
                        stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
                        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
                        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
                        if(!$fp) {
                            continue;
                        }
                        sleep(1);
                        $result = fwrite($fp, $msg, strlen($msg));
                        fwrite(STDOUT, "try rewrite\n");
                    }
                }

                if ($result) {
                    $pushNotificationDevice->Sent = 1;
                } else {
                    $pushNotificationDevice->ErrorCount++;
                    $pushNotificationDevice->LastErrorDetail = json_encode($err) . " - " . json_encode($errstr);
                }
                $pushNotificationDevice->save();
            }

            fclose($fp);
        } else {
            foreach($pushNotificationDevicesAll as $pushNotificationDevice) {
                $pushNotificationDevice->ErrorCount++;
                $pushNotificationDevice->LastErrorDetail = "stream_socket_client(): failed to create an SSL handle";
                $pushNotificationDevice->save();
            }
            ServerErrorLog::logAndSave("571", 'Push Notification', json_encode($err) . " - " . json_encode($errstr));
        }
        return $success;
    }
}