<?php

namespace App\Request;

/**
 * Class RequestFactory
 *
 * @package App
 */
class RequestFactory
{
    public const GET_HTTP_METHOD = 'GET',
        POST_HTTP_METHOD         = 'POST',
        PUT_HTTP_METHOD          = 'PUT',
        DELETE_HTTP_METHOD       = 'DELETE';

    /**
     * @param string $url
     * @param string $httpMethod
     * @param array  $params
     *
     * @return DeleteRequest|GetRequest|PostRequest|PutRequest
     */
    public static function createRequest(string $url, string $httpMethod, array $params = []): AbstractRequest
    {
        switch (strtoupper($httpMethod)) {
            case self::GET_HTTP_METHOD:
                return new GetRequest($url, $params);
            case self::POST_HTTP_METHOD:
                return new PostRequest($url, $params);
            case self::PUT_HTTP_METHOD:
                return new PutRequest($url, $params);
            case self::DELETE_HTTP_METHOD:
                return new DeleteRequest($url, $params);
        }

        throw new \InvalidArgumentException();
    }
}
