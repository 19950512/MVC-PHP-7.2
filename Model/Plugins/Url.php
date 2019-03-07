<?php
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "22/11/2018",
	"MODEL": "Utilit",
	"LAST EDIT": "22/11/2018",
	"VERSION":"0.0.1"
}
*/

class Plugins_Url {

	public function trataURL($string){

		$especiais = array(
			'á', 'à', 'â', 'ã', 'Á', 'À', 'Â', 'Ã',
			'é', 'è','ê', 'É', 'È', 'Ê', 
			'í', 'ì', 'î', 'Í', 'Ì', 'Î',
			'ó', 'ò', 'ô', 'õ', 'Ó', 'Ò', 'Ô', 'Õ',
			'ú', 'ù', 'û', 'Ú', 'Ù', 'Û',
			'ç', 'Ç'
		);
		
		$normais = array(
			'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
			'e', 'e', 'e', 'e', 'e', 'e',
			'i', 'i', 'i', 'i', 'i', 'i',
			'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
			'u', 'u', 'u', 'u', 'u', 'u',
			'c', 'c'
		);

		$string = str_replace($especiais, $normais, $string);

		$altera = array(
			' ', ',', '.', '|', '/', '\'', '-'
		);

		return strtolower(str_replace($altera, '-', $string));
	}
}