<!DOCTYPE html>
<html>
  <head>
    <link href="img/favicon.ico?v3" rel="shortcut icon">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="nWeather">

    <!-- iPhone -->
    <link href="img/ios-icons/apple-touch-icon-57x57.png"
          sizes="57x57"
          rel="apple-touch-icon">
    <link href="img/ios-icons/apple-touch-startup-image-320x460.png"
          media="(device-width: 320px) and (device-height: 480px)
             and (-webkit-device-pixel-ratio: 1)"
          rel="apple-touch-startup-image">

    <!-- iPhone (Retina) -->
    <link href="img/ios-icons/apple-touch-icon-114x114.png"
          sizes="114x114"
          rel="apple-touch-icon">
    <link href="img/ios-icons/apple-touch-startup-image-640x920.png"
          media="(device-width: 320px) and (device-height: 480px)
             and (-webkit-device-pixel-ratio: 2)"
          rel="apple-touch-startup-image">

    <!-- iPhone 5 -->
    <link href="img/ios-icons/apple-touch-startup-image-640x1096.png"
          media="(device-width: 320px) and (device-height: 568px)
             and (-webkit-device-pixel-ratio: 2)"
          rel="apple-touch-startup-image">

    <!-- iPad -->
    <link href="img/ios-icons/apple-touch-icon-72x72.png"
          sizes="72x72"
          rel="apple-touch-icon">
    <link href="img/ios-icons/apple-touch-startup-image-768x1004.png"
          media="(device-width: 768px) and (device-height: 1024px)
             and (orientation: portrait)
             and (-webkit-device-pixel-ratio: 1)"
          rel="apple-touch-startup-image">
    <link href="img/ios-icons/apple-touch-startup-image-748x1024.png"
          media="(device-width: 768px) and (device-height: 1024px)
             and (orientation: landscape)
             and (-webkit-device-pixel-ratio: 1)"
          rel="apple-touch-startup-image">

    <!-- iPad (Retina) -->
    <link href="img/ios-icons/apple-touch-icon-144x144.png"
          sizes="144x144"
          rel="apple-touch-icon">
    <link href="img/ios-icons/apple-touch-startup-image-1536x2008.png"
          media="(device-width: 768px) and (device-height: 1024px)
             and (orientation: portrait)
             and (-webkit-device-pixel-ratio: 2)"
          rel="apple-touch-startup-image">
    <link href="img/ios-icons/apple-touch-startup-image-1496x2048.png"
          media="(device-width: 768px) and (device-height: 1024px)
             and (orientation: landscape)
             and (-webkit-device-pixel-ratio: 2)"
          rel="apple-touch-startup-image">

    <title>nWeather</title>

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