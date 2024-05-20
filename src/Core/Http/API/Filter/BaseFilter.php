<?php

declare(strict_types=1);

namespace App\Core\Http\API\Filter;

use DateTime;

class BaseFilter
{
    private const PAGE = 1;
    private const  LIMIT = 30;
    private const VALID_SORT = [
        'name',
        'id'
    ];

    private const VALID_ORDER = [
        'asc',
        'desc'
    ];

    public readonly int $page;
    public readonly int $limit;

    public function __construct(int $page, int $limit)
    {
        if (0 !== $page) {
            $this->page = $page;
        } else {
            $this->page = self::PAGE;
        }
        if (0 !== $limit) {
            $this->limit = $limit;
        } else {
            $this->limit = self::LIMIT;
        }
    }


    protected function validateSort(string $sort): void
    {
        if (!in_array($sort, self::VALID_SORT, true)) {
            throw new \InvalidArgumentException(sprintf(sprintf("Invalid sort parameter")));
        }
    }

    protected function validateOrder(string $order): void
    {
        if (!in_array($order, self::VALID_ORDER, true)) {
            throw new \InvalidArgumentException(sprintf(sprintf("Invalid order parameter")));
        }
    }


    protected function checkValidDate(?string $date): void
    {
        if (null !== $date) {
            if (false === DateTime::createFromFormat('Y-m-d', $date)) {
                throw new \InvalidArgumentException("Invalid date format");
            }
        }
    }
}
