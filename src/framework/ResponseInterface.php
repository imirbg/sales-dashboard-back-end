<?php

namespace App\framework;

use \Twig\Environment;
use Zend\Diactoros\Response;

interface ResponseInterface {

    function __construct(Environment $twig);
    function json(array $value , int $statusCode = 200): Response;
    function view(string $name, array $data): Response;

}
