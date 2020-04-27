<?php
namespace infru\auth;
use infru\auth\RootAuth;

class WebAuth extends RootAuth {

    public function __construct($i_csrf = null, $i_token = null)
    {
        parent::__construct($i_csrf, $i_token);
    }

    private function checkOther() {
        return true;
    }

}