<?php
//コントローラーのアクション、か遷移先の割ああて

$routingMap = [
    'checkDuplicateEmail' => [
        'method' => 'POST',
        'controllerPath' => CONTROLLER_BASE.'FormController.php',
        'action' => 'checkDuplicationOfEmail',
    ],
];

define('ROUTING_MAP', $routingMap);


