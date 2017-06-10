<?php

class KayttajaController extends BaseController {

    public static function index() {
        View::make('admin/index.html');
    }

    public static function kayttajat() {
        $kayttajat = Kayttaja::all();
        View::make('admin/kayttajat.html', array('kayttajat' => $kayttajat));
    }

    public static function uusikayttaja() {
        View::make('admin/newuser.html');
    }

    public static function store() {
        $params = $_POST;
        $attributes = array(
            'tunnus' => $params['tunnus'],
            'salasana' => $params['salasana'],
            'nimi' => $params['nimi'],
            'puhnro' => $params['puhnro'],
            'osoite' => $params['osoite'],
            'email' => $params['email']
        );
        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if (count($errors) > 0) {
            View::make('admin/newuser.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $kayttaja->save();
            Redirect::to('/admin', array('message' => 'Käyttäjän ' . $kayttaja->tunnus . ' luonti onnistui!'));
        }
//        Kint::dump($params);
    }

    public static function show($tunnus) {
        $kayttaja = Kayttaja::find($tunnus);
        $tilit = Tili::findfor($tunnus);
        View::make('kayttaja/index.html', array('kayttaja' => $kayttaja, 'tilit' => $tilit));
        //täytyy ensin toteuttaa metodi, joka hakee kaikki tilit yhdeltä käyttäjältä
    }

    public static function tiedot($tunnus) {
        $kayttaja = Kayttaja::find($tunnus);
        View::make('kayttaja/tiedot.html', array('kayttaja' => $kayttaja));
    }

    public static function muokkaus($tunnus) {
        $kayttaja = Kayttaja::find($tunnus);
        View::make('kayttaja/muokkaa.html', array('kayttaja' => $kayttaja));
    }

    public static function paivita($tunnus) {
        $params = $_POST;

        $attributes = array(
            'tunnus' => $params['tunnus'],
            'salasana' => $params['salasana'],
            'nimi' => $params['nimi'],
            'puhnro' => $params['puhnro'],
            'osoite' => $params['osoite'],
            'email' => $params['email']
        );

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if (count($errors) > 0) {
            View::make('kayttaja/muokkaa.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $kayttaja->paivita();
            Redirect::to('kayttaja/' . $tunnus . '/tiedot', array('message' => 'Tietojen muokkaus onnistui!'));
        }
    }

    public static function poisto($tunnus) {
        $kayttaja = Kayttaja::find($tunnus);
        View::make('admin/poisto.html', array ('kayttaja' => $kayttaja));
    }

        public static function poista($tunnus) {
        $kayttaja = new Kayttaja(array('tunnus' => $tunnus));
        $kayttaja->poista();

        Redirect::to('/admin', array('message' => 'Käyttäjän ' . $tunnus . ' poisto onnistui!'));
    }

}
