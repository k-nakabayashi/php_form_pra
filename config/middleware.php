<?php

/////////////////////////////////
$middleLocal = [
    // 'test1' => initSession,
    // 'test2' => 'commandPath',
    // 'test3' => 'commandPath',

    'group1' => [
        // 'group1__test1' => initSession,
        // 'group1__test2' => initSession,
        // 'group1__test3' => 'commandPath',
    ],
    'group2' => [
        // 'group2__test1' => 'commandPath',
        // 'group2__test2' => 'commandPath',
        // 'group2__test3' => 'commandPath',
    ],
    'group3' => [
        // 'commandPath',
        // 'CONST_NAME',
        // 'group3__test2' => 'commandPath',
        // 'group3__test3' => 'commandPath',
    ],
];
define('MIDDLE_LOCAL', $middleLocal);

//////////////////////////////'///
//Global
$middleGlobal = [
    'before' => [
        'initSession' => initSession,
        // 'group1' => [
        //     'group1__test1' => initSession,
        //     'group1__test2' => initSession,
        //     'group1__test3' => 'commandPath',
        // ],
    ],

    // 'after' => [
    //     'initSession' => initSession,
    // ],

];

define('MIDDLE_GLOBAL', $middleGlobal);