<?php

class Tili extends BaseModel {

    public $tilinumero, $saldo, $siirtoraja, $kayttaja;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_saldo', 'validate_siirtoraja', 'validate_omistaja');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tili');
        $query->execute();
        $rows = $query->fetchAll();
        $tilit = array();

        foreach ($rows as $row) {
            $tilit[] = new Tili(array(
                'tilinumero' => $row['tilinumero'],
                'saldo' => self::laske_saldo($row['tilinumero']),
                'siirtoraja' => $row['siirtoraja'],
                'kayttaja' => $row['kayttaja'],
                'kaytossa' => $row['kaytossa']
            ));
        }
        return $tilit;
    }
    
    public static function kaytossa() {
        $query = DB::connection()->prepare('SELECT * FROM Tili WHERE kaytossa = true');
        $query->execute();
        $rows = $query->fetchAll();
        $tilit = array();

        foreach ($rows as $row) {
            $tilit[] = new Tili(array(
                'tilinumero' => $row['tilinumero'],
                'saldo' => self::laske_saldo($row['tilinumero']),
                'siirtoraja' => $row['siirtoraja'],
                'kayttaja' => $row['kayttaja'],
                'kaytossa' => $row['kaytossa']
            ));
        }
        return $tilit;
    }
    
    public static function deaktivoidut() {
        $query = DB::connection()->prepare('SELECT * FROM Tili WHERE kaytossa = false');
        $query->execute();
        $rows = $query->fetchAll();
        $tilit = array();

        foreach ($rows as $row) {
            $tilit[] = new Tili(array(
                'tilinumero' => $row['tilinumero'],
                'saldo' => self::laske_saldo($row['tilinumero']),
                'siirtoraja' => $row['siirtoraja'],
                'kayttaja' => $row['kayttaja'],
                'kaytossa' => $row['kaytossa']
            ));
        }
        return $tilit;
    }

    public static function find($tilinumero) {
        $query = DB::connection()->prepare('SELECT * FROM Tili WHERE tilinumero = :tilinumero LIMIT 1');
        $query->execute(array('tilinumero' => $tilinumero));
        $row = $query->fetch();

        if ($row) {
            $tili = new Tili(array(
                'tilinumero' => $row['tilinumero'],
                'saldo' => self::laske_saldo($row['tilinumero']),
                'siirtoraja' => $row['siirtoraja'],
                'kayttaja' => $row['kayttaja'],
                'kaytossa' => $row['kaytossa']
            ));

            return $tili;
        }
        return null;
    }

    public static function findfor($tunnus) {
        //kaikki tilit, jotka kuuluvat käyttäjätunnukselle $tunnus
        $query = DB::connection()->prepare('SELECT * FROM Tili WHERE kayttaja = :tunnus');
        $query->execute(array('tunnus' => $tunnus));
        $rows = $query->fetchAll();
        $tilit = array();

        foreach ($rows as $row) {
            $tilit[] = new Tili(array(
                'tilinumero' => $row['tilinumero'],
                'saldo' => self::laske_saldo($row['tilinumero']),
                'siirtoraja' => $row['siirtoraja'],
                'kayttaja' => $row['kayttaja'],
                'kaytossa' => $row['kaytossa']
            ));
        }
        return $tilit;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tili (siirtoraja, kayttaja, kaytossa) VALUES (:siirtoraja, :kayttaja, true) RETURNING tilinumero');
        $query->execute(array('siirtoraja' => $this->siirtoraja, 'kayttaja' => $this->kayttaja));
        $row = $query->fetch();

        $this->tilinumero = $row['tilinumero'];

        //Kutsutaan Siirto-luokan metodia save() lisätäksemme alkusaldon tilitapahtumiin
    }

    public function poista() {
        $query = DB::connection()->prepare('DELETE FROM Tili WHERE tilinumero = :tilinumero');
        $query->execute(array('tilinumero' => $this->tilinumero));
    }

    public static function poista_kayttajalta($tunnus) {
        $query = DB::connection()->prepare('DELETE FROM Tili WHERE kayttaja = :kayttaja');
        $query->execute(array('kayttaja' => $tunnus));
    }

    //jos tili poistetaan käytöstä, omistajuus siirtyy adminille, jotta tilitapahtumat säilyvät
    public function poista_kaytosta() {
        $query = DB::connection()->prepare('UPDATE Tili '
                . 'SET kaytossa = false WHERE tilinumero = :tilinumero');
        $query->execute(array('tilinumero' => $this->tilinumero));
    }

    public static function poista_kaytosta_kayttajalta($tunnus) {
        $query = DB::connection()->prepare('UPDATE Tili '
                . 'SET kaytossa = false WHERE kayttaja = :kayttaja');
        $query->execute(array('kayttaja' => $tunnus));
    }

    public function validate_saldo() {
        $errors = array();

        if ($this->saldo < 0) {
            $errors[] = 'Saldo ei voi olla negatiivista!';
        }
        if ($this->saldo > 9999999999) {
            $errors[] = 'Saldo on liian suuri!';
        }
        
        return $errors;
    }

    public function validate_siirtoraja() {
        $errors = array();

        if ($this->siirtoraja < 0) {
            $errors[] = 'Siirtoraja ei voi olla negatiivinen!';
        }
        if ($this->siirtoraja > 9999999999) {
            $errors[] = 'Siirtoraja on liian suuri!';
        }
        return $errors;
    }

    public function validate_omistaja() {
        $errors = array();
    
        $kayttaja = Kayttaja::find($this->kayttaja);
        if ($kayttaja == null) {
            $errors[] = 'Tarkista käyttäjätunnus!';
        }
        return $errors;
    }

    public static function laske_saldo($tilinumero) {
        $tilitapahtumat = Tilitapahtuma::hae_tilitapahtumat($tilinumero);
        $saldo = 0;
        foreach ($tilitapahtumat as $tilitapahtuma) {
            $saldo += $tilitapahtuma->summa;
        }
        return $saldo;
    }
}
