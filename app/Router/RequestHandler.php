<?php

namespace App\Router;

use App\DTO\HttpStatus;
use App\DTO\ResultResponse;
use App\Exception\PageNotFoundException;
use ReflectionException;
use ReflectionMethod;
use Slim\Http\Request;

class RequestHandler
{
    private ReflectionMethod $method;
    private Request $request;
    private object $controller;

    public function __construct(ReflectionMethod $method, object $controller, Request $request)
    {
        $this->method = $method;
        $this->controller = $controller;
        $this->request = $request;
    }

    public function handle(): ResultResponse
    {
        try {
            if (!$this->checkMethodForParams()) {
                throw new PageNotFoundException();
            }

            $result = $this->method->invokeArgs($this->controller, $this->request->getParams());
            $resultResponse = new ResultResponse($result['code'], HttpStatus::SUCCESS_MESSAGE, $result['data']);
        } catch (PageNotFoundException $e) {
            $resultResponse = new ResultResponse(HttpStatus::NOT_FOUND_CODE, HttpStatus::NOT_FOUND_MESSAGE, []);
        } catch (ReflectionException $e) {
            $resultResponse = new ResultResponse(HttpStatus::INTERNAL_SERVER_ERROR_CODE, HttpStatus::INTERNAL_SERVER_ERROR_MESSAGE, []);
        }
        return $resultResponse;
    }

    private function checkMethodForParams(): bool
    {
        $arrayWithoutDefaultParams = [];
        $arrayWithDefaultParams = [];

        foreach ($this->method->getParameters() as $param) {
            if (!$param->isDefaultValueAvailable()) {
                $arrayWithoutDefaultParams[$param->getName()] = $param->getName();
            }
            $arrayWithDefaultParams[$param->getName()] = $param->getName();
        }

        if (array_diff_key($arrayWithoutDefaultParams, $this->request->getParams())) {
            return false;
        }
        if (array_diff_key($this->request->getParams(), $arrayWithDefaultParams)) {
            return false;
        }

        return true;
    }
}