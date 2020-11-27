<?php

namespace core;

class route
{
    public static $basePath = '';
    public static $hasRoute = false;
    public static $routes = [];
    public static $prefix = '';

    public function __construct()
    {
        // echo 'as ';
    }

    public static function get(string $path, $callback)
    {
        self::$routes['get'][self::$prefix . $path] = [
            'callback' => $callback
        ];
        return new self();
    }

    public static function post(string $path, $callback)
    {
        self::$routes['post'][$path] = [
            'callback' => $callback
        ];
    }

    public static function getUrl()
    {
        return str_replace(self::$basePath, null, $_SERVER['REQUEST_URI']);
        // return $_SERVER['REQUEST_URI'];
    }

    public static function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public static function disPatch()
    {
        $url = self::getUrl();
        $method = self::getMethod();
        foreach (self::$routes[$method] as $path => $props) {
            $callback = $props['callback'];
            $path = preg_replace('/([:])([a-zA-Z]+)/m', '([0-9a-zA-Z-_]+)', $path);
            $path = str_replace('/', '\/', $path);
            // $path = preg_replace('/([\/]+)/m', '([\/]+)', $path);
            $pattern = '#^' . $path . '$#';
            // $pattern = $path;
            // $pattern = '#^' . $path . '$#';
            // echo $s . PHP_EOL;
            // echo $pattern . PHP_EOL;
            if (preg_match($pattern, $url, $params)) {
                if (is_array($callback)) {
                    $callback = $callback['callback'];
                }
                array_shift($params);
                // print_r($params);
                if (is_callable($callback)) {
                    echo call_user_func_array($callback, $params);
                } elseif (is_string($callback)) {
                    // class
                    [$controllerName, $methodName] = explode('@', $callback);
                    $controllerName = 'app\controllers\\' . $controllerName;
                    require realpath('.') . '/' . $controllerName . '.php';
                    // echo $controllerName;
                    $controller = new $controllerName();
                    echo call_user_func_array([$controller, $methodName], $params);
                    // echo $controller->{$methodName}();
                }
            }
            // else echo 'as1';
        }
    }
}
