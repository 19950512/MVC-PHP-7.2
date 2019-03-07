<?php
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "22/11/2018",
	"MODEL": "View",
	"LAST EDIT": "24/02/2019",
	"VERSION":"0.0.2"
}
*/

/**
**
** @see a View precisa ser formato .HTML ou confirgurar no arquivo Setting.php 
**
**/

class View{

	public function setView($controlador, $st_view){

		//new de(DIR.SUBDOMINIO.'View/'.$controlador.'/'.$st_view.EXTENSAO_VISAO);
		try{

			if(file_exists(DIR.SUBDOMINIO.'/View/'.$controlador.'/'.$st_view.EXTENSAO_VISAO)){

				$this->st_view = $st_view;
				$this->st_controlador = $controlador;

			}else{
				
				new de('visao não encontrado');
			}

		}catch(PDOException $e){

			/**
			** ERRO, VISÃO NÃO ENCONTRADA
			**/
		}
	}

	function visao(){

		try{
			
			if(isset($this->st_view)) {

				$visao = $this->st_view;
				$controlador = $this->st_controlador;

				if(file_exists(DIR.SUBDOMINIO.'/View/'.$controlador.'/'.$visao.EXTENSAO_VISAO)){

					$visao = file_get_contents(DIR.SUBDOMINIO.'/View/'.$controlador.'/'.$visao.EXTENSAO_VISAO);

					return $visao;

				}else{
					/**
					** Erro na visão
					**/
					new de('visao não encontrado');
					//echo 'erro no diretorio da visão';
				}
			}

		}catch(PDOException $e){

			new de('visao não encontrado');
			/**
			** ERRO, ARQUIVO VISÃO NÃO ENCONTRADO
			**/
		}
	}
}