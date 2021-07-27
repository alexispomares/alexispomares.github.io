<?php
error_reporting(E_ERROR | E_PARSE | E_USER_WARNING);
$requestBody = file_get_contents("php://input");
$json = json_decode($requestBody);

if ($json->from != "pascal") {
	if (strlen($json->message) > 256)
		limit_exceeded($json->groupId);
}
echo "eurekas";



function limit_exceeded($id) {
	$response->groupId = "$id";
	$response->message = "Sorry, it looks like your message is too long for me to understand. Could you please rephrase it in less than 256 characters? The shorter, the better. Thanks!";
	$response->fromUserName = "pascal";
	post_to_url("https://services.kommunicate.io/rest/ws/message/v2/send",json_encode($response), "Content-type: application/json\r\n"."API-Key: cHXC54sXdzfR26Oow1YPbts0fnYgQYTv\r\n");
}

function post_to_url($url,$data,$headers) {
	$context = stream_context_create(array(
		'http' => array(
			'header'  => $headers,
			'method'  => 'POST',
			'content' => $data
	)));
	
	file_get_contents($url, false, $context);
	//trigger_error(file_get_contents($url, false, $context), E_USER_WARNING);
}
?>