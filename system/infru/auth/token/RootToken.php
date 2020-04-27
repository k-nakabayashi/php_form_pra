<?php
namespace infru\auth\token;

abstract class RootToken {
    abstract public function checkToken();
    abstract public function createToken();
}