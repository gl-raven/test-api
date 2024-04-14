<?php


namespace Core;


class Router
{
    private static ?Router $instance = null;
    private string $model = '';
    private array $params = [];

    /**
     * @return Router
     */
    public static function getInstance(): Router
    {
        if (is_null(self::$instance)) {
            self::$instance = new Router();
        }

        return self::$instance;
    }

    public function __construct(?string $url = null)
    {
        if (is_null($url)) {
            $parts = parse_url($_SERVER['REQUEST_URI']);
            $url = $parts['path'];
        }

        $path = trim($url, '/');

        if (!strpos($path, '/')) {
            $this->model = $path;
        } else {
            $this->params = explode('/', $path);
            $this->model = $this->params[0];
        }
    }

    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getParam($index): string | false
    {
        return $this->params[$index] ?? false;
    }
}
