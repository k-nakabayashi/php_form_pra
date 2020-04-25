<?php
require_once(UTILITY_BASE.'Helper.php');
require_once(CONTROLLER_BASE.'Controller.php');
require_once(REQUEST_BASE.'FormRequest.php');
require_once(MODEL_BASE.'User.php');

//会員登録の処理
class FormController extends Controller {

    private $m_formRequest;
    private $m_mailService;
    private $m_user;
    private $m_response;

    public function __construct($i_acion)
    {
        parent::__construct($i_acion);
        $this->m_formRequest = new FormRequest();
        $this->m_user = new User();
        $this->m_response = getResponse();
    }

    public function reqisgerUser()
    {


        //バリデーション
        $resultOK = $this->validate();
        if (!$resultOK) {
            return;
        }
   
        //ユーザー登録
        $resultOK = $this->createUser();
        if (!$resultOK) {
            return;
        }

        return;
        //認証用メール送信
        $resultOK = $this->m_mailService->sendCertifyingMail();
        if (!$resultOK) {
            return;
        }
        return;
    }

    private function createUser()
    {
        $registerData = $this->m_formRequest->getParam();
        $resultOK = $this->m_user->create($registerData);
        if (!$resultOK) {
            return se;
        }
        return true;
    }
    
    private function validate()
    {
        $resultOK = false;
        $resultOK = $this->m_formRequest->checkCsrfToken();
        if (!$resultOK) {
            return false;
        }
        $resultOK = $this->m_formRequest->startValidate();
        if (!$resultOK) {
            return false;
        }
        
        $resultOK = $this->validDuplicateEmail();
        if (!$resultOK) {
            return false;
        }
        return true;
    }

    private function validDuplicateEmail () {

        $input_mail = $this->m_formRequest->getParam()['email'];

        $noDuplication = $this->m_user->checkDuplicateEmail($input_mail);
        if ($noDuplication === true) {
            return false;
        }
        return true;
    }

    public function checkDuplicationOfEmail () {

        $input_mail = $this->m_formRequest->getParam()['email'];
        $duplicated = $this->m_user->checkDuplicateEmail($input_mail);
          //返り値のjsonを決める
        $data = null;
        if ($duplicated === false) {
            $data = 'success';
        } else {
            $data = 'false';
        }

        setResponseParam(
            [
                'data' => $data,
            ]
        );

        return;
    }


}