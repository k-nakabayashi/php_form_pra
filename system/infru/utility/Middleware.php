<?php

use infru\core\Container;
use infru\core\manager\RouteManger;
use infru\core\UseCaseMiddleWare;


function getTargetMiddleWare() {
    return RouteManger::$m_targetRoute->getUseCaseMap()['middleWare'];
}
function getMiddleWrapper() {
    return UseCaseMiddleWare::getMiddleWrapper();
}