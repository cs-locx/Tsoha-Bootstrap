<?php

class TiliController extends BaseController {

    public static function tilit() {
        self::check_logged_in();
        $tilit = Tili::all();
        View::make('admin/tilit.html', array('tilit' => $tilit));
    }

    public static function uusitili() {
        self::check_logged_in();
        View::make('admin/uusitili.html');
    }

    
    
    public static function store() {
        self::check_logged_in();
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
