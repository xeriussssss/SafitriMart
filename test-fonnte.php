<?php

$token = 'ATegYFWWKsAKZgAod8ku';
$target = '6285182474887';
$message = 'Test notifikasi dari Safitri Mart';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.fonnte.com/send');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'target' => $target,
    'message' => $message,
]);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: ' . $token,
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

echo $response;