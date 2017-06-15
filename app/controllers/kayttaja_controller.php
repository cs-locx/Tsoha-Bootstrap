<?php

class KayttajaController extends BaseController {

    public static function index() {
        self::check_authorized('admin');
        View::make('admin/index.html');
    }

    public static function login() {
        View::make('login.html');
    }

    public static function kirjaudu() {
        $params = $_POST;

        $kayttaja = Kayttaja::tarkista($params['tunnus'], $params['salasana']);

        if (!$kayttaja) {
            View::make('login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'tunnus' => $params['tunnus']));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->tunnus;
            if ($kayttaja->yllapitaja) {
                Redirect::to('/admin');
            } else {
                Redirect::to('/user/' . $kayttaja->tunnus, array('message' => 'Tervetuloa takaisin, ' . $kayttaja->nimi . '!'));
            }
        }
    }

    public static function logout() {
        $_SESSION['kayttaja'] = null;
        Redirect::to('/login', array('message' => 'Uloskirjautuminen onnistui!'));
    }

    public static function kayttajat() {
        self::check_authorized('admin');

        $kayttajat = Kayttaja::all();
        View::make('admin/kayttajat.html', array('kayttajat' => $kayttajat));
    }

    public static function uusikayttaja() {
        self::check_authorized('admin');
        View::make('admin/newuser.html');
    }

    public static function store() {
        self::check_authorized('admin');
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
            Redirect::to('/admin/kayttajat', array('message' => 'Käyttäjän ' . $kayttaja->tunnus . ' luonti onnistui!'));
        }
//        Kint::dump($params);
    }

    public static function show($tunnus) {
        self::check_authorized($tunnus);

        $kayttaja = Kayttaja::find($tunnus);
        $tilit = Tili::findfor($tunnus);
        View::make('kayttaja/index.html', array('kayttaja' => $kayttaja, 'tilit' => $tilit));
    }

    public static function tiedot($tunnus) {
        self::check_authorized($tunnus);

        $kayttaja = Kayttaja::find($tunnus);
        View::make('kayttaja/tiedot.html', array('kayttaja' => $kayttaja));
    }

    public static function muokkaus($tunnus) {
        self::check_authorized($tunnus);
        $kayttaja = Kayttaja::find($tunnus);
        $tekija = self::get_user_logged_in();

        View::make('kayttaja/muokkaa.html', array('kayttaja' => $kayttaja, 'tekija' => $tekija));
    }

    public static function paivita($tunnus) {
        self::check_authorized($tunnus);
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

        $salasanat = array(
            'salasana' => $params['salasana'],
            'salasana1' => $params['uusisalasana1'],
            'salasana2' => $params['uusisalasana2']
        );
        $salasanaerrors = KayttajaController::tarkista_salasana($tunnus, $salasanat);
        $errors = array_merge($errors, $salasanaerrors);

        if (count($errors) > 0) {
            View::make('kayttaja/muokkaa.html', array('errors' => $errors, 'kayttaja' => $attributes));
        } else {
            $kayttaja->paivita();
            Redirect::to('/user/' . $kayttaja->tunnus . '/tiedot', array('message' => 'Tietojen muokkaus onnistui!'));
        }
    }

    public static function poisto($tunnus) {
        self::check_authorized('admin');
        $kayttaja = Kayttaja::find($tunnus);
        View::make('admin/poisto.html', array('kayttaja' => $kayttaja));
    }

    public static function poista($tunnus) {
        self::check_authorized('admin');
        $kayttaja = new Kayttaja(array('tunnus' => $tunnus));
        $kayttaja->poista();

        Redirect::to('/admin/kayttajat', array('message' => 'Käyttäjän "' . $tunnus . '" poisto onnistui!'));
    }

    private static function tarkista_salasana($tunnus, $salasanat) {
        $vanhasalasana = Kayttaja::find($tunnus)->salasana;
        $errors = array();
        // admin voi vaihtaa tietoja tietämättä käyttäjän salasanaa
        if (!self::get_user_logged_in()->yllapitaja && $salasanat['salasana'] != $vanhasalasana) {
            $errors[] = 'Tarkista salasanasi!';
        }
        if ($salasanat['uusisalasana1'] != $salasanat['uusisalasana2']) {
            $errors[] = 'Uudet salasanasi eivät täsmänneet!';
        }
        return $errors;
    }

}
