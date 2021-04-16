<?php

namespace App\framework;

use Twig\Environment;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;
abstract class AbstractResponse implements ResponseInterface {

    private Environment $twig;

    function __construct(Environment $twig) {
        $this->twig = $twig;
    }

    function json(array $value , int $statusCode = 200): JsonResponse {
        return new JsonResponse(
            $value,
            $statusCode,
            ['Content-Type' => ['application/json']]
        );
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    function view(string $name , array $data = []): HtmlResponse
    {

        $twigTemplate = $this->twig->load($name);
        return new HtmlResponse(
            $twigTemplate->render($data),
            200,
            ['Content-Type' => ["text/html"]]
        );
    }



}
