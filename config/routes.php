<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/admin', function() {
    KayttajaController::index();
});

$routes->post('/admin', function() {
    KayttajaController::store();
});

$routes->get('/admin/newuser', function() {
    KayttajaController::newuser();
});

$routes->get('/user', function() {
    HelloWorldController::userview();
});

//$routes->get('/user/:tunnus', function($tunnus) {
//    KayttajaController::show($tunnus);
//    //täytyy toteuttaa metodi, joka hakee kaikki tilit yhdeltä käyttäjältä
//});

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
