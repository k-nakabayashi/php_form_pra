<?php
require_once(UTILITY_BASE.'Helper.php');
require_once(UTILITY_BASE.'Validator.php');
// require_once(REQUEST_BASE.'Request.php');

// class FormRequest extends Request {
class FormRequest {
    private $m_params;
    
    public function __construct()
    {
        $this->m_params = getRequestParams();
    }

    public function checkCsrfToken() {
        $token = $this->m_params['csrf_token'];
        $resultOK = false;
        return true;
    }

    public function startValidate()
    {
        //名前
        $resultOK = $this->validateName($this->m_params['name']);
        if(!$resultOK) {
            return false;
        }
        
        //メール
        $resultOK = $this->validateEmail($this->m_params['email']);
        if(!$resultOK) {
            return false;
        }
        
        //パスワード
        $resultOK = $this->validatePassword($this->m_params['password']);
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


    public function getParams()
    {
        return $this->m_params;
    }
}