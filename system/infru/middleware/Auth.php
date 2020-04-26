<?php
//セッションの有無・有効無効を知りたい

class Auth {

  private $m_loginDate;
  private $m_loginLimit;
  private $m_LoginStatus = false;

  public function __construct()
  {
    $this->initSesstion();
    $this->setLifeTime();
    $loginOK = $this->checkLoginStatus();
    if ( $loginOK === true) {
      $this->updateLoginDate();
    }
  }
  
  private function initSesstion () {
    session_save_path(SESSION_TMP_FILE);
    ini_set('session.gc_maxlifetime', SESSION_LIFE);
    ini_set('session.cookie_lifetime ', COOKIE_LIFE);
    session_start();
    session_regenerate_id();
  }

  private  function setLifeTime ()
  {
    if (isset($_SESSION['login_date'])) {
      $this->m_loginDate = $_SESSION['login_date'];
    } else {
      $this->m_loginDate = null;
    }
    if (isset($_SESSION['login_limit'])) {
      $this->m_loginLimit = $_SESSION['login_limit'];
    } else {
      $this->m_loginLimit = null;
    }
  }

  private function checkLoginStatus ()
  {
   
    if(!isset($this->getLoginDate)){
      $this->m_LoginStatus = false;

    } else if( ($this->getLoginDate() + $this->getLoginLimit()) < time()){

      $this->m_LoginStatus = false;
      session_destroy(); 

    } else {
      $this->m_LoginStatus = true;
    }

    return $this->m_LoginStatus;
  }

  private function updateLoginDate () {
    $_SESSION['login_date'] = time();
    $this->m_loginDate = $_SESSION['login_date'];
  }



  public function getLoginDate () {
    return $this->m_loginDate;
  }
  public function getLoginLimit () {
    return $this->m_loginLimit;
  }
  public function getLoginStatus () {
    return $this->m_LoginStatus;
  }
}
?>