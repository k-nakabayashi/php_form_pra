<?php
require_once(CORE_BASE.'Container.php');
require_once(CORE_BASE.'Router.php');
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