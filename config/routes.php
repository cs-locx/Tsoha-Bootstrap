<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/test', function() {
    HelloWorldController::sandbox();
  });
  
   $routes->get('/testi', function() {
    HelloWorldController::testifunktio();
  });
