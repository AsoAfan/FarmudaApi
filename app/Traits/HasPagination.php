<?php

namespace App\Traits;

trait HasPagination
{

    public function paginateQuery($queryBuilder)
    {
        $page = request()->query('page') ?? 0;
        $take = request()->query('limit') ?? 10;

        $skip = $page * $take;

        return $queryBuilder->skip($skip)->take($take)->get();
    }
}