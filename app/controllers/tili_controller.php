<?php

class TiliController extends BaseController {

    public static function tilit() {
        $tilit = Tili::all();
        View::make('admin/tilit.html', array('tilit' => $tilit));
    }

    public static function uusitili() {
        View::make('admin/uusitili.html');
    }

    
    
    public static function store() {
        $params = $_POST;
        $tili = new Tili(array(
            'kayttaja' => $params['kayttaja'],
            'saldo' => $params['saldo'],
            'siirtoraja' => $params['siirtoraja']
        ));

//        Kint::dump($params);

        $tili->save();
        Redirect::to('/admin' , array('message' => 'Tili ' . $tili->tilinumero . ' luotu onnistuneesti!'));
    }

}
