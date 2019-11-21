<?php

namespace Gbk\Controllers;

use Gbk\Core\Request;
use Gbk\Utils\DependencyInjector;

abstract class AbstractController {
    protected $request;
    protected $db;
    protected $config;
    protected $log;
    protected $userId;
    protected $di;

    public function __construct(DependencyInjector $di, Request $request) {
        $this->request = $request;
        $this->di = $di;
        $this->db = $di->get('PDO');
        $this->log = $di->get('Logger');
        $this->config = $di->get('Utils/config');
        }
    public function setUserId(int $userId) {
        $this->userId = $userId;
        }
    }