<?php

class TiliController extends BaseController {

    public static function tilit() {
        self::check_authorized('admin');
        $kaytossa = Tili::kaytossa();
        $deaktivoidut = Tili::deaktivoidut();
        View::make('admin/tilit.html', array('kaytossa' => $kaytossa, 'deaktivoidut' => $deaktivoidut));
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

        $errors = $tili->errors();
//        Kint::dump($errors);

        if (count($errors) > 0) {
            View::make('admin/uusitili.html', array('errors' => $errors, 'tunnus' => $tili->kayttaja));
        } else {
            $tili->save();
            $tilisiirto = new Siirto(array('kohdetili' => $tili->tilinumero, 'summa' => $params['saldo'], 'viesti' => 'Tili avattu saldolla ' . $params['saldo'] . '€'));
            $tilisiirto->tallenna();
            Redirect::to('/admin/tilit', array('message' => 'Tilin ' . $tili->tilinumero . ' luonti onnistui!'));
        }
    }

    public static function index($tilinumero) {
        $tili = Tili::find($tilinumero);
        self::check_authorized($tili->kayttaja);

        View::make('tili/index.html');
    }

    public static function poisto($tilinumero) {
        self::check_authorized('admin');
        View::make('admin/poistatili.html', array('tilinumero' => $tilinumero));
    }

    //halutaan, että tili jää olemaan, jotta vastapuoli pystyy tarkastelemaan tilitapahtumia, joten tili "deaktivoidaan"
    public static function poista_kaytosta($tilinumero) {
        self::check_authorized('admin');
        $tili = new Tili(array('tilinumero' => $tilinumero));
        $tili->poista_kaytosta();
        Redirect::to('/admin/tilit', array('message' => 'Tilin ' . $tilinumero . ' poisto onnistui!'));
    }

}
