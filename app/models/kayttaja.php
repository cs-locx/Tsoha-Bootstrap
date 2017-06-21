<?php

class Kayttaja extends BaseModel {

    public $tunnus, $salasana, $nimi, $puhnro, $osoite, $email, $yllapitaja, $uusisalasana1, $uusisalasana2;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_tunnus', 'validate_salasana');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $rows = $query->fetchAll();
        $kayttajat = array();

        foreach ($rows as $row) {
            $kayttajat[] = new Kayttaja(array(
                'tunnus' => $row['tunnus'],
                'salasana' => $row['salasana'],
                'nimi' => $row['nimi'],
                'puhnro' => $row['puhnro'],
                'osoite' => $row['osoite'],
                'email' => $row['email'],
                'yllapitaja' => $row['yllapitaja']
            ));
        }
        return $kayttajat;
    }

    public static function find($tunnus) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE tunnus = :tunnus LIMIT 1');
        $query->execute(array('tunnus' => $tunnus));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'tunnus' => $row['tunnus'],
                'salasana' => $row['salasana'],
                'nimi' => $row['nimi'],
                'puhnro' => $row['puhnro'],
                'osoite' => $row['osoite'],
                'email' => $row['email'],
                'yllapitaja' => $row['yllapitaja']
            ));
            return $kayttaja;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (tunnus, salasana, nimi, puhnro, osoite, email, yllapitaja) '
                . 'VALUES (:tunnus, :salasana, :nimi, :puhnro, :osoite, :email, false)');

        $query->execute(array('tunnus' => $this->tunnus, 'salasana' => $this->salasana, 'nimi' => $this->nimi, 'puhnro' => $this->puhnro, 'osoite' => $this->osoite, 'email' => $this->email));
//
//        Kint::trace();
//        Kint::dump($row);
    }

    public function paivita() {
        $query = DB::connection()->prepare('UPDATE Kayttaja '
                . 'SET salasana = :salasana, nimi = :nimi, puhnro = :puhnro, osoite = :osoite, email = :email '
                . 'WHERE tunnus = :tunnus');

        $query->execute(array('tunnus' => $this->tunnus, 'salasana' => $this->salasana, 'nimi' => $this->nimi, 'puhnro' => $this->puhnro, 'osoite' => $this->osoite, 'email' => $this->email));
    }

    public function poista() {
        Tili::poista_kaytosta_kayttajalta($this->tunnus);
        $query = DB::connection()->prepare('DELETE FROM Kayttaja '
                . 'WHERE tunnus = :tunnus');

        $query->execute(array('tunnus' => $this->tunnus));
    }

    public function validate_tunnus() {
        $errors = array();
        if ($this->tunnus == '' || $this->tunnus == null) {
            $errors[] = 'Käyttäjätunnus ei saa olla tyhjä!';
        }
        if (strlen($this->tunnus) < 3) {
            $errors[] = 'Käyttäjätunnus on oltava vähintään 3 merkkiä pitkä.';
        }

        $kayttaja = Kayttaja::find($this->tunnus);
        if (isset($kayttaja->tunnus)) {
            $errors[] = 'Käyttäjätunnus on varattu!';
        }
        return $errors;
    }

    public function validate_salasana() {
        $errors = array();
        if ($this->salasana == '' || $this->salasana == null) {
            $errors[] = 'Salasana ei saa olla tyhjä!';
        }
        if (strlen($this->salasana) < 6) {
            $errors[] = 'Salasana on oltava vähintään 6 merkkiä pitkä.';
        }
        if (preg_match('~[0-9]~', $this->salasana) == false) {
            $errors[] = 'Salasanassa on oltava vähintään yksi numero.';
        }
        return $errors;
    }
    
    public function validate_uusi_salasana() {
        $errors = array();
        if (isset($this->uusisalasana1) || isset($this->uusisalasana2)) {
            if ($this->uusisalasana1 != $this->uusisalasana2) {
                $errors[] = 'Uudet salasanat eivät täsmänneet!';
            }
        }
        return $errors;
    }

    public static function tarkista($tunnus, $salasana) {
        $query = DB::connection()->prepare('SElECT * FROM Kayttaja WHERE tunnus = :tunnus AND salasana = :salasana LIMIT 1');
        $query->execute(array('tunnus' => $tunnus, 'salasana' => $salasana));
        $row = $query->fetch();

        if ($row) {
            return Kayttaja::find($tunnus);
        } else {
            return null;
        }
    }

    public function validate_muokkaus($attributes) {
        $errors = array();
        $muokattu_kayttaja = new Kayttaja($attributes);

        //jos käyttäjätunnusta vaihdetaan
        if ($this->tunnus != $muokattu_kayttaja->tunnus) {
            $errors = $muokattu_kayttaja->validate_tunnus();
        }
        // admin voi vaihtaa tietoja tietämättä käyttäjän salasanaa
        if (!self::get_user_logged_in()->yllapitaja) {
            if ($this->salasana != $muokattu_kayttaja->salasana) {
                $errors[] = 'Tarkista salasanasi!';
            }
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
