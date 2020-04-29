<?php
//main role : Factory, Service Provider 
//pattern : Factory
namespace infru\support\factory;

class RootFactory {

    protected $m_basePath;

    public function __construct($i_path)
    {
        $this->m_basePath = $i_path;
    }

    protected function getFomartedClassPath($m_pattern)
    {
        $o_classPath = null;

        $o_classPath = $this->m_basePath.$m_pattern;
        return $o_classPath;
    }

//////// 以下 final ////////////////////////////////////////////////
    final public function createItem($i_pattern = null, $i_params1 = null, ...$i_params2)
    {
        $o_item = null;
        $i_classPath = $this->getFomartedClassPath($i_pattern);
        $o_item = $this->getInstanceByPath($i_classPath, $i_params1, ...$i_params2);
        return $o_item;
    }

    final protected function getInstanceByPath($i_classPath, $i_params1 = null, ...$i_params2) 
    {
        $existenceOK = class_exists($i_classPath);
        if(!$existenceOK) {
            return null;
        }
        if($i_params1 === null) {
            return new $i_classPath();
        }
        return new $i_classPath($i_params1, $i_params2);
    }


}