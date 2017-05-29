<?php

require 'app/models/kayttaja.php';

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('helloworld.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function adminview() {
        View::make('suunnitelmat/adminview.html');
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
        $osku = Kayttaja::find('oskajoha');
        $kayttajat = Kayttaja::findAll();

        Kint::dump($osku);
        Kint::dump($kayttajat);
    }

    public static function ydinlauma() {
        echo 'Hei ydinlauma!';
    }

}
