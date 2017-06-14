<?php

class SalasanaValidator extends BaseModel {

    public $salasana, $salasana1, $salasana2;
    
     public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_salasana');
    }    
    
//     public function validate_salasana() {
//        $errors = array();
//        if ($this->salasana == '' || $this->salasana == null) {
//            $errors[] = 'Salasana ei saa olla tyhjä!';
//        }
//        if (strlen($this->salasana) < 6) {
//            $errors[] = 'Salasana on oltava vähintään 6 merkkiä pitkä.';
//        }
//        if (preg_match('~[0-9]~', $this->salasana) == false) {
//            $errors[] = 'Salasanassa on oltava vähintään yksi numero.';
//        }
//        return $errors;
//    }
}