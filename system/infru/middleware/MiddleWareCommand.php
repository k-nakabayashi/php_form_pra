<?php

abstract class MiddleWareCommand
{
  public $m_redirect = SERVER_ERROR;
  abstract public function handle();

  public function __construct($i_redirect)
  {
    if(!empty($i_redirect)) {
      $this->m_redirect = $i_redirect;
    }
  }
}