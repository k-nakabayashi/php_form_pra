<?php
namespace infru\firewall\authToken;

abstract class AuthToken {

    abstract public function checkToken();
    abstract public function createToken();
}