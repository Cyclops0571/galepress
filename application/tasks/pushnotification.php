<?php

class PushNotification_Task {

    public function run()
    {
    	//https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Introduction.html
    	//https://developer.apple.com/library/ios/technotes/tn2265/_index.html
		try
		{
			$pn = DB::table('Customer AS c')
					->join('Application AS a', function($join)
					{
						$join->on('a.CustomerID', '=', 'c.CustomerID');
						$join->on('a.StatusID', '=', DB::raw(eStatus::Active));
					})
					->join('PushNotification AS p', function($join)
					{
						$join->on('p.ApplicationID', '=', 'a.ApplicationID');
						$join->on('p.Sent', '=', DB::raw(0));
					})
					->where(function($query)
					{
						$query->where_null('p.ErrorCount');
						$query->or_where('p.ErrorCount', '<', 2);
					})
					->where('c.StatusID', '=', eStatus::Active)
					->order_by('p.PushNotificationID', 'DESC')
					->take(1000)
					->get(array('c.CustomerID', 'a.ApplicationID', 'a.NotificationText', 'a.CkPem', 'p.PushNotificationID', 'p.DeviceToken', 'p.DeviceType'));
				
			$unisacDevice=0;
			foreach($pn as $n)
			{
				try
				{
					//ios
					if($n->DeviceType === 'ios')
					{
						$cert = path('public').'files/customer_'.$n->CustomerID.'/application_'.$n->ApplicationID.'/'.$n->CkPem;
					
						// Put your device token here (without spaces):
						$deviceToken = $n->DeviceToken;

						if($n->ApplicationID == 117)
						{
							if($unisacDevice==0)
							{
								$deviceToken="2601df4ff3e8b2805ea15c83e235ae6bea1be9da1eadd2bee18bf33022f999d1";
								$unisacDevice++;
							}
							else
							{
								$deviceToken="test_gonderme_2601df4ff3e8b2805ea15c83e235ae6bea1be9da1eadd2bee18bf33022f999d1";
							}
						}
						
						// Put your private key's passphrase here:
						$passphrase = Config::get('custom.passphrase');
						
						// Put your alert message here:
						$message = $n->NotificationText;
						
						//Log::info('crt:'.$cert.' devToken:'.$deviceToken.' passphrase:'.$passphrase.' message:'.$message);
						////////////////////////////////////////////////////////////////////////////////
						
						$ctx = stream_context_create();
						stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
						stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
						
						// Open a connection to the APNS server
						$fp = stream_socket_client(
							'ssl://gateway.push.apple.com:2195', $err,
							$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
							
						if ($fp)
						{
							// Create the payload body
							$body['aps'] = array(
								'alert' => $message,
								'sound' => 'default'
								);
							
							// Encode the payload as JSON
							$payload = json_encode($body);
							
							// Build the binary notification
							$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
							
							// Send it to the server
							$result = fwrite($fp, $msg, strlen($msg));
								
							//Log::info($result);

							if ($result)
							{
								//echo 'Message successfully delivered' . PHP_EOL;
								$c = PushNotification::find((int)$n->PushNotificationID);
								$c->Sent = 1;
								$c->save();
							}
							else
							{
								$c = PushNotification::find((int)$n->PushNotificationID);
								$c->ErrorCount = (int)$c->ErrorCount + 1;
								$c->LastErrorDetail = 'Message not delivered!';
								$c->save();
							}
							// Close the connection to the server
							fclose($fp);	
						}
						else
						{
							//throw new Exception("Failed to connect: $err $errstr" . PHP_EOL);
						}
					}
					//android
					elseif($n->DeviceType === 'android')
					{
						//$googleAPIKey = 'AIzaSyCj2v2727lBWLeXbgM_Hw_VEQgzjDgb8KY';
						$googleAPIKey = Config::get('custom.google_api_key');

						if($n->ApplicationID == 117)
						{
							$googleAPIKey = "test_gonderme_AIzaSyCj2v2727lBWLeXbgM_Hw_VEQgzjDgb8KY"
							$deviceToken="test_gonderme_2601df4ff3e8b2805ea15c83e235ae6bea1be9da1eadd2bee18bf33022f999d1";
						}

						$data = array(
							'headers' => array(
								'Authorization: key='.$googleAPIKey,
								'Content-Type: application/json'
							),
							'fields' => array(
								'registration_ids' => array(
									$n->DeviceToken
								),
								'data' => array(
									"message" => $n->NotificationText
								)
							)
						);
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $data['headers']);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disabling SSL Certificate support temporarly
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data['fields']));
						$result = curl_exec($ch);
						if ($result === false) {
							//die('Curl failed: ' . curl_error($ch));
							throw new Exception('Curl failed: '.curl_error($ch));
						}
						curl_close($ch);
						$json = json_decode($result, true);
						if($json['success'] === 1)
						{
							$c = PushNotification::find((int)$n->PushNotificationID);
							$c->Sent = 1;
							$c->save();
						}
						else
						{
							$c = PushNotification::find((int)$n->PushNotificationID);
							$c->ErrorCount = (int)$c->ErrorCount + 1;
							$c->LastErrorDetail = 'Message not delivered!';
							$c->save();
						}
					}
				}
				catch (Exception $e)
				{
					$c = PushNotification::find((int)$n->PushNotificationID);
					$c->ErrorCount = (int)$c->ErrorCount + 1;
					$c->LastErrorDetail = $e->getMessage();
					$c->save();
				}
			}
		}
		catch (Exception $e)
		{
			$toEmail = Config::get('custom.admin_email');
			$subject = __('common.task_subject');
			$msg = __('common.task_message', array(
					'task' => '`PushNotification`',
					'detail' => $e->getMessage()
					)
				);
			
			Log::info($msg);
			
			Bundle::start('messages');
			
			Message::send(function($m) use($toEmail, $subject, $msg)
			{
				$m->from(Config::get('custom.mail_email'), Config::get('custom.mail_displayname'));
				$m->to($toEmail);
				$m->subject($subject);
				$m->body($msg);
			});
		}
    }
}