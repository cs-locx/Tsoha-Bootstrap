<?php

class TilitapahtumaController extends BaseController {

    public static function show($tilinumero) {
        $tili = Tili::find($tilinumero);
        self::check_authorized($tili->kayttaja);
        
        $tilitapahtumat = Tilitapahtuma::hae_tilitapahtumat($tilinumero);
        View::make('tilitapahtuma/index.html', array('tilitapahtumat' => $tilitapahtumat, 'tili' => $tili));
    }

    public static function siirto($tilinumero) {
        $tili = Tili::find($tilinumero);
        self::check_authorized($tili->kayttaja);
        
        View::make('tilitapahtuma/siirto.html', array('tili' => $tili));
    }
    
    public static function siirrot() {
        self::check_authorized('admin');
        $siirrot = Siirto::etsi_kaikki();
        
        View::make('admin/tilisiirrot.html', array('siirrot' => $siirrot));
    }
}
