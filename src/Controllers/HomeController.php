<?php

namespace  App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\PhpRenderer;

class HomeController
{
    private PhpRenderer $renderer;

    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->setTemplatePath(__DIR__ . '/../Views/');
    }

    public function home(Request $request, Response $response): ResponseInterface
    {
        return $this->renderer->render($response, 'home.php');
    }
}