<?php
namespace infru\firewall;
use infru\support\factory\AuthTokenFactory;
abstract class AuthWoker {

    public $m_token;
    public function __construct()
    {
        $factory = new AuthTokenFactory();
        $this->m_token = $factory->createItem();
    }
    abstract public function excute();
}