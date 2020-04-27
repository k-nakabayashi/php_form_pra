<?php

use infru\core\Container;
use infru\core\Router;
use infru\Service\RouteMiddleWareService;

require_once(INFRU_SERVICE.'RouteMiddleWareService.php');

function getTargetMiddleWare() {
    return Router::$m_targetRoute['middleWare'];
}
function getMiddleWrapper() {
    return RouteMiddleWareService::getMiddleWrapper();
}
function getMiddleSingle() {
    return RouteMiddleWareService::getMiddleSingle();
}