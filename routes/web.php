<?php
//コントローラーのアクション、か遷移先の割ああて

$routingMap = [
    'index' => 'welcom.php',
    '' => 'welcom.php',
    'welcom' => 'welcom.php',

    'confirmUser' => [
        'method' => 'POST',
        'controllerPath' => CONTROLLER_BASE.'FormController.php',
        'action' => 'reqisgerUser',
    ],
];

define('ROUTING_MAP', $routingMap);


