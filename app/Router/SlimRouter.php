<?php

namespace App\Router;

use DI\Container;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Throwable;

class SlimRouter
{
    private static array $instance;
    private const CONTROLLER_NAMESPACE = "\\App\\Controllers\\";
    private const MIDDLEWARE_NAMESPACE = "\\App\\MiddleWare\\";

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    private function __construct(App $slimApp, array $routes, Container $container)
    {
        $this->run($slimApp, $routes, $container);

    }

    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    public static function getInstance(App $slimApp, array $routes, Container $container): SlimRouter
    {
        $cls = static::class;
        if (!isset(self::$instance[$cls])) {
            self::$instance[$cls] = new static($slimApp, $routes, $container);
        }
        return self::$instance[$cls];
    }


    /**
     * @throws ReflectionException
     * @throws Throwable
     */
    private function run(App $slimApp, array $routes, Container $container): void
    {
        foreach ($routes as $path => $params) {

            [$className, $classMethod] = explode("@", $params['action']);
            $className = self::CONTROLLER_NAMESPACE . $className;

            foreach ($params['method'] as $method) {
                $slimAppMethod = strtolower($method);

                $controller = $this->getController($className);
                $method = $this->getMethod($className, $classMethod);
                $handler = $this->makeHandler($controller, $method, $container);

                $slimAppAddMethod = $slimApp->$slimAppMethod($path, $handler);

                if (array_key_exists('middleware', $params) && $params['middleware']) {
                    $this->addMiddleWare($params['middleware'], $slimAppAddMethod, $container);
                }
            }
        }

        $slimApp->run();
    }

    /**
     * @throws ReflectionException
     */
    private function makeHandler(ReflectionClass $class, ReflectionMethod $method, Container $container): callable
    {

        $controller = $class->newInstance($container);

        return function (Request $request, Response $response) use ($controller, $method) {
            $checkRequest = new RequestHandler($method, $controller, $request);
            $responseResult = $checkRequest->handle();
            if ($responseResult->getResult()) {
                $response->getBody()->write(json_encode($responseResult->getResult()));
            }
            return $response->withHeader('Content-Type', 'application/json')->withStatus($responseResult->getResponseCode());
        };
    }

    /**
     * @throws ReflectionException
     */
    private function getMethod(string $className, string $classMethod): ReflectionMethod
    {
        return new ReflectionMethod($className, $classMethod);
    }

    /**
     * @throws ReflectionException
     */
    private function getController(string $className): ReflectionClass
    {
        return new ReflectionClass($className);
    }

    private function addMiddleWare(array $slimAddMiddleware, $slimAppAddMethod, Container $container): void
    {
        foreach ($slimAddMiddleware as $middlewareName) {
            $middlewareClassName = self::MIDDLEWARE_NAMESPACE . $middlewareName;
            $slimAppAddMethod->add(new $middlewareClassName($container));
        }
    }
}