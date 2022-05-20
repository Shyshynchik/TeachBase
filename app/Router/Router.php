<?php

class Router
{
    private array $routes;

    private const AVAILABLE_METHODS = ['POST', 'GET'];
    private static array $instance;

    private function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public static function getInstance(array $routes): Router
    {
        $cls = static::class;
        if (!isset(self::$instance[$cls])) {
            self::$instance[$cls] = new static($routes);
        }
        return self::$instance[$cls];
    }

    /**
     * @throws ReflectionException
     * @throws PageNotFoundException
     */
    private function callAction(string $className, string $classMethod, ServerRequest $request): array
    {
        $class = new ReflectionClass($className);
        $controller = $class->newInstance();
        $method = $this->getMethod($className, $classMethod);
        $this->checkMethodForParams($method, $request);
        return $method->invokeArgs($controller, $request->getParams());
    }

    /**
     * @throws ReflectionException
     */
    private function getMethod(string $className, string $classMethod): ReflectionMethod
    {
        return new ReflectionMethod($className, $classMethod);
    }

    /**
     * @throws PageNotFoundException
     */
    private function checkMethodForParams(ReflectionMethod $reflectionMethod, ServerRequest $request): void
    {
        $arrayWithoutDefaultParams = [];
        $arrayWithDefaultParams = [];

        foreach ($reflectionMethod->getParameters() as $param) {
            if (!$param->isDefaultValueAvailable()) {
                $arrayWithoutDefaultParams[$param->getName()] = $param->getName();
            }
            $arrayWithDefaultParams[$param->getName()] = $param->getName();
        }

        if (array_diff_key($arrayWithoutDefaultParams, $request->getParams())) {
            throw new PageNotFoundException();
        }
        if (array_diff_key($request->getParams(), $arrayWithDefaultParams)) {
            throw new PageNotFoundException();
        }
    }

    /**
     * @throws PageNotFoundException
     * @throws ReflectionException
     */
    public function run(ServerRequest $request): string
    {
        $action = $this->getAction($request);

        if (!$action) {
            throw new PageNotFoundException();
        }

        $classMethodAction = explode("@", $action);

        $className = $classMethodAction[0];
        $classMethod = $classMethodAction[1];
        return json_encode($this->callAction($className, $classMethod, $request));
    }

    private function getAction(ServerRequest $request): ?string
    {
        $requestPath = $request->getPath();
        $method = $request->getMethod();

        foreach ($this->routes as $path => $route) {
            if ($path !== $requestPath) {
                continue;
            }
            if (!in_array($method, $route['method'], true)) {
                continue;
            }
            if (!in_array($method, self::AVAILABLE_METHODS)) {
                continue;
            }

            return $route['action'];
        }
        return null;
    }
}

