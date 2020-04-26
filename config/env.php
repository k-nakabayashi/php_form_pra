<?php
//================================
// グローバル定数
//================================

define('HOST', 'localhost');

// DB周り
define('DB_HOST', 'test_db');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

//セッション・クッキー周り
define('SESSION_TIME', 'SESSION_TIME');
define('SESSION_LIMIT', 'SESSION_LIMIT');
define('SESSION_TMP_FILE',"/var/tmp/");
define('SESSION_LIFE',60*60*24*30);
define('COOKIE_LIFE',60*60*24*30);
define('UPLOAD_FILE','/user_images/');


//================================
// グローバル変数
//================================
//エラーメッセージ格納用の配列
$err_msg = array();