<?php
//Main Role: InformationHolder(parent)
//Sub  Role: ServiceProvider
namespace app\http\response;
use app\http\response\RootResponse;

class JsonResponse extends RootResponse {

    // static $m_dataList = [
    //     'params' => [],
    //     'errors' => []
    // ];
    public function returnResponse()
    {
        parent::setErrorMessages();
        echo json_encode(parent::$m_dataList);
        exit;
    }
}
