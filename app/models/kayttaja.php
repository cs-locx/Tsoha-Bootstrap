<?php

class Kayttaja extends BaseModel {

    public $tunnus, $salasana, $nimi, $puhnro, $osoite, $email;

    public function __construct($attributes) {
        parent::__construct($attributes);
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
                'email' => $row['email']
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
                'email' => $row['email']
            ));
            return $kayttaja;
        }
        return null;
    }

}
