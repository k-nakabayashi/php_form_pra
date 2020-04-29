<?php
//main role: Cordinatoer (Context of Strategy), Factory
//pattern : Factory
namespace infru\support\factory;
use infru\support\factory\RootFactory;

class AuthFactory extends RootFactory {

    public function __construct()
    {
        parent::__construct('infru\firewall\\');
    }

    protected function getFomartedClassPath($m_pattern)
    {
        $o_classPath = null;

        $path = null;
        if($_REQUEST['route'] === 'api') {
            $path = $m_pattern."\ApiAuth";
        }  else {
            $path = $m_pattern."\WebAuth";
        }

        $o_classPath = $this->m_basePath.$path;
        return $o_classPath;
    }
}