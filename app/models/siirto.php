<?php

class Siirto extends BaseModel {

    public $id, $aika, $summa, $lahtotili, $kohdetili;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function etsi($tilinumero) {
        $query = DB::connection()->prepare('SELECT * FROM Siirto '
                . 'WHERE lahtotili = :tilinumero OR kohdetili = :tilinumero');
        $query->execute(array('tilinumero' => $tilinumero));
        $rows = $query->fetchAll();
        $siirrot = array();

        foreach ($rows as $row) {
            $siirrot[] = new Siirto(array(
                'id' => $row['id'],
                'aika' => $row['aika'],
                'summa' => $row['summa'],
                'lahtotili' => $row['lahtotili'],
                'kohdetili' => $row['kohdetili']
            ));
        }
        return $siirrot;
    }

    public static function etsi_kaikki() {
        $query = DB::connection()->prepare('SELECT * FROM Siirto');
        $query->execute();
        $rows = $query->fetchAll();
        $siirrot = array();

        foreach ($rows as $row) {
            $siirrot[] = new Tili(array(
                'id' => $row['id'],
                'aika' => $row['aika'],
                'summa' => $row['summa'],
                'lahtotili' => $row['lahtotili'],
                'kohdetili' => $row['kohdetili']
            ));
        }
        return $siirrot;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Siirto (aika, summa, lahtotili, kohdetili) VALUES (NOW(), :summa, :lahtotili, :kohdetili) RETURNING id');
        $query->execute(array('summa' => $this->summa, 'lahtotili' => $this->lahtotili, 'kohdetili' => $this->kohdetili));
        $row = $query->fetch();

        $this->id = $row['id'];

        // Kutsutaan tilitapahtuma-luokan metodia save() sekä lähtö- että kohdetilille
    }

}
