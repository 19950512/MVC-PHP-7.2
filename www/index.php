<?php

/**
** CONFIGURAÇÕES DO MVC
**/
define('DEV', true);

define('DIR', '../');

define('LAYOUT', 'layout');	
define('SAVE_SESSIONS', '/Sessions');

session_save_path(DIR.SAVE_SESSIONS);
session_set_cookie_params(9999999, '/', $_SERVER['SERVER_NAME']);

define('EXTENSAO_VISAO', '.html');
session_start();

require_once '../Configuracao.php';

require_once '../Maydana.php';
new Maydana();