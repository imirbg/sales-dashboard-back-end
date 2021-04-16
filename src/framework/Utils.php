<?php

namespace App\framework;

use PDO;
use PDOException;
use Faker\Factory;
class Utils
{


    public static function invalidateReportCaches()
    {

    }

    public static function addDataToDB()
    {
        $host = getenv('MYSQL_HOST');
        $port = getenv('MYSQL_PORT');
        $user = getenv('MYSQL_USER_NAME');
        $pass = getenv('MYSQL_PASSWORD');
        $db = getenv('MYSQL_DATABASE');
        try {
            $conn = new PDO("mysql:host=$host:$port;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $addCustomerQuery = "INSERT INTO customers (firstName, lastName, email) VALUES (?, ?, ?)";
            $addOrderQuery = "INSERT INTO orders (purchaseDate, country, device, customerId) VALUES (?, ?, ?, ?)";
            $addOrderItemQuery = "INSERT INTO order_items (orderId, ean, quantity, price) VALUES (?, ?, ?, ?)";

            $faker = Factory::create();
            for ($i = 0 ; $i < 100; $i++ ){
                $query = $conn->prepare($addCustomerQuery);
                $query->bindValue(1, $faker->firstName);
                $query->bindValue(2, $faker->lastName);
                $query->bindValue(3, $faker->email);
                $query->execute();
                $customerId = $conn->lastInsertId();
                for ($j = 0 ; $j < $faker->numberBetween($min = 0, $max = 20); $j++ ){
                    $query = $conn->prepare($addOrderQuery);
                    $query->bindValue(1, $faker->dateTimeThisYear($max = 'now', $timezone = null)->format('Y-m-d'));
                    $query->bindValue(2, $faker->country);
                    $query->bindValue(3, "mobile");
                    $query->bindValue(4, $customerId);
                    $query->execute();
                    $orderId = $conn->lastInsertId();
                    for ($k = 0 ; $k < $faker->numberBetween($min = 0, $max = 20); $k++ ){
                        $query = $conn->prepare($addOrderItemQuery);
                        $query->bindValue(1, $orderId);
                        $query->bindValue(2, $faker->ean13);
                        $query->bindValue(3, $faker->numberBetween($min = 1, $max = 5));
                        $query->bindValue(4, $faker->numberBetween($min = 10, $max = 200));
                        $query->execute();
                    }
                }

            }
            echo "New records created successfully";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}
