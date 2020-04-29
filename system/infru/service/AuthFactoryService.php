<?php
//main role: Cordinatoer (Context of Strategy), Factory
//pattern : Factory
namespace infru\service;

require_once(UTILITY_BASE.'Helper.php');

class  AuthFactoryService {

    private $m_path = 'infru\firewall\\';

    public function createAuth($i_pattern)
    {  

        $auth = null;
        $clashPath = null;
        if($_REQUEST['route'] === 'api') {
            $clashPath = $i_pattern."\ApiAuth";
        }  else {
            $clashPath = $i_pattern."\WebAuth";
        }
        $path = $this->m_path.$clashPath;
        $auth = getInstanceByPath($path);
        return $auth;
    }
}