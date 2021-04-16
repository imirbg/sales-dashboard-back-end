<?php

namespace App\services;
use DateTime;
use PDO;
use PDOException;
use Carbon\Carbon;
abstract class AbstractReportService implements ReportServiceInterface
{
    private PDO $conn;
    private $host;
    private $port;
    private $user;
    private $pass;
    private $db;

    function __construct() {
        $this->host = getenv('MYSQL_HOST');
        $this->port = getenv('MYSQL_PORT');
        $this->user = getenv('MYSQL_USER_NAME');
        $this->pass = getenv('MYSQL_PASSWORD');
        $this->db = getenv('MYSQL_DATABASE');

        try {
            $this->conn = new PDO("mysql:host=$this->host:$this->port;dbname=$this->db", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    function numberOfOrders(DateTime $dateFrom = null, DateTime $dateTo = null): array
    {
        $queryString = "SELECT purchaseDate, count(*) as numberOfOrders FROM orders WHERE purchaseDate BETWEEN ? AND ? GROUP BY purchaseDate ORDER BY purchaseDate ASC ";
        $rows = $this->sendQuery($queryString, $dateFrom, $dateTo);
        $result = [];
        foreach ($rows as $row) {
                array_push($result,['purchaseDate' => $row['purchaseDate'], 'numberOfOrders' => $row['numberOfOrders'] ]);
            }
        return $result;
    }

    function numberOfCustomers(DateTime $dateFrom = null, DateTime $dateTo = null): array
    {
        $queryString = "SELECT purchaseDate, count(DISTINCT customerId) as numberOfCustomers FROM orders WHERE purchaseDate BETWEEN ? AND ? GROUP BY purchaseDate ORDER BY purchaseDate ASC ";
        $rows = $this->sendQuery($queryString, $dateFrom, $dateTo);
        $result = [];
        foreach ($rows as $row) {
            array_push($result,['purchaseDate' => $row['purchaseDate'], 'numberOfCustomers' => $row['numberOfCustomers'] ]);
        }
        return $result;
    }

    function totalRevenue(DateTime $dateFrom = null, DateTime $dateTo = null): array
    {

        $queryString = "SELECT orders.purchaseDate AS purchaseDate, SUM(order_items.price) AS total FROM order_items JOIN orders ON orders.id = order_items.orderId WHERE orders.id IN (SELECT id FROM orders WHERE purchaseDate BETWEEN ? AND ?) GROUP BY orders.purchaseDate";
        $rows = $this->sendQuery($queryString, $dateFrom, $dateTo);
        $result = [];
        foreach ($rows as $row) {
            array_push($result,['purchaseDate' => $row['purchaseDate'], 'total' => $row['total'] ]);
        }
        return $result;
    }

    /**
     * @param string $queryString
     * @param DateTime|null $dateFrom
     * @param DateTime|null $dateTo
     * @return array
     */
    public function sendQuery(string $queryString, ?DateTime $dateFrom, ?DateTime $dateTo): array
    {
        $query = $this->conn->prepare($queryString);
        if (!$dateFrom | !$dateTo) {
            $todayDate = Carbon::now()->toDateString();
            $lastMonthDate = Carbon::now()->subMonth()->toDateString();
            $query->bindValue(1, $lastMonthDate);
            $query->bindValue(2, $todayDate);
        } else {
            $from = (new Carbon($dateFrom))->toDateString();
            $to = (new Carbon($dateTo))->toDateString();
            $query->bindValue(1, $from);
            $query->bindValue(2, $to);
        }
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        return $query->fetchAll();
    }

}
