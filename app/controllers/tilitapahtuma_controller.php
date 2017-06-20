<?php

class TilitapahtumaController extends BaseController {

    public function show($tilinumero) {
        $tilitapahtumat = Tilitapahtuma::hae_tilitapahtumat($tilinumero);
        View::make('tilitapahtuma/index.html', array('tilitapahtumat' => $tilitapahtumat));
    }
    
}