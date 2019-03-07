<?php
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "22/11/2018",
	"MODEL": "Layout",
	"LAST EDIT": "22/11/2018",
	"VERSION":"0.0.1"
}
*/


/**
**
** @see o Layout precisa ser formato .HTML ou confirgurar no arquivo Setting.php 
**
**/

class Layout extends View{

	public function setLayout($st_view){

		try{

			if(file_exists(DIR.'Layout/'.$st_view.EXTENSAO_VISAO)){

				$this->st_view = $st_view;

			}else{

				new de('layout não encontrado');
			}

		}catch(PDOException $e){

			/**
			** ERRO, LAYOUT NÃO ENCONTRADO
			**/
			new de('layout não encontrado');
		}
	}

	public function Layout($metas){

		$layout = LAYOUT;

		try{

			$layoutFile = file_get_contents(DIR.'Layout/'.$layout.EXTENSAO_VISAO);
			if(!$layoutFile){
				new de('nada de layout');
			}

			/* COLOCAR CACHE NOS ARQUIVOS STATICOS QUANDO NÃO ESTÁ EM PRODUÇÃO */
			$cache = '';
			$random = mt_rand(10000, 99999);

			if(DEV !== true){
				$cache = '?cache='.$random;
			}

			$mustache = array(
				'{{header}}' 		=> $this->_headerHTML($metas),
				'{{cache}}' 		=> $cache,
				'{{ano}}'			=> date('Y'),
				'{{dominio_site}}'	=> DOMINIO_SITE
			);


			$layout = str_replace(array_keys($mustache), array_values($mustache), $layoutFile);

			return $layout;

		}catch(PDOException $e){

			new de('nada de layout');
			/**
			** ERRO, ARQUIVO LAYOUT NÃO ENCONTRADO
			**/
		} 
	}

	private function _headerHTML($metas){

		$url = $this->url;

		$noscript = '<noscript><meta http-equiv="refresh"  content="1; URL=/noscript"  /></noscript>';
		if(isset($url[1]) and $url[1] == 'noscript'){

			$noscript = '';
		}

		$meta_title = $metas['title'] ?? 'MVC PHP 7.2';
		$meta_description = $metas['description'] ?? 'MVC PHP 7.2!';
		$meta_robos = $metas['robots'] ?? 'index, follow';

		$site_nome = SITE_NOME;
		$header = <<<php
<title>{$meta_title}</title>
<meta charset="utf-8" />
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="{$meta_description}">
<meta name="robots" content="{$meta_robos}" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes, initial-scale=1" />
{$noscript}
<meta name="msapplication-tap-highlight" content="no"/>
<meta name="apple-mobile-web-app-title" content="{$site_nome}"/>
<meta name="application-name" content="{$site_nome}"/>
<meta name="msapplication-TileColor" content="#e8e6e8"/>
<meta name="theme-color" content="#1c5f8e"/>
<meta name="author" content="Matheus Maydana" />
<link rel="manifest" type="application/manifest.json" href="/manifest.json"> 
php;

		return $header;
	}
}