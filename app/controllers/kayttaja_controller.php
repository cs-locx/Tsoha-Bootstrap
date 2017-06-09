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

        if (count($errors) == 0) {
            $kayttaja->save();
            Redirect::to('/admin', array('message' => 'Käyttäjä ' . $kayttaja->tunnus . ' luotu onnistuneesti!'));
        } else {
            View::make('/admin/newuser.html', array('errors' => $errors, 'attributes' => $attributes));
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

    public static function muokkaa($tunnus) {
        $kayttaja = Kayttaja::find($tunnus);
        View::make('kayttaja/muokkaa.html', array('kayttaja' => $kayttaja));
    }

}
