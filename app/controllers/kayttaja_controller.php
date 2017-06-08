<?php

class KayttajaController extends BaseController {

    public static function index() {
        View::make('admin/index.html');
    }

    public static function users() {
        $kayttajat = Kayttaja::all();
        View::make('admin/kayttajat.html', array('kayttajat' => $kayttajat));
    }

    public static function tilit() {
        $tilit = Tili::all();
        View::make('admin/tilit.html', array('tilit' => $tilit));
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

//        Kint::dump($params);

        $kayttaja->save();
        Redirect::to('/admin', array('message' => 'Käyttäjä ' . $kayttaja->tunnus . ' luotu onnistuneesti!'));
    }

    public static function show($tunnus) {
        $kayttaja = Kayttaja::find($tunnus);
        View::make('kayttaja/index.html', array('kayttaja' => $kayttaja));
        //täytyy ensin toteuttaa metodi, joka hakee kaikki tilit yhdeltä käyttäjältä
    }

    public static function tiedot($tunnus) {
        $kayttaja = Kayttaja::find($tunnus);
        View::make('kayttaja/tiedot.html', array('kayttaja' => $kayttaja));
    }

    public static function muokkaa($tunnus) {
        $kayttaja = Kayttaja::find($tunnus);
        View::make('kayttaja/muokkaa.html', array('kayttaja' => $kayttaja));
    }

}
