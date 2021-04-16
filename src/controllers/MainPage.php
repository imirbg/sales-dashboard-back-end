<?php
declare(strict_types=1);

namespace App\controllers;

use App\framework\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\framework\Controller;


class MainPage extends Controller
{

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        
         return $this->response->view('index.html', [
             'name' => "AmirHassan",
             'lastName' => "Bagheri",
             'frontEndBaseUrl' => getenv('FRONT_END_BASE_URL')
         ]);
    }

    public function addCustomers(ServerRequestInterface $request): ResponseInterface {
        Utils::addDataToDB();
        return $this->response->json("Data Successfully added");
    }
}
