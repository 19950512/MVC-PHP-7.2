<?php

/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "07/02/2019",
		"CONTROLADOR": "Erro404",
		"LAST EDIT": "07/02/2019",
		"VERSION":"0.0.1"
	}
*/

class Erro404 {

	public $_nucleo;

	private $_drive;

	private $_push = false;

	private $metas = array();

	function __construct($nucleo){

		$this->_nucleo = $nucleo;

		$this->_drive = new Drive;

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}
	}

	function index(){
		
		$mustache = array();
		$this->metas['title'] = 'Página não encontrada';
		$this->metas['robots'] = 'no-index, no-follow';

		if($this->_push === false){

			echo $this->_drive->_visao($this->_drive->_layout('erro404', 'erro404', $this->metas), $mustache);

		}else{

			echo $this->_drive->push('erro404', 'erro404', $mustache, $this->metas);
		}
	}
}