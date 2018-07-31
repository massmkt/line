<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');
require_once('lib/nusoap.php');

$access_token = 'Gsga6ROKCgOSFJaAZNlhKpcZiiTlXg71ziuQeIpsBQDdzmka1PE+CLfQM3M7RUOanLsBWzc6GYV0uy6Tp2w0MslevePx9+fPTAir1gUckZUGpMD19lZPadhlv0LoOVppO8z6WXHtS9oSYiRcZp7gZgdB04t89/1O/w1cDnyilFU=';
$channel_secret = '7123c582e65b0f1b4b93d4900fde6ff5';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text' && ($event['source']['groupId'] == 'C8365e7d5e8cde7297ea917354127494d' || $event['source']['groupId'] == 'C1d73dd138a9ab736a4f53be0ffcd4c3b')) {
			// Get text sent
			$text = $event['source']['userId'];
			
			/*$url = 'https://api.line.me/v2/bot/profile/'.$event['source']['userId'];
			$headers = array('Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$jprofile = curl_exec($ch);
			curl_close($ch);
			$profile = json_decode($jprofile, true);
			
			$client = new nusoap_client("http://tab.massmarketing.co.th/ws/ws_saleswork.php?wsdl",true);
			$params = array(
				'msg' => $event['message']['text'],
				'uid' => $event['source']['userId'],
				'uname' => $profile['displayName'],
				'upic' => $profile['pictureUrl']
			);
			$text = $client->call("MM_SalesWork",$params);*/
		} else if($event['source']['userId'] == 'U8e3cfaad38856c3d02394cd6c66cad84'){
			$text = $event['source']['groupId'];
		}
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
	}
}
