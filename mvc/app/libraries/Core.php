<?php

declare(strict_types=1);

namespace libraries;

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 *
 */


class Core
{
    protected string $currentModule = 'Pages';
    protected string | object $currentController = 'Pages';
    protected string $currentMethod = 'index';
    protected array $params = [];

    public function __construct()
    {
        //print_r($this->getUrl());

        $url = $this->getUrl();

        // Look in Controller for first value to set $currentController
        if (file_exists('../app/Controller/' . ucwords($url[0]) . '.php')) {
            // If exists, set as controller
            $this->currentController = ucwords($url[0]);
            $this->currentModule = ucwords($url[0]);
            // Unset 0 Index
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/code/' . $this->currentModule . '/Controller/' .  $this->currentController . '.php';
        $controllerNamespace = "code\\" . $this->currentModule . "\Controller\\" . $this->currentController;

        // Instantiate controller class
        $this->currentController = new $controllerNamespace();    # $currentController object created using namespace

        // Check for second part of url to set the $currentMethod
        if (isset($url[1])) {
            // Check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            }
        }

        // Get params to set $params

        $this->params = $url ? array_values($url) : []; # Everything in $url array becomes a param in $params array

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(): array
    {
        if (isset($_GET['url'])) {       # the url is defined in the .htaccess rewrite rule index.php?url=$1
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;        # Returns an array strings for the $currentController value
        }
        return ['pages'];
    }
}
