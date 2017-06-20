<?php

class TilitapahtumaController extends BaseController {

    public function show($tilinumero) {
        View::make('tili/index.html', array('tilinumero' => $tilinumero));
    }
    
}