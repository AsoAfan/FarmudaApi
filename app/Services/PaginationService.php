<?php

// app/Services/PaginationService.php

namespace App\Services;

//use Illuminate\Database\Schema\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PaginationService
{
    public function paginate(Builder|Collection $queryBuilder, array|string $relations = [])
    {

        $page = request()->query('page') ?? 0;
        $take = request()->query('limit') ?? 20;

        $skip = $page * $take;

        $data = $queryBuilder->skip($skip)->take($take + 1);

        if ($queryBuilder instanceof Builder) {
            $data = $data->with($relations)->get();
        }

//        return $queryBuilder->skip($skip)->take($take)->with($relations)->get();
        return $data;
    }
}
