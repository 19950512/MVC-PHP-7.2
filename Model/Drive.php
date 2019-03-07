<?php
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "08/02/2019",
		"CONTROLADOR": "Model DRIVE",
		"LAST EDIT": "08/02/2019",
		"VERSION":"0.0.1"
	}
*/

class Drive extends Layout {

	public $url;

	function __construct(){

		$url = $_SERVER['REQUEST_URI'];

		$this->url = explode('/', $url);

		$this->_url = new Plugins_Url;
	}

	function _getView($controlador, $visao){
		$this->setView($controlador, $visao);
		return $this->visao();
	}

	function _layout($controlador, $visao, $metas, $template = LAYOUT){

		$this->setLayout($template);
		$this->setView($controlador, $visao);

		$mustache = array(
			'{{visao}}' => $this->visao()
		);		

		return comprimeHTML(str_replace(array_keys($mustache), array_values($mustache), $this->Layout($metas)));
	}

	function _visao($visao, $bigodim = null){

		if(is_array($bigodim) and $bigodim !== null and $bigodim !== ''){

			@$var = comprimeHTML(str_replace(array_keys($bigodim), array_values($bigodim), $visao));

			return $var;
		
		}else{

			return comprimeHTML(str_replace('{{visao}}', $bigodim, $visao));
		}
	}

	function push($controlador, $visao, $bigodim = null, $metas){
		$this->setView($controlador, $visao);

		if(is_array($bigodim) and $bigodim !== null and $bigodim !== ''){

			@$html = comprimeHTML(str_replace(array_keys($bigodim), array_values($bigodim), $this->visao())); 
			
			$result['html'] = $html;
			$result['metas'] = $metas;

			return json_encode($result);

		}else{

			$html = comprimeHTML(str_replace('{{visao}}', $bigodim, $this->visao()));

			$result['html'] = $html;
			$result['metas'] = $metas;

			return json_encode($result);
		}
	}
}