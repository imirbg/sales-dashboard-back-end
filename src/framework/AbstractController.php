<?php

namespace App\framework;


abstract class AbstractController implements ControllerInterface {
    protected ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }
}
