<?php

namespace App;

class Router {
    public string|array|int|null|false $currentRoute;
    public function __construct () {
        $this->currentRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
    public function getResource ($route): false|string
    {
        $resourceIndex = mb_stripos($route, '{id}');
        if (!$resourceIndex){
            return false;
        }
        $resourceValue = substr($this->currentRoute, $resourceIndex);
        if($limit = mb_stripos($resourceValue, '/')){
            return substr($resourceValue, 0, $limit);
        }
        return $resourceValue ?: false;
    }
    public function get ($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->extracted($route, $callback);
        }
    }
    public function post ($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->extracted($route, $callback);
        }
    }
    public function putApi ($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $this->extracted($route, $callback);
        }
    }
    public function put ($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            if ($_SERVER[''])
            $this->extracted($route, $callback);
        }
    }
    public function delete ($route, $callback): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $this->extracted($route, $callback);
        }
    }
    public function extracted($route, $callback): void
    {
        $resourceValue = $this->getResource($route);
        if ($resourceValue) {
            $resourceRoute = str_replace('{id}', $resourceValue, $route);
            if ($resourceRoute == $this->currentRoute) {
                $callback($resourceValue);
                exit();
            }
        }
        if ($route == $this->currentRoute) {
            $callback();
            exit();
        }
    }
    public function isApiCall(): bool{
        return mb_stripos($_SERVER['REQUEST_URI'], '/api') === 0;
    }
    public function isTelegram(): bool{
        return mb_stripos($_SERVER['REQUEST_URI'], '/telegram') === 0;
    }
}