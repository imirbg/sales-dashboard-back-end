<?php

namespace App\framework;

use DI\ContainerBuilder;
use Exception;
use function DI\create;
use function DI\get;


use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

use Middlewares\FastRoute;
use Middlewares\RequestHandler;

use Relay\Relay;


use Psr\Http\Message\ResponseInterface;

use \Twig\Loader\FilesystemLoader;

use \Twig\Environment;

class App
{
    private static ?App $instance = null;
    private $appContainer = null;
    private Relay $requestHandler;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        (new Env())->load();
        $loader = new FilesystemLoader(realpath(__DIR__ . '/../views'));
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(false);
        $containerBuilder->useAnnotations(false);
        $containerBuilder->addDefinitions([
            'Response' => create(Response::class)->constructor(get('Twig')),
            'Twig' =>  create(Environment::class)->constructor($loader, [
                'cache' => realpath(__DIR__ . '/../storage/tmp/twig-caches'),
                'auto_reload' => !(getenv('ENVIRONMENT') === "production")
            ]),
        ]);
        $this->appContainer = $containerBuilder->build();
        foreach (require __DIR__ . "/../routes.php" as $route) {
            $this->appContainer->set($route[2][0], create($route[2][0])->constructor(get('Response')));
        }

        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            foreach (require __DIR__ . "/../routes.php" as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        });
        $middlewareQueue[] = new FastRoute($dispatcher);
        $middlewareQueue[] = new RequestHandler($this->appContainer);
        $this->requestHandler = new Relay($middlewareQueue);
    }

    public function getContainer()
    {
        return $this->appContainer;
    }

    /**
     * @throws Exception
     */
    public function handle($request): ResponseInterface
    {
        if ($this->requestHandler) {
            return $this->requestHandler->handle($request);
        }
        throw new Exception('App hasn\'t been bootstrapped yet');
    }


    public static function getInstance(): App
    {
        if (self::$instance == null) {
            self::$instance = new App();
        }

        return self::$instance;
    }

}
