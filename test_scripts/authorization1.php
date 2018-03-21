<?php

// This script is used only for viewing how a response looks like.
// TODO Should be deleted when the task will be finished.

$curl = curl_init();

$params = array(
    'client_id' => '30801_44jezpd83a68wc4k8c8wsssco4k0w0gow4owswoc0g0oksc8o8',
    'client_secret' => '9vejpbzp8k08sk0k08cg00ocsgco80ckog8s800kgwcckwss0',
    'grant_type' => 'http://www.payever.de/api/payment',
    'scope' => 'API_CREATE_PAYMENT',
);
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://sandbox.payever.de/oauth/v2/token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_POSTFIELDS => $params,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}


