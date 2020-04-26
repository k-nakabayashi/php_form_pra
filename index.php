<?php
//Main Role: Client
//Sub  Role: Cordinator

//初期設定

require_once($_SERVER['DOCUMENT_ROOT'].'/config/env.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/message.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/config/middleware.php');
require_once(UTILITY_BASE.'Helper.php');

//コンテナクラス起動
$app = createContainer();

//ルーティング
$app->bootAction();