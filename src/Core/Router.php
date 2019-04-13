<?php

namespace Gbk\Core;

use Gbk\Controllers\ErrorController;
use Gbk\Controllers\UserController;
use Gbk\Utils\DependencyInjector;

class Router {
    private $di;
    private $routeMap;
    private static $regexPatters = [
        'number' => '\d+',
        'string' => '\w'
    ];

    public function __construct(DependencyInjector $di) {
        $this->di = $di;
        $json = file_get_contents(__DIR__ . '/../../config/routes.json');
        $this->routeMap = json_decode($json, true);
    }


/**
 * selects the right controller 
 * @param  Request $request everything that send so server
 * @return string           html code
 */
    public function route(Request $request): string {
// check is logged in? by cookies
// if not logged in - show login or register form in the top
// if logged in - show user plate
// after that - try to generate posts view using request info
// after that  - if logged in - show post form
// after that - show navbar
   

        $path = $request->getPath();


        //  if ($request->isPost()) {
        //     print_r('try to logout?');
        // }
        // print_r($request->getParams());
        $returnPage='';
            foreach ($this->routeMap as $route => $info) {
                $regexRoute = $this->getRegexRoute($route, $info);
                if (preg_match('@'.$regexRoute.'@', $path, $matches )) {
                        $returnPage = $returnPage.($this->executeController($route, $path, $info, $request));
                }
            }
            return $returnPage;
        $errorController = new ErrorController($this->di, $request);
        return $errorController->notFound();
    }

    /**
     * convert route with params to regex 
     * @param  string $route [route name from routes.json]
     * @param  array  $info  [array from routes.json]
     * @return [string]        [ready for matching string with real request path]
     */
    private function getRegexRoute(string $route, array $info): string {
        if (isset($info['params'])) {
            foreach ($info['params'] as $name => $type) {
                $route = str_replace(':' . $name, self::$regexPatters[$type], $route);
            }
        }

        return $route;
    }

    /**
     * call controller for page generation
     * @param  string  $route   all about route
     * @param  string  $path    real request path
     * @param  array   $info    
     * @param  Request $request 
     * @return [type]           
     */
    private function executeController(
        string $route,
        string $path,
        array $info,
        Request $request
    ): string {
        if (!($request->getCookies()->has('sorting'))) {
            setcookie('sorting',0);
        }
        
        $controllerName = '\Gbk\Controllers\\' . $info['controller'] . 'Controller';
        $controller = new $controllerName($this->di, $request);

        if (isset($info['login']) && $info['login']) {
            if ($request->getCookies()->has('user')) {
                $userId = $request->getCookies()->get('user');
                $controller->setUserId($userId);
            } else {
                $errorController = new UserController($this->di, $request);
                return $errorController->login();
            }
        }

        $params = $this->extractParams($route, $path);
        // print_r($controller);
        // print_r($info['method']);
        // print_r($params);

        return call_user_func_array([$controller, $info['method']], $params);
    }
    /**
     * compare param`s names from routes.json and real values from request`s path
     * @param  string $route 
     * @param  string $path  
     * @return [type]        array (param_name, param_value)
     */
    private function extractParams(string $route, string $path): array {
        // print_r($route.'+++++++++'.$path);

        $params = [];

        $pathParts = explode('/', $path);
        $routeParts = explode('/', $route);
        // print_r($routeParts.'+++++++++'.$pathParts);
        // print_r($pathParts);
        foreach ($routeParts as $key => $routePart) {
            if (strpos($routePart, ':') === 0) {
                // print_r($pathParts[$key]);
                $name = substr($routePart, 1);
                $params[$name] = $pathParts[$key];

            }
        }
        // print_r($params);
        return $params;
    }
}