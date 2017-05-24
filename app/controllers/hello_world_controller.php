<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Hei ydinlauma!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }
    
     public static function testifunktio(){
      // Testaa koodiasi täällä
         echo 'Aika makeeta!';
    }
  }
