<?php
//================================
// グローバル定数
//================================

define('HOST', 'localhost');

// DB周り
define('DB_HOST', 'test_db');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

//制御
define('BASE_APP', $_SERVER['DOCUMENT_ROOT'].'/system/app/');
define('CONTROLLER_BASE', BASE_APP.'controller/');
define('REQUEST_BASE', BASE_APP.'http/request/');
define('RESPONSE_BASE', BASE_APP.'http/response/');
define('MODEL_BASE', BASE_APP.'domain/model/');

define('BASE_INFRU', $_SERVER['DOCUMENT_ROOT'].'/system/infru/');
define('CORE_BASE', BASE_INFRU.'core/');
define('UTILITY_BASE', BASE_INFRU.'utility/');

//セッション・クッキー周り
define('SESSION_TIME', 'SESSION_TIME');
define('SESSION_LIMIT', 'SESSION_LIMIT');
define('SESSION_TMP_FILE',"/var/tmp/");
define('SESSION_LIFE',60*60*24*30);
define('COOKIE_LIFE',60*60*24*30);
define('UPLOAD_FILE','/user_images/');

//バリデーション
define('MIN_LEN', 8);
define('MAX_LEN', 256);

//エラーメッセージを定数に設定
define('MSG01','入力必須です');
define('MSG02', 'Emailの形式で入力してください');
define('MSG03','パスワード（再入力）が合っていません');
define('MSG04','半角英数字のみご利用いただけます');
define('MSG05','8文字以上で入力してください');
define('MSG06','256文字以内で入力してください');
define('MSG07','エラーが発生しました。しばらく経ってからやり直してください。');
define('MSG08', 'そのEmailは既に登録されています');
define('MSG09', 'メールアドレスまたはパスワードが違います');
define('MSG10', '電話番号の形式が違います');
define('MSG11', '郵便番号の形式が違います');
define('MSG12', '古いパスワードが違います');
define('MSG13', '古いパスワードと同じです');
define('MSG14', '文字で入力してください');
define('MSG15', '正しくありません');
define('MSG16', '有効期限が切れています');
define('MSG17', '半角数字のみご利用いただけます');

define('SUC01', 'パスワードを変更しました');
define('SUC02', 'プロフィールを変更しました');
define('SUC03', 'メールを送信しました');
define('SUC04', '登録しました');
define('SUC05', '購入しました！相手と連絡を取りましょう！');

//追加
define('MSG18', 'パスワードが一致しません');
define('MSG19', '選択必須です');
define('MSG20', 'すでにコメント済みです');
define('MSG21', 'すでにやりとり掲示板は作成されています');
define('MSG22', 'その商品のチャット掲示板はできてないです');


//views
define('BASE_VIEW', $_SERVER['DOCUMENT_ROOT'].'/view/');
define('HEAD', BASE_VIEW.'component/head.php');

//public
define('BASE_PUBLIC', $_SERVER['DOCUMENT_ROOT'].'/public/');
define('BASE_JS', BASE_VIEW.'public/js');

//================================
// グローバル変数
//================================
//エラーメッセージ格納用の配列
$err_msg = array();
?>