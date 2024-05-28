<?php
declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Contracts\FormRequest;
use App\Core\Http\API\Filter\FilterInterface;
use App\Core\Http\API\Response\PaginatedResponse;


interface BaseRepository{
    public function search(FilterInterface $filter):PaginatedResponse;
    public function create(FormRequest $data):mixed;
    public function Update(FormRequest $data):mixed;
}