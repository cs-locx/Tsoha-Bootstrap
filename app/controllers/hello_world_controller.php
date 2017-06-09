<?php

require 'app/models/kayttaja.php';

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('etusivu.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function userview() {
        View::make('suunnitelmat/userview.html');
    }

    public static function tiliview() {
        View::make('suunnitelmat/tiliview.html');
    }

    public static function userinfo() {
        View::make('suunnitelmat/userinfo.html');
    }

    public static function userinfoedit() {
        View::make('suunnitelmat/userinfoedit.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        $kayttaja = new Kayttaja(array(
            'tunnus' => '',
            'salasana' => 'bani1',
            'nimi' => 'nimi',
            'puhnro' => 'sad',
            'osoite' => 'dsa',
            'email' => 'afsas',
            'yllapitaja' => false
        ));
        
        $errors = $kayttaja->errors();

        Kint::dump($errors);
    }

    public static function ydinlauma() {
        echo 'Hei ydinlauma!';
    }

}
