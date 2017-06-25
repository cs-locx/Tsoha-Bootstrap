<?php

class Siirto extends BaseModel {

    public $id, $aika, $summa, $lahtotili, $kohdetili, $viesti;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_summa', 'validate_kohdetili', 'validate_viesti');
    }

    public static function etsi($id) {
        $query = DB::connection()->prepare('SELECT * FROM Siirto WHERE id = :id');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if ($row) {
            $siirto = new Siirto(array(
                'id' => $row['id'],
                'aika' => $row['aika'],
                'summa' => $row['summa'],
                'lahtotili' => $row['lahtotili'],
                'kohdetili' => $row['kohdetili'],
                'viesti' => $row['viesti']
                ));
            return $siirto;
        } 
        return null;
    }

    public static function etsi_tililta($tilinumero) {
        $query = DB::connection()->prepare('SELECT * FROM Siirto '
            . 'WHERE lahtotili = :tilinumero OR kohdetili = :tilinumero');
        $query->execute(array('tilinumero' => $tilinumero));
        $rows = $query->fetchAll();
        $siirrot = array();

        foreach ($rows as $row) {
            $siirrot[] = new Siirto(array(
                'id' => $row['id'],
                'aika' => $row['aika'],
                'summa' => $row['summa'],
                'lahtotili' => $row['lahtotili'],
                'kohdetili' => $row['kohdetili'],
                'viesti' => $row['viesti']
                ));
        }
        return $siirrot;
    }

    public static function etsi_kaikki() {
        $query = DB::connection()->prepare('SELECT * FROM Tilisiirto');
        $query->execute();
        $rows = $query->fetchAll();
        $siirrot = array();

        foreach ($rows as $row) {
            $siirrot[] = new Siirto(array(
                'id' => $row['id'],
                'aika' => $row['aika'],
                'summa' => $row['summa'],
                'lahtotili' => $row['lahtotili'],
                'kohdetili' => $row['kohdetili'],
                'viesti' => $row['viesti']
                ));
        }
        return $siirrot;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Tilisiirto (aika, summa, lahtotili, kohdetili, viesti) 
            VALUES (NOW(), :summa, :lahtotili, :kohdetili, :viesti) RETURNING id');
        $query->execute(array('summa' => $this->summa, 'lahtotili' => $this->lahtotili, 'kohdetili' => $this->kohdetili, 'viesti' => $this->viesti));
        $row = $query->fetch();

        $this->id = $row['id'];
    }

    public function paivita() {
        $query = DB::connection()->prepare('UPDATE Tilisiirto 
            SET aika = :aika, summa = :summa, lahtotili = :lahtotili, kohdetili = :kohdetili, viesti = :viesti
            WHERE id = :id');
        $query->execute(array('id' => $this->id, 'aika' => $this->aika, 'summa' => $this->summa, 'lahtotili' => $this->lahtotili, 'kohdetili' => $this->kohdetili, 'viesti' => $this->viesti));
    }

    public function poista() {
        $query = DB::connection()->prepare('DELETE FROM Tilisiirto WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function validate_summa() {
        $tili = Tili::find($this->lahtotili);
        $kohdetili = Tili::find($this->kohdetili);
        $errors = array();

        if (($tili->saldo - $this->summa) < 0) {
            $errors[] = "Tilillä ei ole tarpeeksi katetta!";
        }
        if (($kohdetili->saldo + $this->summa) > 9999999999) {
            $errors[] = 'Vastapuolen tilille ei mahdu näin iso summa!';
        }       
        if ($this->summa < 0) {
            $errors[] = "Et voi lähettää negatiivista summaa!";   
        }
        if ($this->summa > 9999999999) {
            $errors[] = 'Et voi siirtää näin isoa summaa!';
        }
        if ($this->summa == 0 || $this->summa == null) {
            $errors[] = 'Et voi lähettää tyhjää tilisiirtoa.';
        }
        return $errors;
    }

    public function validate_kohdetili() {
        $tili = Tili::find($this->kohdetili);
        $errors = array();

        if ($tili == null) {
            $errors[] = 'Kohdetiliä ei ole olemassa, tarkista tilinumero!';
        }
        if ($this->lahtotili == $this->kohdetili) {
            $errors[] = 'Et voi siirtää rahaa tililtä itselleen!';
        }
        return $errors;
    }

    public function validate_viesti() {
        $errors = array();

        if(strlen($this->viesti) > 80) {
            $errors[] = 'Viesti saa olla maksimissaan 80 merkkiä pitkä.';
        }
        return $errors;
    }
}
