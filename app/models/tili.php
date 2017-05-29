<?php

class Tili extends BaseModel {
    public $tilinumero, $saldo, $nostoraja, $kayttaja;
   
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tili');
        $query->execute();
        $rows = $query->fetchAll();
        $tilit = array();
        
        foreach($rows as $row) {
            $tilit[] = new Tili(array(
                'tilinumero' => $row['tilinumero'],
                'saldo' => $row['saldo'],
                'nostoraja' => $row['nostoraja'],
                'kayttaja' => $row['kayttaja'],
            ));
        }
        return $tilit;
    }
}

