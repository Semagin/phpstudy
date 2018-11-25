<?php

namespace Gbk\Controllers;

use Gbk\Core\Request;
use Gbk\Utils\DependencyInjector;

abstract class AbstractController {
    protected $request;
    protected $db;
    protected $config;
//    protected $view;
    protected $log;
    protected $customerId;
    protected $di;

    public function __construct(DependencyInjector $di, Request $request) {
        $this->request = $request;
        $this->di = $di;
        $this->db = $di->get('PDO');
        $this->log = $di->get('Logger');
//        $this->view = $di->get('Twig_Environment');
        $this->config = $di->get('Utils/config');
//            print_r($request->getCookies());
 //       $di->get('Logger')->addWarning($request->getParams());
 //       return 0;
    }

    public function setUserId(int $customerId) {
        $this->customerId = $customerId;
    }

    protected function render(string $template, array $params): string {
        return $this->view->loadTemplate($template)->render($params);
    }
}