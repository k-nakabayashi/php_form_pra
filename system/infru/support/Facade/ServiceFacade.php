<?php
use infru\support\factory\RootFactory;
class ServiceFacade {

    public static function executeService($i_provideName) {
        $factory = new RootFactory('aaa\\');
        $provider = $factory->createItem($i_provideName);
        $result = $provider->handle();
        return $result;
    }
}