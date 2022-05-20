<?php

namespace App\Components;

use App\Exception\ContainerException;
use App\Exception\ServiceNotFoundException;
use ReflectionClass;
use ReflectionException;

class MyDIContainer
{

    private array $dIConfig;
    private array $instances;

    public function __construct(array $dIConfig)
    {
        $this->dIConfig = $dIConfig;
    }

    public function has(string $className): bool
    {
        return isset($this->dIConfig[$className]);
    }


    /**
     * @throws ServiceNotFoundException
     * @throws ContainerException
     */
    public function get(string $className): object
    {
        if (!$this->has($className)) {
            throw new ServiceNotFoundException('Service not found: ' . $className);
        }

        if (!$this->hasSavedInstance($className)) {
            $this->instances[$className] = $this->getInstance($this->dIConfig[$className]);
        }

        return $this->instances[$className];
    }

    private function hasSavedInstance(string $className): bool
    {
        return isset($this->instances[$className]);
    }


    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    private function getInstance(string $className): object
    {
        try {
            $class = new ReflectionClass($className);
        } catch (ReflectionException $e) {
            throw new ContainerException('Class ' . $className . " does not exist");
        }

        if (!$class->isInstantiable()) {
            throw new ContainerException('Class ' . $className, " is not instantiable");
        }

        try {

            if (!$class->getConstructor()) {
                return $class->newInstance();
            }

            return $class->newInstanceArgs($this->getDependencies($class));
        } catch (ReflectionException $e) {
            throw new ContainerException('Class ' . $className . " cannot be constrain");
        }

    }


    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    private function getDependencies(ReflectionClass $class): array
    {
        $classDependencies = [];

        foreach ($class->getConstructor()->getParameters() as $param) {
            $classDependencies[$param->getName()] = $this->get($param->getType()->getName());
        }

        return $classDependencies;
    }

}