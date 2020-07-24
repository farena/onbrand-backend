<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponseTrait
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection,
                               $searchable = true,
                               $sortable = true,
                               $filterable = true,
                               $code = 200)
    {
        if ($collection->isEmpty() || count($collection) == 0)
            return $this->successResponse(['data' => $collection], $code);

        if ($filterable) $collection = $this->filterData($collection);
        if ($searchable) $collection = $this->searchData($collection);
        if ($sortable) $collection = $this->sortData($collection);
        $collection = $this->paginate($collection);

        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse(['data' => $instance], $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function filterData(Collection $collection)
    {
        foreach (request()->query() as $attribute => $value) {
            if (!in_array($attribute, ['search', 'sortBy', 'sortByDesc', 'per_page', 'page', 'date_col']))
                $collection = $collection->where($attribute, $value);
        }
        return $collection;
    }

    protected function searchData(Collection $collection)
    {
        foreach (request()->query() as $attribute => $value) {
            if ($attribute == 'search') {
                $keys = array_keys($collection[0]->getAttributes());

                $collection = $collection->filter(function ($item) use ($keys, $value) {
                    $valid = false;
                    foreach ($keys as $key) {
                        if (preg_match("/" . $value . "/i", $item->$key)) $valid = true;
                    }
                    return $valid;
                });

            }
        }
        return $collection;
    }

    protected function sortData(Collection $collection)
    {
        if (request()->has('sortBy')) {
            $collection = $collection->sortBy(request()->sortBy);
        }
        if (request()->has('sortByDesc')) {
            $collection = $collection->sortByDesc(request()->sortByDesc);
        }
        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2',
        ];

        Validator::validate(request()->all(), $rules);
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        if (request()->has('per_page')) {
            $perPage = (int)request()->per_page;
        }
        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        $paginated->appends(request()->all());
        return $paginated;
    }

}
