<?php
//コントローラーのアクション、か遷移先の割ああて

$routingMap = [
    'index' => '/view/welcom.php',
    '/' => '/view/welcom.php',
    'confirmUser' => [
        'method' => 'POST',
        'controllerPath' => CONTROLLER_BASE.'FormController.php',
        'action' => 'reqisgerUser',
    ],
];

define('ROUTING_MAP', $routingMap);


