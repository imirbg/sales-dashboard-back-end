<?php

namespace App\services;

use DateTime;

interface ReportServiceInterface {
    function numberOfOrders(DateTime $dateFrom = null, DateTime $dateTo = null);
    function totalRevenue(DateTime $dateFrom = null, DateTime $dateTo = null);
    function numberOfCustomers(DateTime $dateFrom = null, DateTime $dateTo = null);
}
