<?php
namespace app\Controller;
require_once(UTILITY_BASE.'Helper.php');

use app\Controller\RootController;
use app\http\request\FormRequest;
use app\domain\model\User;

//会員登録の処理
class FormController extends RootController {

    private $m_formRequest;
    private $m_mailService;
    private $m_user;

    public function __construct($i_acion)
    {
        parent::__construct($i_acion);
        $this->m_formRequest = new FormRequest();
        $this->m_user = new User();
    }

    public function reqisgerUser()
    {


        //バリデーション
        $resultOK = $this->validate();
        if(!$resultOK) {
            return;
        }
   
        //ユーザー登録
        $resultOK = $this->createUser();
        if(!$resultOK) {
            return;
        }

        // return;
        // //認証用メール送信
        // $resultOK = $this->m_mailService->sendCertifyingMail();
        // if(!$resultOK) {
        //     return;
        // }
        
        setResponseRedirect('create/confirm.php');
    }

    private function createUser()
    {
        $o_resultOK = false;
        
        $registerData = $this->m_formRequest->getParams();
        $o_resultOK = $this->m_user->create($registerData);
        return $o_resultOK;
    }
    
    private function validate()
    {
        $resultOK = false;
        $resultOK = $this->m_formRequest->checkCsrfToken();
        if(!$resultOK) {
            return false;
        }
        $resultOK = $this->m_formRequest->startValidate();
        if(!$resultOK) {
            return false;
        }
        
        $resultOK = $this->validDuplicateEmail();
        if(!$resultOK) {
            return false;
        }
        return true;
    }

    private function validDuplicateEmail() {

        $input_mail = $this->m_formRequest->getParams()['email'];

        $noDuplication = $this->m_user->checkDuplicateEmail($input_mail);
        if($noDuplication === true) {
            return false;
        }
        return true;
    }

    //api用
    public function checkDuplicationOfEmail() {

        $input_mail = $this->m_formRequest->getParams()['email'];
        $duplicated = $this->m_user->checkDuplicateEmail($input_mail);
          //返り値のjsonを決める
        $data = null;
        if($duplicated === false) {
            $data = 'success';
            successed();
        } else {
            $data = 'false';
            failed();
            global $err_msg;
            $err_msg['message'] = MSG08;
        }
        addResponseParams('my_data', $data);
    }


}