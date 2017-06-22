<?php

class Tilitapahtuma extends BaseModel {

    public $tili, $summa, $aika, $id, $vastatili;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tilitapahtuma');
        $query->execute();
        $rows = $query->fetchAll();
        $tilitapahtumat = array();

        foreach ($rows as $row) {
            $tilitapahtumat[] = new Tili(array(
                'tili' => $row['tili'],
                'siirto' => $row['siirto'],
                'tyyppi' => $row['tyyppi'],
            ));
        }
        return $tilitapahtumat;
    }

    public static function hae_siirrot($tilinumero) {
        $query = DB::connection()->prepare('SELECT * FROM Tilisiirto '
                . 'WHERE lahtotili = :tilinumero OR kohdetili = :tilinumero');
        $query->execute(array('tilinumero' => $tilinumero));
        $rows = $query->fetchAll();

        return $rows;
    }

    public static function hae_tilitapahtumat($tilinumero) {
        $rows = Tilitapahtuma::hae_siirrot($tilinumero);
        $tilitapahtumat = array();

        foreach ($rows as $row) {
            if ($row['lahtotili'] == $tilinumero) {
                $summa = -1 * $row['summa'];
                $tili = $row['lahtotili'];
                $vastatili = $row['kohdetili'];
            } else {
                $summa = $row['summa'];
                $tili = $row['kohdetili'];
                $vastatili = $row['lahtotili'];
            }
            $tilitapahtumat[] = new Tilitapahtuma(array(
                'id' => $row['id'],
                'aika' => $row['aika'],
                'summa' => $summa,
                'tili' => $tili,
                'vastatili' => $vastatili
            ));
        }
        return $tilitapahtumat;
    }

    public function save() {
        
    }

}
