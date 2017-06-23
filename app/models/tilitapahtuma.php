<?php

class Tilitapahtuma extends BaseModel {

    public $tili, $summa, $aika, $id, $vastatili;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function hae_tilitapahtumat($tilinumero) {
        $rows = Siirto::etsi($tilinumero);
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
                'viesti' => $row['viesti'],
                'summa' => $summa,
                'tili' => $tili,
                'vastatili' => $vastatili
            ));
        }
    }

    public function save() {
        
    }

}
