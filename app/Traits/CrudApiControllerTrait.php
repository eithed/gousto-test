<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Services\ApiService;

use App\Base;

trait CrudApiControllerTrait
{
    public function index(Request $request, \Closure $callback = null)
    {
        // create instance of the Querybuilder for given model
        $builder = static::$modelClass::query();
        
        // chain additional constraints based upon needs
        if ($callback) {
            $callback($builder);
        }

        $models = $builder->paginate(5);

        // use api service to transform output
        $apiService = new ApiService();
        return $apiService->transform($models, new static::$transformerClass());
    }

    public function show(Base $model, Request $request)
    {
        // use api service to transform output
        $apiService = new ApiService();
        return $apiService->transform($model, new static::$transformerClass());
    }

    public function store(Request $request, \Closure $callback = null)
    {
        // if service can be used to handle given model, use it
        if (!empty(static::$serviceClass) && class_exists(static::$serviceClass) && method_exists(static::$serviceClass, 'store'))
        {
            $service = new static::$serviceClass();
            $model = new static::$modelClass($request->all());

            $result = $service->store($model, $request);
        }
        // otherwise use default model operations
        else
        {
            $model = new static::$modelClass($request->all());

            $result = $model->save();
        }

        // chain additional operations based upon needs
        if (!empty($callback) && $result) {
            $result = $callback($model, $request);
        }

        return response()->json($result ? [
            'message' => sprintf("%s %s has been successfully saved", $model->singular, $model->id)
        ] : [
            'message' => sprintf("Could not save %s %s", $model->singular, $model->id)
        ]);
    }

    public function update(Base $model, Request $request, \Closure $callback = null)
    {
        // if service can be used to handle given model, use it
        if (!empty(static::$serviceClass) && class_exists(static::$serviceClass) && method_exists(static::$serviceClass, 'update'))
        {
            $service = new static::$serviceClass();
            
            $result = $service->update($model, $request);
        }
        // otherwise use default model operations
        else
        {
            // do not fill all attributes from request
            foreach($request->all() as $attribute => $value)
                if (in_array($attribute, $model->getFillable()))
                    $model->$attribute = $value;

            $result = $model->save();
        }

        // chain additional operations based upon needs
        if (!empty($callback) && $result) {
            $result = $callback($model, $request);
        }
            
        return response()->json($result ? [
            'message' => sprintf("%s %s has been successfully updated", $model->singular, $model->id)
        ] : [
            'message' => sprintf("Could not update %s %s", $model->singular, $model->id)
        ]);
    }

    public function destroy(Base $model, Request $request, \Closure $callback = null)
    {
        // if service can be used to handle given model, use it
        if (!empty(static::$serviceClass) && class_exists(static::$serviceClass) && method_exists(static::$serviceClass, 'delete'))
        {
            $service = new static::$serviceClass();
            
            $result = $service->delete($model, $request);
        }
        // otherwise use default model operations
        else
        {
            $result = $model->delete();
        }

        // chain additional operations based upon needs
        if (!empty($callback) && $result) {
            $result = $callback($model, $request);
        }
            
        return response()->json($result ? [
            'message' => sprintf("%s %s has been successfully deleted", $model->singular, $model->id)
        ] : [
            'message' => sprintf("Could not delete %s %s", $model->singular, $model->id)
        ]);
    }
}
