<?php

namespace Splash\Http;

abstract class BaseController
{
    
    protected $middleware = [];


    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    public function __call($method, $parameters)
    {
        echo "Method [{$method}] does not exist on [".get_class($this).'].';
    }

   
    public function middleware($middleware, array $options = [])
    {
        $this->middleware[$middleware] = $options;
    }

    
    public function getMiddlewareForMethod($method)
    {
        $middleware = [];

        foreach ($this->middleware as $name => $options) {
            if (isset($options['only']) && ! in_array($method, (array) $options['only'])) {
                continue;
            }

            if (isset($options['except']) && in_array($method, (array) $options['except'])) {
                continue;
            }

            $middleware[] = $name;
        }

        return $middleware;
    }
}
