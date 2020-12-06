<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class HomeController {
    
    public function home(Request $request, Response $response, array $args)
    {
        $response->getBody()->write("Page d'accueil");
        print_r($args);
        return $response;
    }
}