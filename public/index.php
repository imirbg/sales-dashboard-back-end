<?php
declare(strict_types=1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

use App\framework\App;


use Zend\Diactoros\ServerRequestFactory;
use Narrowspark\HttpEmitter\SapiEmitter;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$response = App::getInstance()->handle(ServerRequestFactory::fromGlobals());
$emitter = new SapiEmitter();
$emitter->emit($response);
