<?php

namespace Gbk\Controllers;

class ErrorController extends AbstractController {
    public function notFound(): string {
        $properties = ['errorMessage' => 'Page not found!'];
        	return ('Page not found!');
//        return $this->render('error.twig', $properties);
    }
}