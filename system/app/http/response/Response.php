<?php
//Main Role: InformationHolder
//Sub  Role: ServiceProvider

require_once(UTILITY_BASE.'Helper.php');

class Response {
    static $m_dataList = [
        'params' => [],
        'errors' => []
    ];
    static $m_redirect;

    public function returnResponse() {

        $this->setDataList();
        
        //contollerのアクションへ跨る
        
        //rootのindex.phpへ遷移
        $path = "Location:";
        if(self::$m_redirect === '/index.php') {
            $path .= self::$m_redirect;
        }
        //普通に遷移
        $path .= "/view/".self::$m_redirect;

        header( $path);
        exit;
    }

    static function setDataList()
    {   
       self::setErrorMessages();
       if(isset($_SESSION['dataList'])) {
        $_SESSION['dataList']['datas'] = self::$m_dataList['params'];
        $_SESSION['dataList']['errors'] = self::$m_dataList['errors'];
       }
    }
    static function setErrorMessages()
    {   
        global $err_msg;
        self::$m_dataList['errors'] = $err_msg;
    }

    //以降、情報管理
    public function addParams($i_key, $i_value)
    {
        self::$m_dataList['params'][$i_key] = $i_value;
    }

    public function setParams($i_array)
    {
        self::$m_dataList['params'] = $i_array;
    }

    public function setRedirect($i_value)
    {
        self::$m_redirect = $i_value;
    }

    public function getParams()
    {
        return self::$m_dataList;
    }
    public function getRedirect()
    {
        return self::$m_redirect;
    }
}