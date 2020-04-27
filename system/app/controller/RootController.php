<?php
namespace app\Controller;

abstract class RootController {
    protected $m_action;
    public function __construct($i_acion)
    {
        $this->m_action = $i_acion;
    }
    public function bootAction() 
    {
        $action = $this->m_action;
        $this->$action();
    }
}