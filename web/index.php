<?php
$access_token = "[ACCESS TOKEN]";

// メッセージ受信
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
$from_user_id =$json_object->entry{0}->messaging{0}->sender->id;

$post = <<< EOM
{
    "recipient":{
        "id":"{$from_user_id}"
    },
    "message":{
        "text":"hello, world!"
    }
}
EOM;

// メッセージ送信
api_send_request($access_token, $post);

function api_send_request($access_token, $post) {
    error_log("api_get_message_content_request start");
    $url = "https://graph.facebook.com/v2.6/me/messages?access_token={$access_token}";
    $headers = array(
        "Content-Type: application/json"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($curl);
}