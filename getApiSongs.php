<?php

$url = 'https://api.songkick.com/api/3.0/search/locations.json?query='London'&apikey=RmJpmyc8RlY74n1I';

$data = file_get_contents($url);

$obj = json_decode($data,true);

$metroAreaId=$obj['resultsPage']['results']['location'][0]['metroArea']['id'];
//echo $metroAreaId;

$eventsAtArea='https://api.songkick.com/api/3.0/metro_areas/'.$metroAreaId.'/calendar.json?apikey=RmJpmyc8RlY74n1I';
$eventData = file_get_contents($eventsAtArea);
//$eventData=json_decode($eventData);
header('Content-Type: application/json');
$json_pretty = json_encode(json_decode($eventData), JSON_PRETTY_PRINT);

echo $json_pretty;
?>
