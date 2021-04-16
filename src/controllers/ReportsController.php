<?php
declare(strict_types=1);

namespace App\controllers;

use App\services\ReportService;
use DateTime;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\framework\Controller;


class ReportsController extends Controller
{

    public function getReports(ServerRequestInterface $request): ResponseInterface
    {

        try {
            $from = DateTime::createFromFormat('Y-m-d', $request->getQueryParams()['from']);
            $to = DateTime::createFromFormat('Y-m-d', $request->getQueryParams()['to']);
        } catch (Exception $e){
            return $this->response->json(['message' =>"Bad Request"], 400);
        }

        if(!$from or !$to){
            return $this->response->json(['message' =>"Bad Request"], 400);
        }

         $reportService = new ReportService();
         return $this->response->json([
             'numberOfCustomers' => $reportService->numberOfCustomers($from, $to),
             'numberOfOrders' =>  $reportService->numberOfOrders($from, $to),
             'totalRevenue' => $reportService->totalRevenue($from, $to)
         ]);

    }
}
