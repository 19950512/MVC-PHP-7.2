<?php
/* 
	{
		"AUTHOR": "Matheus Maydana",
		"CREATED": "07/02/2019",
		"NOME": "Maydana",
		"LAST_EDIT": "24/02/2019",
		"VERSION": "0.0.2"
	}
*/

class Maydana {

	public $controler 	= 'index';
	public $action		= 'index';
	public $visao		= 'index';
	public $url			= array();
	public $url_str		= '';
	public $uri 		= '';

	public $_agora		= '--:--';
	public $_hoje		= '--/--/----';
	public $_ip			= '---.---.-.---';

	function __construct(){


		// offline
		if(STATUS === 1){
			echo manutencao();
			exit;
		}

		$this->_agora		= date('H:i:s');
		$this->_hoje		= date('d/m/Y');
		$this->_ip			= $_SERVER['REMOTE_ADDR'];

		if(isset($_SERVER['REQUEST_URI']) and !empty($_SERVER['REQUEST_URI'])){

			$url 		= $this->parseURL($_SERVER['REQUEST_URI']);
			$this->url 	= $url;
			$this->uri 	= $_SERVER['REQUEST_URI'];
			$this->url_str = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}

		if(empty($this->url[1])){

			// SE NÃO HOUVER NADA NA URL, EXIBE O CONTROLADOR/VISÃO INDEX
			$this->controler 	= 'index';
			$this->action 		= 'index';
			$this->visao		= 'index';

			try {

				require_once (DIR.SUBDOMINIO.'/Controller/index/index.php');
			
			} catch (PDOException $e) {

				/**
				** Caso controlador não seja encontrado
				**/
			}

			/* Passa o $this para o controler para o controler ter acesso as coisas do núcleo */
			$controlador = new $this->controler($this);
			$controlador->index();

		}else{

			$controlador = str_replace('-', '', $this->url[1]);

			/* EXISTE ALGO NA URL, VERIFICAR SE DESTE ALGO, EXISTE UM CONTROLADOR */
			if(file_exists(DIR.SUBDOMINIO.'/Controller/'.$controlador.'/'.$controlador.'.php')){

				// MONTA O CONTROLADOR E ACTION (SE TIVER NA URL)
				$this->controler 	= $controlador;
				$this->visao 		= $controlador;

				try {

					if(file_exists(DIR.SUBDOMINIO.'/Controller/'.$controlador.'/'.$controlador.'.php')){

						require_once (DIR.SUBDOMINIO.'/Controller/'.$controlador.'/'.$controlador.'.php');
		
					}else{

						require_once (DIR.SUBDOMINIO.'/Controller/index/index'.'.php');
					}

				} catch (PDOException $e) {

					/**
					** Caso controlador não seja encontrado
					**/
				}

				$controlador = new $this->controler($this);

				// VERIFICA SE EXISTE A ACTION NO CONTROLADOR,
				if(isset($this->url[2]) and !empty($this->url[2])){

					$action = str_replace('-', '', $this->url[2]);

					if(method_exists($controlador, $action)){

						$this->action 	  = $action;
						// AQUI EXECUTA A ACTION EXISTENTE NO CONTROLADOR E NA URL
						$controlador->{$this->action}();

					}else{
						// ACTION NÃO ENCONTRADA / 404!
						$this->error404();
					}

				}else{
					// AQUI EXECUTA A ACTION INDEX (TODO CONTROLADOR TEM)
					$controlador->index();
				}

			}else{
				// 404 CONTROLADOR NÃO EXISTE
				$this->error404();
			}
		}
	}

	private function error404(){

		try{

			require_once (DIR.SUBDOMINIO.'/Controller/erro404/erro404'.'.php');

		}catch(PDOException $e){

			/**
			** Caso controlador não seja encontrado
			**/
		}

		$erro404 = new erro404($this);

		$erro404->index();
	}

	// "QUEBRA" O URL PARA DEFINIR OQUE É CONTROLADOR, ACTION..
	function parseURL($url){

		$array = explode('/', $url);
		$temp = array();

		foreach ($array as $key => $value) {

			$temp[$key] = preg_replace('/\?.*$|\!.*$|#.*$|\'.*$|\@.*$|\$.*$|&.*$|\*.*$|\+.*$|\..*$/', '', $value);
		}

		return $temp;
	}
}

// Função BASICA
function basic($string){

	$novaString = trim(strip_tags($string), ' ');

	return $novaString;
}

function _autoload($classe){

	$php = str_replace('_', '/', $classe);

	//try{

		if(is_file(DIR.'Model/'.$php.'.php')){

			require_once (DIR.'Model/'.$php.'.php');

		}else{

			echo $classe.': Classe não encontrada.';
			exit;
		}

	/*}catch(PDOException $e){

		*
		** @see Remover o ECHO antes de publicar
		*

		echo $classe.': Classe nao encontrada';
	}*/
}

spl_autoload_register('_autoload');

/**
** RESPONSAVEL PELO DEBUG, exemplo, new de($variavel); ou new de('allow');
**/

function manutencao(){

	$site_nome = SITE_NOME;

	$noscript = '<noscript><meta http-equiv="refresh"  content="1; URL=/noscript"  /></noscript>';
	if(isset($url[1]) and $url[1] == 'noscript'){

		$noscript = '';
	}

	$html = <<<html
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Manutenção - {$site_nome}</title>
		<meta charset="utf-8" />
		<meta name="format-detection" content="telephone=no" />
		<meta name="description" content="Estamos em manutenção, voltaremos o mais rápido possível">
		<meta name="robots" content="no-follow, no-index" />
		<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes, initial-scale=1" />
		{$noscript}
		<meta name="msapplication-tap-highlight" content="no"/>
		<meta name="apple-mobile-web-app-title" content="{$site_nome}"/>
		<meta name="application-name" content="{$site_nome}"/>
		<meta name="msapplication-TileColor" content="#e8e6e8"/>
		<meta name="theme-color" content="#1c5f8e"/>
		<meta name="author" content="Matheus Maydana" />
		<link rel="manifest" type="application/manifest.json" href="/manifest.json"> 
		<script async src="/js/site.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/site.min.css">
		<link rel="stylesheet" type="text/css" href="/css/icons/all.min.css">
	</head>
	<body>
		<main id="content" style="padding-top: 50px;">
			<section class="content content_h content_v content_m">
				<h1 class="ho-title">Site em manutenção</h1>

				<p class="ho-txt">O site está em manutenção, assim que estiver pronto estará funcionando normalmente.</p>
			</section>
		</main>
	</body>
</html>
html;

	$html = comprimeHTML($html);

	return $html;
}
class de{

	function __construct($a){

		/* DEBUGAR EM DESENVOLVIMENTO */
		if(DEV === true){

			if(is_array($a)){

				echo '<pre>';
				print_r($a);
				exit;

			}else{

				echo '<pre>';
				var_dump($a);
				exit;
			}
		
		/* HTML EM PRODUÇÃO */
		}else{

			echo manutencao();
			exit;
		}
	}
}

function comprimeHTML($html){

	$html = preg_replace(array("/\/\*(.*?)\*\//", "/<!--(.*?)-->/", "/\t+/"), ' ', $html);

	$mustache = array(
		"\t"		=> '',
		""			=> ' ',
		PHP_EOL		=> '',
		'> <'		=> '><',
		'  '		=> '',
		'   '		=> '',
		'    '		=> '',
		'     '		=> '',
		'> <'		=> '><',
		'
'						=> ''
	);
	
	return str_replace(array_keys($mustache), array_values($mustache), $html);
}