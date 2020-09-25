<?php

namespace App\Request;

/**
 * Allows creating a request based on a http method type.
 *
 * Class AbstractRequest
 *
 * @package App
 */
abstract class AbstractRequest
{
    protected const USER_AGENT_HEADER = 'User-agent: PHP-caller';

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $params;

    /**
     * AbstractRequest constructor.
     *
     * @param string $url
     * @param array  $params
     */
    public function __construct(string $url, array $params)
    {
        $this->url = $url;
        $this->params = $params;
    }

    /**
     * @return array
     */
    abstract public function send(): array;
}