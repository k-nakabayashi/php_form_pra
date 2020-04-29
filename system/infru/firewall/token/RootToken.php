<?php
namespace infru\firewall\token;

abstract class RootToken {
    abstract public function checkToken();
    abstract public function createToken();
}