<?php

class BaseController {

    public static function get_user_logged_in() {
        // Toteuta kirjautuneen käyttäjän haku tähän
        if (isset($_SESSION['kayttaja'])) {
            $tunnus = $_SESSION['kayttaja'];
            $kayttaja = Kayttaja::find($tunnus);

            return $kayttaja;
        }
        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['kayttaja'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

    public static function check_authorized($tunnus) {
        self::check_logged_in();

        if ($_SESSION['kayttaja'] == $tunnus || $_SESSION['kayttaja'] == 'admin') {
            
        } else {
            Redirect::to('/user/' . $_SESSION['kayttaja'], array('error' => 'Sinulla ei ole oikeuksia kyseiselle sivulle!'));
        }
    }

}
