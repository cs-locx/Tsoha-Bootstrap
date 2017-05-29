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
        
        foreach($rows as $row) {
            $siirrot[] = new Tili(array(
                'id' => $row['id'],
                'aika' => $row['aika'],
                'summa' => $row['summa'],
            ));
        }
        return $siirrot;
    }
}
