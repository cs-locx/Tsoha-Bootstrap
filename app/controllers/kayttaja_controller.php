<?php

class KayttajaController extends BaseController {

    public static function index() {
        $kayttajat = Kayttaja::all();
        View::make('admin/adminview.html', array('kayttajat' => $kayttajat));
    }

    public static function newuser() {
        View::make('admin/newuser.html');
    }

    public static function store() {
        $params = $_POST;
        $kayttaja = new Kayttaja(array(
        'tunnus' => $params['tunnus'],
        'salasana' => $params['salasana'],
        'nimi' => $params['nimi'],
        'puhnro' => $params['puhnro'],
        'osoite' => $params['osoite'],
        'email' => $params['email']
        ));
        
        Kint::dump($params);
        
        $kayttaja->save();
//        Redirect::to('/admin' , array('message' => 'Uusi käyttäjä rekisteröity!'));
    }

//    public static function show($tunnus) {
//        $kayttaja = Kayttaja::find($tunnus);
//        View::make('suunnitelmat/userview.html', $kayttaja);
//        //täytyy ensin toteuttaa metodi, joka hakee kaikki tilit yhdeltä käyttäjältä
//    }
}
