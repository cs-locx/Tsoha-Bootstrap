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
    KayttajaController::kayttajat();
});

$routes->post('/admin/kayttajat', function() {
    KayttajaController::store();
});

$routes->get('/admin/uusikayttaja', function() {
    KayttajaController::uusikayttaja();
});

$routes->get('/admin/poista/:tunnus', function($tunnus) {
    KayttajaController::poisto($tunnus);
});

$routes->post('/admin/poista', function() {
    KayttajaController::poista();
});

$routes->get('/admin/tilit', function() {
    TiliController::tilit();
});

$routes->post('/admin/tilit', function() {
    TiliController::store();
});

$routes->get('/admin/uusitili', function() {
    TiliController::uusitili();
});

$routes->get('/user/:tunnus', function($tunnus) {
    KayttajaController::show($tunnus);
});

$routes->get('/user/:tunnus/tiedot', function($tunnus) {
    KayttajaController::tiedot($tunnus);
});

$routes->get('/user/:tunnus/muokkaa', function($tunnus) {
    KayttajaController::muokkaus($tunnus);
});

$routes->post('/user/:tunnus/tiedot', function($tunnus) {
    KayttajaController::paivita($tunnus);
});

$routes->post('/user/poista', function($tunnus) {
    KayttajaController::paivita($tunnus);
});


//Staattisia näkymiä
$routes->get('/user', function() {
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
