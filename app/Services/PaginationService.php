<?php

// app/Services/PaginationService.php

namespace App\Services;

class PaginationService
{
    public function paginate($queryBuilder)
    {

        $page = request()->query('page') ?? 0;
        $take = request()->query('limit') ?? 20;

        $skip = $page * $take;

        return $queryBuilder->skip($skip)->take($take)->get();
    }
}
