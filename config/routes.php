<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/login', function() {
    KayttajaController::login();
});

$routes->post('/login', function() {
    KayttajaController::kirjaudu();
});

$routes->post('/logout', function() {
    KayttajaController::logout();
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

$routes->post('/admin/poista/:tunnus', function($tunnus) {
    KayttajaController::poista($tunnus);
});

$routes->get('/admin/tilit', function() {
    TiliController::tilit();
});

$routes->post('/admin/tilit', function() {
    TiliController::store();
});

$routes->get('/admin/uusitili', function() {
    TiliController::uusitili(null);
});

$routes->get('/admin/uusitili/:tunnus', function($tunnus) {
    TiliController::uusitili($tunnus);
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

$routes->post('/user/:tunnus', function($tunnus) {
    KayttajaController::paivita($tunnus);
});

$routes->post('/user/poista', function($tunnus) {
    KayttajaController::paivita($tunnus);
});

$routes->get('/tili/:tilinumero', function($tilinumero) {
    TilitapahtumaController::show($tilinumero);
});

//ylimääräisiä sivuja
$routes->get('/sandbox', function() {
    HelloWorldController::sandbox();
});

$routes->get('/ydinlauma', function() {
    HelloWorldController::ydinlauma();
});