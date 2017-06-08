<?php

class TiliController extends BaseController {
    
    public static function index() {
        $tilit = Tili::all();
        View::make('admin/tilit.html', array('tilit' => $tilit));
    }

    public static function luotili() {
        View::make('admin/luotili.html');
    }

    public static function store() {
        $params = $_POST;
        $tili = new Tili(array(
        'tilinumero' => $params['tilinumero'],
        'saldo' => $params['saldo'],
        'siirtoraja' => $params['siirtoraja'],
        'kayttaja' => $params['kayttaja']
        ));
        
//        Kint::dump($params);
        
        $tili->save();
        Redirect::to('/admin' , array('message' => 'Käyttäjä ' . $kayttaja->tunnus . ' luotu onnistuneesti!'));
    }
}
