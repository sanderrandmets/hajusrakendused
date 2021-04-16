<?php

require_once 'secrets.php';

$city = $_GET['city'] ? $_GET['city'] : 'Kuressaare';

$url = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $app_id . '&units=metric';
$fileName = './cache_' . strtolower($city) . '.json';
$cacheTime = 20;

//var_dump(time() - filemtime($fileName));

if ( file_exists($fileName) && time() - filemtime($fileName) < $cacheTime) {
    $content = file_get_contents($fileName);

    echo "Loen failist";
} else {
    $content = file_get_contents($url);

    $file = fopen($fileName, 'w');
    fwrite($file, $content);
    fclose($file);

    echo "Loen APIst";
}                        

$content = file_get_contents($url);

//var_dump($content);


$oWeather = json_decode($content);

//var_dump($oWeather);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tallinna ilm</title>
</head>
<body>
    <h1><?= $oWeather->name; ?> ilm</h1>
    <h2><?= $oWeather->weather[0]->main; ?></h2>
    <h2>Tuulekiirus: <?= $oWeather->wind->speed; ?></h2>
    <h2>Õhuniiskus: <?= $oWeather->main->humidity; ?></h2>
    <h2>Õhurõhk: <?= $oWeather->main->pressure; ?></h2>
    <h2>Miinimium temperatuur: <?= $oWeather->main->temp_min; ?></h2>
    <h2>Tundub nagu: <?= $oWeather->main->feels_like; ?></h2>


    <img src="http://openweathermap.org/img/wn/<?= $oWeather->weather[0]->icon; ?>@2x.png" alt="" srcset="">
</body>
</html>
<!--http://openweathermap.org/img/wn/10d@2x.png
http://api.openweathermap.org/data/2.5/weather?q=Tallinn&appid=0580dd34c41f5bf35df84fbe5d9a7a38&units=metric-->