<?php

declare ( strict_types = 1 );

namespace Mamco\Router;

class Route
{
    protected string $name;

    protected string $pattern;

    protected array $parameters;

    const MAP_PATTERN = [
        '#{int:([a-zA-Z\-]+)}#'    => '([0-9]+)',
        '#{string:([a-zA-Z\-]+)}#' => '([a-zA-Z]+)',
        '#{\*:([a-zA-Z\-]+)}#'     => '([0-9a-zA-Z\-]+)',
    ];

    /**
     * @param string $name
     * @param string $pattern
     * @param array  $parameters
     */
    public function __construct( string $name, string $pattern, array $parameters )
    {
        $this
            ->setName( $name )
            ->setPattern( $pattern )
            ->setParameters( $parameters )
        ;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return self
     */
    public function setName( string $name ): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of pattern
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Set the value of pattern
     *
     * @return self
     */
    public function setPattern( string $pattern ): self
    {
        $this->pattern = '/' . trim( $pattern, '/' );

        return $this;
    }

    /**
     * Get the value of parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Set the value of parameters
     *
     * @return self
     */
    public function setParameters( array $parameters ): self
    {

        if (
            ! isset( $parameters['_callback'] )
            || empty( $parameters['_callback'] )
        ) {
            throw new RouteException(
                "Invalid Parameters. parameters should have _callback key"
            );

        }

        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param  string   $path
     * @return string
     */
    public function getRegexPattern(): string
    {
        $pattern = '#^' . preg_replace( '#\/#', '\/', $this->pattern ) . '$#';

        foreach ( self::MAP_PATTERN as $map => $mapValue ) {
            $pattern = preg_replace( $map, $mapValue, $pattern );
        }

        return $pattern;
    }

}
