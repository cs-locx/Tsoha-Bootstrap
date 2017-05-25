<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('helloworld.html');
    }

    public static function adminview() {
        View::make('adminview.html');
    }
    
    public static function userview() {
        View::make('userview.html');
    }

    public static function tiliview() {
        View::make('tiliview.html');
    }
    
    public static function userinfo() {
        View::make('userinfo.html');
    }
    
    public static function userinfoedit() {
        View::make('userinfoedit.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        echo 'Aika makeeta!';
    }

    public static function ydinlauma() {
        echo 'Hei ydinlauma!';
    }

}
