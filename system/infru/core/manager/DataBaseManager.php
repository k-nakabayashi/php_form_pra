<?php
//Main Role: ServiceProvider
//Sub Roke : Cordinator
namespace infru\core\manager;

class DataBaseManager {
    static $m_connect = null;

    public function connectDB() {
        if(self::$m_connect !== null) {
            //m_connectがPDOであるか？確認必要か？
            return;
        }
        //接続情報
        $db = 'mysql:dbname='.DB_HOST.';host='.HOST.';charset=utf8';
        //DBへの接続準備
        $options = array(
        // SQL実行失敗時にはエラーコードのみ設定
        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
        // デフォルトフェッチモードを連想配列形式に設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
        // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        );

        // PDOオブジェクト生成（DBへ接続）
        self::$m_connect = new PDO($db, DB_USER, DB_PASSWORD, $options);
    }

    //query実行
    public function excuteSQL($i_db, $i_sql, $i_data) {
        //クエリー作成
        $o_stmt = null;
        $o_stmt = $i_db->prepare($i_sql);
        //プレースホルダに値をセットし、SQL文を実行
        $reuslt = $o_stmt->execute($i_data);

        if(!$reuslt){
            // debug('クエリに失敗しました。');
            global $err_msg;
            // $err_msg['common'] = MSG07;
            $o_stmt = null;
        }
        // debug('クエリ成功。');
        return $o_stmt;
    }

}