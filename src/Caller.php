<?php

namespace App;

use App\Request\RequestFactory;
use App\Service\CallerService;

/**
 * Class Caller
 *
 * @package App
 */
class Caller
{
    /**
     * @var $response
     */
    private $response;

    /**
     * @var CallerService
     */
    private $service;

    /**
     * Caller constructor.
     */
    public function __construct()
    {
        $this->service = new CallerService();
    }

    /**
     * @param string $url
     * @param string $httpMethod
     * @param array  $params
     *
     * @return $this
     */
    public function make(string $url, string $httpMethod, array $params = []): Caller
    {
        $request = RequestFactory::createRequest($url, $httpMethod, $params);
        $this->response = $request->send();

        return $this;
    }

    /**
     * @param string          $field
     * @param string          $comparisonType
     * @param bool|int|string $value
     *
     * @return $this
     */
    public function where(string $field, string $comparisonType, $value): Caller
    {
        $this->response = $this->service->filterByValueFromArray($field, $comparisonType, $value, $this->response);

        return $this;
    }

    /**
     * @param string $sortField
     * @param string $sortDirection
     *
     * @return $this
     */
    public function sort(string $sortField, string $sortDirection): Caller
    {
        $this->response = $this->service->sortBy($sortField, $sortDirection, $this->response);

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->response;
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    public function only(array $fields = []): array
    {
        if (empty($fields)) {
            return $this->response;
        }

        return $this->service->showOnlySelectedFields($fields, $this->response);
    }
}