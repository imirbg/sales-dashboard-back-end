<?php
namespace App\framework;



interface ControllerInterface {
    public function __construct(ResponseInterface $response);
}
