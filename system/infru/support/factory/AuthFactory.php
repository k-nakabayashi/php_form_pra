<?php
//main role: Cordinatoer,Factory
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
        if(getRequestRoot() === 'api') {
            $path = $m_pattern."\ApiAuthWoker";
        }  else {
            $path = $m_pattern."\WebAuthWoker";
        }

        $o_classPath = $this->m_basePath.$path;
        return $o_classPath;
    }
}