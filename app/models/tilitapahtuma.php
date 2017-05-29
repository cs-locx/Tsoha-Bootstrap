<?php

class Tilitapahtuma extends BaseModel {
    public $tili, $siirto, $tyyppi;
   
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tilitapahtuma');
        $query->execute();
        $rows = $query->fetchAll();
        $tilitapahtumat = array();
        
        foreach($rows as $row) {
            $tilitapahtumat[] = new Tili(array(
                'tili' => $row['tili'],
                'siirto' => $row['siirto'],
                'tyyppi' => $row['tyyppi'],
            ));
        }
        return $tilitapahtumat;
    }
}

