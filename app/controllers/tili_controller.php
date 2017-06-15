<?php

class TiliController extends BaseController {

    public static function tilit() {
        self::check_authorized('admin');
        $tilit = Tili::all();
        View::make('admin/tilit.html', array('tilit' => $tilit));
    }

    public static function uusitili($tunnus) {
        self::check_authorized('admin');
        View::make('admin/uusitili.html', array('tunnus' => $tunnus));
    }

    
    
    public static function store() {
        self::check_authorized('admin');
        $params = $_POST;
        $tili = new Tili(array(
            'kayttaja' => $params['kayttaja'],
            'saldo' => $params['saldo'],
            'siirtoraja' => $params['siirtoraja']
        ));

//        Kint::dump($params);

        $tili->save();
        Redirect::to('/admin/tilit' , array('message' => 'Tilin ' . $tili->tilinumero . ' luonti onnistui!'));
    }

}
