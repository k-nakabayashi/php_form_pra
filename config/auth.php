<?php

$queryNameList = [
    'reqestKey', 'reqestKey',//→認証で使う
    'accessKey', 'accessToken',//認可で使う
];

$authorizationList = [
    'actor' => ['blackList'],//基底クラス
    'user' => [
        'level0' => ['whiteList'],
        'level1' => ['whiteList'],
        'level2' => ['whiteList'],
    ],
    'admin' => [
        'level0' => ['whiteList'],
        'level1' => ['whiteList'],
        'level2' => ['whiteList'],
    ],
];
//FireWall機能

//actor
//  ブリッジパターンやな。→却下、追加するたびにクラスを新しく作るのがめんどう
// actore
// ---user0
//     ---user1
//         ---user2

// ---admin
//     ---admin1
//         ---admin2