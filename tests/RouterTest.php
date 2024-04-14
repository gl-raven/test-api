<?php


namespace tests;

require_once './Core/Router.php';

use Core\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testModule()
    {
        $router = new Router('/');
        $this->assertEquals('', $router->getModel());

        $router = new Router('/user/1/accessRights');
        $this->assertEquals('user', $router->getModel());

        $router = new Router('user');
        $this->assertEquals('user', $router->getModel());
    }

    public function testTestParams()
    {
        $router = new Router('/user/1/accessRights');
        $this->assertEquals('user', $router->getParam(0));
        $this->assertEquals('1', $router->getParam(1));
        $this->assertEquals('accessRights', $router->getParam(2));
        $this->assertEquals(false, $router->getParam(3));
    }
}
