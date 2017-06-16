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

        View::make('kayttaja/muokkaa.html', array('kayttaja' => $kayttaja));
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
            'email' => $params['email'],
            'uusisalasana1' => $params['uusisalasana1'],
            'uusisalasana2' => $params['uusisalasana2']
        );

        $kayttaja = new Kayttaja($attributes);
        $errors = KayttajaController::validate_muokkaus($tunnus, $attributes);
        
//        Kint::dump($errors);

        if (count($errors) > 0) {
            View::make('kayttaja/muokkaa.html', array('errors' => $errors, 'kayttaja' => $attributes));
        } else {
            $kayttaja->salasana = $attributes['uusisalasana1'];
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

    private static function validate_muokkaus($tunnus, array $attributes) {
        $errors = array();
        $kayttaja = Kayttaja::find($tunnus);
        $muokattu_kayttaja = new Kayttaja($attributes);

        //jos käyttäjätunnusta vaihdetaan
        if ($tunnus != $muokattu_kayttaja->tunnus) {
            $errors = $muokattu_kayttaja->validate_tunnus();
        }
        // admin voi vaihtaa tietoja tietämättä käyttäjän salasanaa
        if (!self::get_user_logged_in()->yllapitaja && $kayttaja->salasana != $muokattu_kayttaja->salasana) {
            $errors[] = 'Tarkista salasanasi!';
        }
        //jos vaihdetaan salasanaa
        if ($attributes['uusisalasana1'] != '' || $attributes['uusisalasana2'] != '') {
            if ($attributes['uusisalasana1'] != $attributes['uusisalasana2']) {
                $errors[] = 'Uudet salasanat eivät täsmänneet!';
            } else {
                $muokattu_kayttaja->salasana = $attributes['uusisalasana1'];
                $salasana_errors = $muokattu_kayttaja->validate_salasana();
                $errors = array_merge($errors, $salasana_errors);
            }
        }
        return $errors;
    }

}
