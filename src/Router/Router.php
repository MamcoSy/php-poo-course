<?php

declare ( strict_types = 1 );

namespace Mamco\Router;

class Router
{
    protected array $routeCollection = [];

    public function __construct() {}

    /**
     * @param Route $route
     */
    public function register( Route $route )
    {
        $this->routeCollection[] = $route;
    }

    /**
     * @param string $url
     */
    public function process( string $url )
    {

        foreach ( $this->routeCollection as $route ) {

            if ( preg_match( $route->getRegexPattern(), $url, $matches ) ) {
                unset( $matches[0] );

                return call_user_func_array(
                    $route->getParameters()['_callback'],
                    $matches
                );
            }

        }

    }

}
