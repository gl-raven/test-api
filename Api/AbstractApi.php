<?php


namespace Api;


use Core\Request;
use Core\Response;
use Core\Router;
use db\Connection;
use PDO;

abstract class AbstractApi
{
    protected $action = '';
    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var Request
     */
    protected Request $request;

    protected PDO $db;

    /**
     * @var Router
     */
    protected Router $router;

    public function __construct()
    {
        $this->response = Response::getInstance();
        $this->request = Request::getInstance();
        $this->router = Router::getInstance();
        $this->db = Connection::getInstance();

        $action = 'action' . ucfirst($this->router->getParam(2));
        if (!method_exists($this, $action)) {
            // Действие по умолчанию
            $action = 'actionIndex';
        }

        $this->action = $action;
    }

    public function actionIndex(): void
    {
        $this->response->assign(['action' => 'index']);
    }

    public function run(): void
    {
        call_user_func(array($this, $this->action));
    }
}
