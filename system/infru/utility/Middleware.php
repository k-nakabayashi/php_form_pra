<?php

use infru\core\Container;
use infru\core\manager\RouteManger;
use infru\core\usecase\UseCaseMiddleWare;


function getTargetMiddleWare() {
    return RouteManger::$m_targetUsecase->getUseCaseMap()['middleWare'];
}
function getMiddleWrapper() {
    return UseCaseMiddleWare::getMiddleWrapper();
}