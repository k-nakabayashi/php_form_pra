<?php
namespace app\http\request;
require_once(UTILITY_BASE.'Helper.php');
require_once(UTILITY_BASE.'Validator.php');
use app\http\request\RootRequest;


class FormRequest extends RootRequest {

    public function checkCsrfToken() {
        $o_resultOK = false;
        $token = parent::$m_params['csrf_token'];
        $o_resultOK = false;
        return $o_resultOK;
    }

    public function startValidate()
    {
        //名前
        $resultOK = $this->validateName(parent::$m_params['name']);
        if(!$resultOK) {
            return false;
        }
        
        //メール
        $resultOK = $this->validateEmail(parent::$m_params['email']);
        if(!$resultOK) {
            return false;
        }
        
        //パスワード
        $resultOK = $this->validatePassword(parent::$m_params['password']);
        if(!$resultOK) {
            return false;
        }

        return true;
        
    }

    private function validateName($i_value) {
        $error_key = 'name';

        $resultOK = false;
        $resultOK = validRequired($i_value, $error_key);
        if(!$resultOK) {
            return false;
        }
        $resultOK = validMinLen($i_value, $error_key);
        if(!$resultOK) {
            return false;
        }
        $resultOK = validMaxLen($i_value, $error_key, 20);
        if(!$resultOK) {
            return false;
        }
        return true;
    }

    private function validateEmail($i_value) {
        $error_key = 'email';

        $resultOK = false;
        $resultOK = validRequired($i_value, $error_key);
        if(!$resultOK) {
            return false;
        }
        $resultOK = validMaxLen($i_value, $error_key);
        if(!$resultOK) {
            return false;
        }
        $resultOK = validEmail($i_value, $error_key);
        if(!$resultOK) {
            return false;
        }
       
        return true;
    }
    
    private function validatePassword($i_value) {
        $error_key = 'password';
        $resultOK = false;

        $resultOK = validRequired($i_value, $error_key);
        if(!$resultOK) {
            return false;
        }
        $resultOK = validMinLen($i_value, $error_key);
        if(!$resultOK) {
            return false;
        }
        $resultOK = validMaxLen($i_value, $error_key);
        if(!$resultOK) {
            return false;
        }
        $resultOK = validHalf($i_value, $error_key);
        if(!$resultOK) {
            return false;
        }
        return true;
    }

}