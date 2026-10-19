<?php
 
//     include('/home5/qdwlxrcz/config.menuqrcode/config.php');
    
//     $object = new application(); 
    
//     $authorizationHeader = "Basic S1VJcVgxQXdPZkJoUUl0bHlCOUlGTXpuMXNUZWpWdTc6M0huVEE5SDRnOXo2Nk9KNg==";
    
//     $data = array(
//         "grant_type" => "client_credentials"
//     );
    
//     $dataString = http_build_query($data);
    
//     $ch = curl_init();
    
//     curl_setopt($ch, CURLOPT_URL, "https://api.orange.com/oauth/v3/token");
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//         "Authorization: " . $authorizationHeader,
//         "Content-Type: application/x-www-form-urlencoded",
//         "Accept: application/json"
//     ));
    
//     $response = curl_exec($ch);
//     curl_close($ch);
    
//     $token = json_decode($response)->access_token;
 
// 	$object->query = " UPDATE token_sms 
// 	                    SET token = '$token'  ";

// 	$object->execute();
 

 

 