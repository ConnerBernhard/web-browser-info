<?php
// This is the URL you want to shorten
//$longUrl = 'http://www.whatamiusing.connerb.com/shortner.php';
if($_POST['long_url']!='')
{
$longUrl = $_POST['long_url'];
// Get API key from : http://code.google.com/apis/console/
$apiKey = 'AIzaSyAJRoSu0Gq_fuLIOacXO-sg1-9dfFVyOXA';

$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
$jsonData = json_encode($postData);

$curlObj = curl_init();

curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curlObj, CURLOPT_HEADER, 0);
curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
curl_setopt($curlObj, CURLOPT_POST, 1);
curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

$response = curl_exec($curlObj);

// Change the response json string to object
$json = json_decode($response);

curl_close($curlObj);

echo $json->id;
}
?>