<?php

class Tilitapahtuma extends BaseModel {

    public $tili, $summa, $aika, $id, $vastatili, $viesti;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

//    public static function hae_tilitapahtuma($id) {
//        $row = Siirto::etsi($id);
//
//        if ($row) {
//            if ($row['lahtotili'] == $tilinumero) {
//                $summa = -1 * $row['summa'];
//                $tili = $row['lahtotili'];
//                $vastatili = $row['kohdetili'];
//            } else {
//                $summa = $row['summa'];
//                $tili = $row['kohdetili'];
//                $vastatili = $row['lahtotili'];
//            }
//            $tilitapahtuma = new Tilitapahtuma(array(
//                'id' => $row['id'],
//                'aika' => $row['aika'],
//                'viesti' => $row['viesti'],
//                'summa' => $summa,
//                'tili' => $tili,
//                'vastatili' => $vastatili
//                ));
//            return $tilitapahtuma;
//        }        
//        return null;
//    }

    public static function hae_tilitapahtumat($tilinumero) {
        $siirrot = Siirto::etsi_tililta($tilinumero);
        $tilitapahtumat = array();

        foreach ($siirrot as $siirto) {
            if ($siirto->lahtotili == $tilinumero) {
                $summa = -1 * $siirto->summa;
                $tili = $siirto->lahtotili;
                $vastatili = $siirto->kohdetili;
            } else {
                $summa = $siirto->summa;
                $tili = $siirto->kohdetili;
                $vastatili = $siirto->lahtotili;
            }
            $tilitapahtumat[] = new Tilitapahtuma(array(
                'id' => $siirto->id,
                'aika' => $siirto->aika,
                'viesti' => $siirto->viesti,
                'summa' => $summa,
                'tili' => $tili,
                'vastatili' => $vastatili
                ));
        }
        return $tilitapahtumat;
    }
}
