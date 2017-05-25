<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/adminview', function() {
    HelloWorldController::adminview();
});

$routes->get('/userview', function() {
    HelloWorldController::userview();
});

$routes->get('/tiliview', function() {
    HelloWorldController::tiliview();
});

$routes->get('/userinfo', function() {
    HelloWorldController::userinfo();
});

$routes->get('/userinfoedit', function() {
    HelloWorldController::userinfoedit();
});

$routes->get('/sandbox', function() {
    HelloWorldController::sandbox();
});

$routes->get('/ydinlauma', function() {
    HelloWorldController::ydinlauma();
});
