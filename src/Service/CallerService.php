<?php

namespace App\Service;


/**
 * Class CallerService
 *
 * @package App\Service
 */
class CallerService
{
    private const ASC_ORDER = 'ASC',
        DESC_ORDER          = 'DESC';

    private const EQUAL_COMPARATOR = '=',
        NOT_EQUAL_COMPARATOR       = '!=',
        MORE_OR_EQUAL_COMPARATOR   = '>=',
        MORE_COMPARATOR            = '>',
        LESS_COMPARATOR            = '<',
        LESS_OR_MORE_COMPARATOR    = '<=',
        NULL_COMPARATOR            = 'null';

    /**
     *
     */
    private const AVAILABLE_ORDERS = [
        self::ASC_ORDER,
        self::DESC_ORDER
    ];

    /**
     * @param string          $filterField
     * @param string          $comparisonType
     * @param bool|int|string $value
     * @param array           $response
     *
     * @return array
     */
    public function filterByValueFromArray(string $filterField, string $comparisonType, $value, array $response): array
    {
        if ($this->isEmptyResponse($response)) {
            return $response;
        }

        if (!$this->isFieldValid($filterField, current($response))) {
            return $response;
        }

        switch ($comparisonType) {
            case self::EQUAL_COMPARATOR:
                $response = array_filter($response, function ($responsePart) use ($filterField, $value) {
                    return $responsePart[$filterField] === $value;
                });
                break;
            case self::NOT_EQUAL_COMPARATOR:
                $response = array_filter($response, function ($responsePart) use ($filterField, $value) {
                    return $responsePart[$filterField] !== $value;
                });
                break;
            case self::MORE_OR_EQUAL_COMPARATOR:
                $response = array_filter($response, function ($responsePart) use ($filterField, $value) {
                    return $responsePart[$filterField] >= $value;
                });
                break;
            case self::MORE_COMPARATOR:
                $response = array_filter($response, function ($responsePart) use ($filterField, $value) {
                    return $responsePart[$filterField] > $value;
                });
                break;
            case self::LESS_OR_MORE_COMPARATOR:
                $response = array_filter($response, function ($responsePart) use ($filterField, $value) {
                    return $responsePart[$filterField] <= $value;
                });
                break;
            case self::LESS_COMPARATOR:
                $response = array_filter($response, function ($responsePart) use ($filterField, $value) {
                    return $responsePart[$filterField] < $value;
                });
                break;
            case self::NULL_COMPARATOR:
                $response = array_filter($response, function ($responsePart) use ($filterField, $value) {
                    return is_null($responsePart[$filterField]);
                });
                break;
            default:
                return $response;
        }

        return $response;
    }

    /**
     * @param string $sortField
     * @param string $sortDirection
     * @param array  $response
     *
     * @return array
     */
    public function sortBy(string $sortField, string $sortDirection, array $response): array
    {
        if ($this->isEmptyResponse($response)) {
            return $response;
        }

        if (!$this->isFieldValid($sortField, current($response))) {
            return $response;
        }

        $this->validateSortDirection($sortDirection);

        usort($response, function($a, $b) use ($sortField, $sortDirection) {
            return ($sortDirection === self::DESC_ORDER)
                ? strtolower($b[$sortField]) <=> strtolower($a[$sortField])
                : strtolower($a[$sortField]) <=> strtolower($b[$sortField]);
        });

        return $response;
    }

    /**
     * Filter response array with provided $fields.
     *
     * @param array $fields
     * @param array $response
     *
     * @return array
     */
    public function showOnlySelectedFields(array $fields, array $response): array
    {
        if ($this->isEmptyResponse($response)) {
            return $response;
        }

        $filteredArray = [];
        foreach ($response as $responsePart) {
            $filteredResponsePart = [];
            foreach ($fields as $field) {
                if ($this->isFieldValid($field, $responsePart)) {
                    $filteredResponsePart[$field] = $responsePart[$field];
                }
            }
            if ($filteredResponsePart) {
                array_push($filteredArray, $filteredResponsePart);
            }
        }

        if (empty($filteredArray)) {
            return $response;
        }

        return $filteredArray;
    }

    /**
     * @param string $sortDirection
     */
    private function validateSortDirection(string &$sortDirection): void
    {
        $sortDirection = strtoupper($sortDirection);
        if (!in_array($sortDirection, self::AVAILABLE_ORDERS)) {
            $sortDirection = self::ASC_ORDER;
        }
    }

    /**
     * @param array $response
     *
     * @return bool
     */
    private function isEmptyResponse(array $response): bool
    {
        return empty($response);
    }

    /**
     * @param string $sortField
     * @param array  $availableFields
     *
     * @return bool
     */
    private function isFieldValid(string $sortField, array $availableFields): bool
    {
        return array_key_exists($sortField, $availableFields);
    }
}