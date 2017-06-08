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

$routes->get('/admin/kayttajat', function() {
    KayttajaController::users();
});

$routes->post('/admin/kayttajat', function() {
    KayttajaController::store();
});

$routes->get('/admin/newuser', function() {
    KayttajaController::newuser();
});

$routes->get('/admin/tilit', function() {
    TiliController::index();
});

$routes->get('/user', function() {
    HelloWorldController::userview();
});

$routes->get('/user/:tunnus', function($tunnus) {
    KayttajaController::show($tunnus);
});

$routes->get('/user/:tunnus/tiedot', function($tunnus) {
    KayttajaController::tiedot($tunnus);
});

$routes->get('/user/:tunnus/muokkaa', function($tunnus) {
    KayttajaController::muokkaa($tunnus);
});

//$routes->get('/user/:tunnus/uusitili', function($tunnus) {
//    KayttajaController::show($tunnus);
//});

//Staattisia näkymiä
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
