<?php

namespace App\Services;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item as FractalItem;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Collection as Collection;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Pagination\AbstractPaginator as Paginator;

class ApiService
{
    public function __construct()
    {
        $this->fractal = new Manager();
    }

    public function transform($model, $transformer)
    {
        if ($model instanceof Model)
        {
            $resource = new FractalItem($model, $transformer);
            $data = $this->fractal->createData($resource)->toArray();
        }
        elseif ($model instanceof Collection)
        {
            $resource = new FractalCollection($model, $transformer);
            $data = $this->fractal->createData($resource)->toArray();
        }
        elseif ($model instanceof Paginator)
        {
            $resource = new FractalCollection($model->getCollection(), $transformer);
            $resource->setPaginator(new IlluminatePaginatorAdapter($model));
            $data = $this->fractal->createData($resource)->toArray();
        }

        return response()->json($data);
    }
}
