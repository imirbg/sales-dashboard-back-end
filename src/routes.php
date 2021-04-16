<?php

return [
    ['GET', '/', ['App\controllers\MainPage', 'index']],
    ['GET', '/add-new-customers', ['App\controllers\MainPage', 'addCustomers']],
    ['GET', '/reports', ['App\controllers\ReportsController', 'getReports']],
];
