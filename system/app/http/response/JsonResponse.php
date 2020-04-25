<?php
require_once(RESPONSE_BASE.'Response.php');

class JsonResponse extends Response{

    
    public function returnResponse ()
    {
        parent::setErrorMessages();
        echo json_encode(parent::$m_param);
    }
}