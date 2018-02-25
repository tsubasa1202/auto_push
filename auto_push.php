<?php

$baseUrl = "http://192.168.1.22:8000";
//$baseUrl = "http://18.220.15.18"; 
$path = "/v1/user/devicetokens";

$pushUrl = "https://web-party-push-server-dist.herokuapp.com/sample_push.php";

$message_Wednesday = ["週の中日にオンライン飲み会🍺", "週の中日はサクッとオンライン飲み会🍺", "今週もあと2日で休み✨"];

$message_Friday = ["華金✨みんなでオンライン飲み会🍺", "今日は金曜🎉パァーっとやりましょう😆", "花金🎉ぜんぶ忘れて飲みまくろう✨"];

$message_Saturday = ["明日は休み✨オンライン飲み会🍺", "はじけたい💥土曜の夜😆🍺", "せっかくの土曜日🎉飲まないなんてもったいない🍺", "土曜は明日を気にせずオンライン飲み会🍺✨"];


$message = array();

switch ($argv[1]) {
	case '水':
		$message = $message_Wednesday;
		break;

	case '金':
		$message = $message_Friday;
		break;

	case '土':
		$message = $message_Saturday;
		break;
	
	default:
		# code...
		break;
}
$rand = mt_rand(0, count($message) - 1);

//デバイストークン取得

$strUrl = $baseUrl. "/" .$path;
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $strUrl);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
//curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, true);

$response = curl_exec($curl);
$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);
$result = json_decode($body, true);

//echo var_export($result,true);

for ($i=0; $i <count($result) ; $i++) { 

	if($message[$rand] != null && $message[$rand] != "" &&  !empty($message[$rand]) ){

		$strUrl = $pushUrl. "?DeviceToken=" .$result[$i] . "&message=" . $message[$rand];

		echo $strUrl ;
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $strUrl);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		//curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, true);

		$response = curl_exec($curl);


		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);
		//echo $body;

}


	
}