<?php
/*
require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile': 'php://stderr',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return 'Hello';
});

$app->run();
*/
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Mapa dos lugares aonde comprar ou recaregar seu cartão de transporte da URBS">
    <meta name="author" content="Kartão">
    <meta name="keywords" content="cartão, transporte, onibus, curitiba, mapa, urbs">
    <link rel="icon" href="./favicon.ico">

    <title>Mapa do Cartão Transporte de Curitiba</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/stylish-portfolio.css" rel="stylesheet">
    <link href="assets/css/kartao.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script>
var postos = {
'Rodoferroviária': 'Av. Presidente Affonso Camargo, 330',
'Rua da Cidadania Boa Vista': 'Av. Paraná, 3600 - Próx. Posto de Saúde 24h - Boa Vista',
'Rua da Cidadania Boqueirão': 'Terminal do Carmo',
'Rua da Cidadania Pinheirinho': 'Terminal do Pinheirinho',
'Rua da Cidadania Portão': 'Terminal do Fazendinha',
'Rua da Cidadania Santa Felicidade': 'Terminal Santa Felicidade - Santa Felicidade',
'Rua da Cidadania Matriz': 'Praça Rui Barbosa',
'Posto Avançado Tatuquara': 'Rua Pero Vaz de Caminha, 560 – Tatuquara'
};
var geocoder;
var map;
function initialize() {
  defaultLatLng = new google.maps.LatLng(-25.428954,-49.267137);
  var myLatlng = defaultLatLng;

  geocoder = new google.maps.Geocoder();
  var mapOptions = {
    zoom: 14,
    center: myLatlng
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  $.each(postos,function(name,address){
    codeAddress(address,name);
  });

  if(navigator.geolocation) {
      success = function(position) {
        myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        map.setCenter(myLatlng);
      };
      error = function() { console.log('Geocoding failure'); }

      navigator.geolocation.getCurrentPosition(success,error);
  }

}

var windowopen;
function codeAddress(address,title) {
    console.log(address+', Curitiba, Brasil');
    geocoder.geocode( { 'address': address+', Curitiba, Brasil'}, function(results, status) {
      console.log(results);
      if (status == google.maps.GeocoderStatus.OK) {
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location,
            title: title,
            color: "#369",
        });

        var infowindow = new google.maps.InfoWindow({
            content: '<div id="content"><h3>' + title + '</h3><p>' + address + '</p></div>',
        });

        google.maps.event.addListener(marker, 'click', function() {
            if (windowopen) windowopen.close();
            infowindow.open(map,marker);
            windowopen = infowindow;
        });
      } else {
        consol.log('Geocode was not successful for the following reason: ' + status);
      }
    });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>

  </head>

  <body>

    <!-- Navigation -->
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
            <li class="sidebar-brand">
                <a href="#top"  onclick = $("#menu-close").click(); >Kartão</a>
            </li>
            <li>
                <a href="#contact" onclick = $("#menu-close").click(); >Contato</a>
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <header id="top" class="header">
        <div class="text-vertical-center">
            <h1>Cartão Transporte de Curitiba</h1>
            <h3>Mapa dos lugares aonde comprar ou recarregar seu cartão de transporte da URBS</h3>
            <!--a href="#about" class="btn btn-dark btn-lg">Find Out More</a-->
            <div id="map-canvas"></div>
        </div>
    </header>


    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    </script>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

