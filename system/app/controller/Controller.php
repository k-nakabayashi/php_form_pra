<?php
abstract class Controller {
    protected $m_action;
    public function __construct($i_acion)
    {
        $this->m_action = $i_acion;
    }
    public function bootAction () 
    {
        $action = $this->m_action;
        $respnse = $this->$action();
        return $respnse;
    }
}