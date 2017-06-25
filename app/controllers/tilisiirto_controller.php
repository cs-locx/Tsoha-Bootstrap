<?php

class TilisiirtoController extends BaseController {

	public static function tallenna($lahtotili) {
		$params = $_POST;

		$attributes = array(
			'summa' => $params['summa'],
			'lahtotili' => $lahtotili,
			'kohdetili' => $params['kohdetili'],
			'viesti' => $params['viesti'],
			);

		$tilisiirto = new Siirto($attributes);
		$errors = $tilisiirto->errors();

		if (count($errors) > 0) {
			View::make('tilitapahtuma/siirto.html', array('errors' => $errors, 'attributes' => $attributes));
		} else {
			$tilisiirto->tallenna();
			$tili = Tili::find($lahtotili);
			Redirect::to('/user/' . $tili->kayttaja, array('message' => 'Tilisiirto onnistui!'));
		}
	}

}