<?php 

    $apiKey = 'f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae';

    $url  = 'https://www.jogodeouro.bet';
    $url2 = 'https://backoffice.sga.bet';

    $comp = '/integrations/players/listInfos';

    $login = 'jogodeouro';
    $password = '2w308efh';

    $data = "login: $login password: $password";
    $data2 = "$login $password";


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url2 . $comp,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('start_date' => '2023-04-06 00:00:00','final_date' => '2023-04-10 23:59:59'),
        CURLOPT_HTTPHEADER => array(

            'x-api-key' => $apiKey,
            'Application-Authorization' => $data2

        //   'x-api-key: '. $apiKey,
        //   'Application-Authorization: '. $data
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    
    var_dump($response);

    // $result = json_decode(curl_exec($curl));
    // var_dump($result);