<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '{{url}}/integrations/user/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('login' => 'jogodeouro','password' => '2w308efh'),
  CURLOPT_HTTPHEADER => array(
    'x-api-key: f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

