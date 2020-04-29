<?php

use infru\core\Container;
use infru\core\Router;
use infru\core\UseCaseMiddleWare;


function getTargetMiddleWare() {
    return Router::$m_targetRoute->getUseCaseMap()['middleWare'];
}
function getMiddleWrapper() {
    return UseCaseMiddleWare::getMiddleWrapper();
}