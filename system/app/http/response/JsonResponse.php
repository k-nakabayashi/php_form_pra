<?php
//Main Role: InformationHolder(parent)
//Sub  Role: ServiceProvider
namespace app\http\response;
use app\http\response\RootResponse;

require_once(RESPONSE_BASE.'Response.php');

class JsonResponse extends RootResponse {

    
    public function returnResponse()
    {
        parent::setErrorMessages();
        echo json_encode(parent::$m_dataList);
        exit;
    }
}