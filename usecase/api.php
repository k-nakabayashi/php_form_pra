<?php
use  infru\core\UseCase;

//ブラウザから直アクセスか？
//外部アプリからの経由か？

//ユースケースによってはアクセストークンが必要になる。
//アクセストークンは外部アプリのものか？認証済みユーザーのモノか？
//アクセストーンによってできる内容が変わる

//クエリ名をあらかじめ決めておく必要があるね
UseCase::post('checkDuplicateEmail', 'FormController', 'checkDuplicationOfEmail');
