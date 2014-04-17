<!DOCTYPE html>
<html>
  <head>
    <title>nWeather</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="img/ios7/icon.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="img/ios7/icon-72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="img/ios7/icon@2x.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="img/ios7/icon-72@2x.png" />
    <link rel="apple-touch-startup-image" href="img/ios7/startup-image.png" />
    <meta name="apple-mobile-web-app-title" content="nWeather">

    <link rel="shortcut icon" href="img/favicon.ico?v2" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript" src="//use.typekit.net/qlu1goo.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>

  </head>
  <body>
    <div id="weather-container">
      <h2>Determining your location...</h2>
      <h3 class="city">&nbsp;</h3>
    </div>
    <div id="search-container">
      <form id="search-form">
        <input id="location-input" type="text" placeholder="Enter a location" />
      </form>
      <div id="autocomplete-container">
        <ul></ul>
      </div>
    </div>


    <script src="js/jquery-2.1.0.min.js"></script>
    <script src="js/underscore-min.js"></script>
    <script>
      window.nWeather = {};
      <?php

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        echo "window.nWeather.userIp = '$ip';\n"

      ?>
    </script>
    <script src="js/app.js"></script>
  </body>
</html>