<?php
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "14/08/2018",
		"CONTROLADOR": "Index",
		"LAST EDIT": "18/08/2018",
		"VERSION":"0.0.2"
	}
*/
class Index {

	private $_nucleo;

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
		$this->metas['title'] = 'Início';

		if($this->_push === false){

			echo $this->_drive->_visao($this->_drive->_layout('index', 'index', $this->metas), $mustache);

		}else{

			echo $this->_drive->push('index', 'index', $mustache, $this->metas);
		}
	}
}