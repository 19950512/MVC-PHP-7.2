<?php
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "08/02/2019",
		"CONTROLADOR": "Model COMPOSER",
		"LAST EDIT": "08/02/2019",
		"VERSION":"0.0.1"
	}
*/

require_once DIR.'vendor/autoload.php';

class Composer {

	public $dependenc;

	function __construct($dependencia){
		
		$dependencia = str_replace('_', '\\', $dependencia);

		$url = '\emberlabs\\'.$dependencia;

		$depe = new $url;

		$this->dependenc = $depe;
	}

	function _i(){
		return $this->dependenc;
	}
}