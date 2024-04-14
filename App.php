<?php


use Api\AbstractApi;
use Core\Request;
use Core\Response;
use Core\Router;
use Api\User;
use Api\Group;
use db\Connection;

class App
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @var Router
     */
    private Router $router;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->loadFiles();
        Connection::init($config);

        $this->request = Request::getInstance();
        $this->router = Router::getInstance();
        $this->response = Response::getInstance();
    }

    private function loadFiles(): void
    {
        $path = dirname(realpath(__FILE__));
        require_once $path . "/db/Connection.php";
        require_once $path . "/Mapper/AbstractMapper.php";
        require_once $path . "/Mapper/UserMapper.php";
        require_once $path . "/Mapper/ActionMapper.php";
        require_once $path . "/Mapper/GroupMapper.php";
        require_once $path . "/Mapper/UserGroupRelMapper.php";
        require_once $path . "/Mapper/GroupActionRelMapper.php";
        require_once $path . "/db/Connection.php";
        require_once $path . "/Core/Request.php";
        require_once $path . "/Core/Router.php";
        require_once $path . "/Core/Response.php";
        require_once $path . "/Api/AbstractApi.php";
        require_once $path . "/Api/Group.php";
        require_once $path . "/Api/User.php";
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $api = $this->getApiObject($this->router->getModel());

        if (!is_null($api)){
            $api->run();
        }

        $this->response->printResponse();
    }

    /**
     * @param $name
     * @return AbstractApi|null
     */
    public function getApiObject($name): ?AbstractApi
    {
        $model = ucfirst($name);

        if (empty($model)) {
            return null;
        }

        $class = 'Api\\' . $model;
        if (!class_exists($class)) {
            return null;
        }

        $api = new $class();

        if (!($api instanceof AbstractApi)) {
            return null;
        }

        return $api;
    }
}
