<?php

//APP
define('BASE_APP', $_SERVER['DOCUMENT_ROOT'].'/system/app/');
define('CONTROLLER_BASE', 'app\Controller');

define('REQUEST_BASE', BASE_APP.'http/request/');
define('RESPONSE_BASE', BASE_APP.'http/response/');
define('MODEL_BASE', BASE_APP.'domain/model/');

//INFRU
define('BASE_INFRU', $_SERVER['DOCUMENT_ROOT'].'/system/infru/');
define('CORE_BASE', BASE_INFRU.'core/');
define('UTILITY_BASE', BASE_INFRU.'utility/');
define('INFRU_MIDDLE_BASE', 'infru\middleware');
define('INFRU_SERVICE', BASE_INFRU.'service/');

//views
define('BASE_VIEW', $_SERVER['DOCUMENT_ROOT'].'/view/');
define('HEAD', BASE_VIEW.'component/head.php');
define('SERVER_ERROR', '500.php');
define('INDEX_VIEW', '/index.php');

//public
define('BASE_PUBLIC', $_SERVER['DOCUMENT_ROOT'].'/public/');
define('BASE_JS', BASE_VIEW.'public/js');

//MiddleWare
define('initSession', INFRU_MIDDLE_BASE.'\SessionCommand');
