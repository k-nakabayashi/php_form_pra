<?php

//Before///////////////////////////////
$middleBefore = [
    'global' => [
        'initSession' => initSession,
        'initSession2' => 'commandPath',
        'initSession3' => 'commandPath',
    ],
    'group' => [
        'name' => 'commandPath'
    ],
    'local' => [
        'name' => 'commandPath'
    ]
];

//After///////////////////////////////
$middleAfter = [
    'global' => [
        'name' => 'commandPath'
    ],
    'group' => [
        'name' => 'commandPath'
    ],
    'local' => [
        'name' => 'commandPath'
    ]
];

define('MIDDLE_BEFORE', $middleBefore);
define('MIDDLE_AFTER', $middleAfter);