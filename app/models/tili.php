<?php

class Tili extends BaseModel {

    public $tilinumero, $saldo, $siirtoraja, $kayttaja;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tili');
        $query->execute();
        $rows = $query->fetchAll();
        $tilit = array();

        foreach ($rows as $row) {
            $tilit[] = new Tili(array(
                'tilinumero' => $row['tilinumero'],
                'saldo' => $row['saldo'],
                'siirtoraja' => $row['siirtoraja'],
                'kayttaja' => $row['kayttaja'],
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
                'saldo' => $row['saldo'],
                'siirtoraja' => $row['siirtoraja'],
                'kayttaja' => $row['kayttaja'],
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
                'saldo' => $row['saldo'],
                'siirtoraja' => $row['siirtoraja'],
                'kayttaja' => $row['kayttaja'],
            ));
        }
        return $tilit;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tili (saldo, siirtoraja, kayttaja) VALUES (:saldo, :siirtoraja, :kayttaja) RETURNING tilinumero');
        $query->execute(array('saldo' => $this->saldo, 'siirtoraja' => $this->siirtoraja, 'kayttaja' => $this->kayttaja));
        $row = $query->fetch();

//        Kint::trace();
//        Kint::dump($row);

        $this->tilinumero = $row['tilinumero'];
        
        
        //Kutsutaan Siirto-luokan metodia save() lisätäksemme alkusaldon tilitapahtumiin
    }

}
