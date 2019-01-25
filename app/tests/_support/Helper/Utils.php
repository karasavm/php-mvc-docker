<?php
namespace Helper;
codecept_debug('aaaaaaaaaaaaaaaaaaaaa');
// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Utils extends \Codeception\Module
{

    public static function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
