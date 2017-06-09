<?php

class Siirto extends BaseModel {

    public $id, $aika, $summa;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Siirto');
        $query->execute();
        $rows = $query->fetchAll();
        $siirrot = array();

        foreach ($rows as $row) {
            $siirrot[] = new Tili(array(
                'id' => $row['id'],
                'aika' => $row['aika'],
                'summa' => $row['summa'],
            ));
        }
        return $siirrot;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Siirto (aika, summa) VALUES (NOW(), :summa) RETURNING id');
        $query->execute(array('summa' => $this->summa));
        $row = $query->fetch();
        
        $this->id = $row['id'];
        
        // Kutsutaan tilitapahtuma-luokan metodia save() sekä lähtö- että kohdetilille
        
    }

}
