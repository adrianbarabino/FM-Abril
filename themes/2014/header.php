<?php
require("./classes/Simplepie/simplepie.inc");
require("./classes/Simplepie/simplepie_yahoo_weather.inc");
date_default_timezone_set('Buenos Aires');

 
$code = "ARSC0074";
$path = "http://weather.yahooapis.com/forecastrss?u=c&p=";
 
 function truncate ($str, $length=2, $trailing='')
{
/*
** $str -cadena a truncar
** $length - longitud a truncar
** $trailing - el fin de la nueva cadena, por defecto: "..."
*/
    // take off chars for the trailing
    $length-=strlen($trailing);
    if (strlen($str)> $length)
    {
     // la cadena excede la longitud, entonces añade los puntos suspensivos
     return substr($str,0,$length).$trailing;
    }
    else
    {
     // si la cadena ya es lo suficientemente corta, devuelve la cadena
     $res = $str;
    }
    return $res;
}

$feed = new SimplePie();
$feed->set_feed_url($path.$code);
$feed->set_item_class('SimplePie_Item_YWeather');
$feed->init();
 
function time2minuts($time) {
$minuts = 0;
$atime = explode(" ", $time);
$ttime = explode(":", $atime[0]);


if (strtolower($atime[1]) == "pm") {
$minuts = 12*60;
}
if($ttime[0] == "12") $ttime[0] = "0";
$minuts = $minuts + (int)$ttime[0]*60 + (int)$ttime[1];
return $minuts;
}
 
$weather = $feed->get_item(0);
$fore = $weather->get_forecasts();
$unit = $weather->get_units_temp();
$ampm = "n";  // indica noche
$icon2 = $weather->get_condition_code();
$icon = truncate($weather->get_condition_code());

// print_r("<script>alert('".time2minuts(date("g:i a"))."');</script>");
// Calculamos la hora en minutos
$curday =  time2minuts(date("g:i a")) + (60);

$iniday = time2minuts($weather->get_sunrise());
$endday = time2minuts($weather->get_sunset());
 
if ($curday> $iniday && $curday <$endday ) {
    $ampm = "d"; // indica dia
}

?>
<!doctype html>
<html lang="es" class="nojs">
<head>
  <meta charset="UTF-8">
  <title>FM Abril - 105.7 - Rio Gallegos</title>
  <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="<?php printf("/themes/%s", $config['theme']); ?>/css/normalize.css">
  <link rel="stylesheet" type="text/css" href="<?php printf("/themes/%s", $config['theme']); ?>/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?php printf("/themes/%s", $config['theme']); ?>/css/pgwslider.min.css">
  <link rel="stylesheet" type="text/css" href="<?php printf("/themes/%s", $config['theme']); ?>/css/jplayer.blue.monday.css">

</head>
<body>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '{your-app-id}',
          xfbml      : true,
          version    : 'v2.0'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>
  <section id="mainWrapper">

