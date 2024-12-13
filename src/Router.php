<?php

namespace App;
class Router
{
    public string|array|int|null|false $currentRoute;
    public function __construct(){
        $this->currentRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
    public function getResource(): false|int
    {
        if (isset(explode("/", $this->currentRoute)[2])) {
            return (int)explode("/", $this->currentRoute)[2];
        }
        return false;
    }
    public function get($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $resourceValue = $this->getResource();
            if ($resourceValue){
                $resourceValue = str_replace('{id}', $resourceValue, $route);
                if ($route == $this->currentRoute){
                    $callback($resourceValue);
                    exit();
                }
            }
        }
    }
    public function post($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($route == $this->currentRoute){
                $callback();
                exit();
            }
        }
    }

    public function put($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
                $resourceID = $this->getResource();
                $route = str_replace("{id}", $resourceID, $route);
                if ($route == $this->currentRoute){
                    $callback($resourceID);
                    exit();
                }
            }
        }
    }
}