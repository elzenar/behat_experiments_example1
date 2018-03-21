<?php

$curl = curl_init();

$cart = array(
    array(
        'name' => 'Some article',
        'price' => '15',
        'priceNetto' => '15',
        'vatRate' => '10',
        'quantity' => '3',
        'description' => 'The new article',
        'thumbnail' => 'https://someitem.com/thumbnail.jpg',
        'sku' => '123',
    ),
    array(
        'name' => 'Some item',
        'price' => '15',
        'priceNetto' => '15',
        'vatRate' => '10',
        'quantity' => '3',
        'description' => 'The new item in black',
        'thumbnail' => 'https://someitem.com/thumbnail',
        'sku' => '124',
    )
);
$params = array(
    'channel' => 'other_shopsystem',
    'amount' => '100',
    'fee' => '10',
    'order_id' => '900001291100',
    'currency' => 'USD',
    'cart' => json_encode($cart),
    'salutation' => 'mr',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'city' => 'New York',
    'zip' => '10019',
    'street' => '5th Ave, 342',
    'country' => 'US',
    'email' => 'john@payever.de',
    'phone' => '+1 (800) 123756',
    'success_url' => 'https://www.you.shop.tld/callback/success/--PAYMENT-ID--\call_id/--CALL-ID--',
    'failure_url' => 'https://www.you.shop.tld/callback/failure/--PAYMENT-ID--\call_id/--CALL-ID--',
    'cancel_url' => 'https://www.you.shop.tld/callback/notice/--PAYMENT-ID--\call_id/--CALL-ID--',
    'notice_url' => 'https://www.you.shop.tld/callback/success/--PAYMENT-ID--\call_id/--CALL-ID--',
    'pending_url' => 'https://www.you.shop.tld/callback/pending/--PAYMENT-ID--\call_id/--CALL-ID--',
    'x_frame_host' => 'https://your.shop.tld,',
);


curl_setopt_array($curl, array(
    CURLOPT_URL => "https://mein.payever.de/api/payment",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer <access_token>"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}