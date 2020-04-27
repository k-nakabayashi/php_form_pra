会員
メールアドレス
バリデーション
セキュリティ
入力内容
認証用メール

-----------

会員
* 名前
* メールアドレス
* パスワード
* メールアドレス認証判定

セッション
* 名前
* メールアドレス
* パスワード
* 認証クエリ

メール
* 宛先
* 送信元
* テキスト
    * リンク
    * 認証クエリ

リクエスト:情報保持
* メソッド

* パラメーター(連想配列)
* csrfToken


レスポンス：サービス提供、情報保持
* パラメーター
* 遷移先

ルーター：制御・調整
* メソッド
* パラメーター
* 遷移先

セキュリティ
* csrf
* scriptInsertion


各種ミドルウェアコマンド
* 各種必要情報
* 遷移先
* handle()



=============================================
下記、認証系
starategyパターン
<認証Context>
AuthenticateCommand
* abstract handle()
* initAuthentication()
  * token = setToken()
  * authentication(token)

* checkAuthentication ()


<認証Strategy>
abstruct RootAuth
* csrf
* abstruct checkOther()
* checkCsrf()
* checkToken() {
    return true;
}
* handle()
    * checkCsrf()
    * checkToken()

WebAuth
* checkOther()

ApiAuth
* checkOther()
* checkToken()
    * checkOther()

-----------------------

<トークンdata>


abstrutct RootToken

CsrfToken
* token
* lifeTime
* compareToken()
* createToken
* setToken

RequestToken →authenticationで使う
* token(QueryParamater)
* secret(forGettingAccessToken)
* createToken()

AccessToken →authorizationで使う
* key→わからん
* secret→わからん


