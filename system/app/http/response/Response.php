<?php
//Main Role: InformationHolder
//Sub  Role: ServiceProvider

require_once(UTILITY_BASE.'Helper.php');

class Response {
    static $m_param = [];
    static $m_redirect;

    public function returnResponse () {

        $this->setErrorMessages();
     
    
        //contollerのアクションへ跨る
        //rootのindex.phpへ遷移
        //普通に遷移
        header("Location:"."/view/".self::$m_redirect);//コントローラ間の移動ができない
    }

    static function setErrorMessages()
    {   
        global $err_msg;
        self::$m_param['errors'] = $err_msg;
    }

    //以降、情報管理
    public function addParam($i_key, $i_value)
    {
        self::$m_param[$i_key] = $i_value;
    }

    public function setParam($i_array)
    {
        self::$m_param = $i_array;
    }

    public function setRedirect($i_value)
    {
        self::$m_redirect = $i_value;
    }

    public function getParam()
    {
        return self::$m_param;
    }
    public function getRedirect()
    {
        return self::$m_redirect;
    }
}