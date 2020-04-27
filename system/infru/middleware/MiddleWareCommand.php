<?php
namespace infru\middleware;
require_once(UTILITY_BASE.'Helper.php');
abstract class MiddleWareCommand
{
  public $m_faleRedirect = SERVER_ERROR;
  abstract public function handle();

  public function __construct($i_redirect)
  {
    if(!empty($i_redirect)) {
      $this->m_faleRedirect = $i_redirect;
    }
  }
  
  final public function failed() {
    //レスポンスのリダイレクトに設定
    setResponseRedirect($this->m_faleRedirect);
  }
}