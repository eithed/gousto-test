<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Services\ApiService;

use App\Exceptions\ClassNotFoundException;

use App\Base;

trait CrudApiControllerTrait
{
    public function index(Request $request, \Closure $callback = null)
    {
        if (!isset($this->modelClass) || !class_exists($this->modelClass))
            throw new ClassNotFoundException();

        if (!isset($this->transformerClass) || !class_exists($this->transformerClass))
            throw new ClassNotFoundException();

        // create instance of the Querybuilder for given model
        $builder = $this->modelClass::query();
        
        // chain additional constraints based upon needs
        if ($callback) {
            $callback($builder);
        }

        $models = $builder->paginate(5);

        // use api service to transform output
        $apiService = new ApiService();
        return $apiService->transform($models, new $this->transformerClass());
    }

    public function show(Base $model, Request $request)
    {
        if (!isset($this->transformerClass) || !class_exists($this->transformerClass))
            throw new ClassNotFoundException();

        // use api service to transform output
        $apiService = new ApiService();
        return $apiService->transform($model, new $this->transformerClass());
    }

    public function store(Request $request, \Closure $callback = null)
    {
        if (!isset($this->modelClass) || !class_exists($this->modelClass))
            throw new ClassNotFoundException();

        // if service can be used to handle given model, use it
        if (isset($this->serviceClass) && class_exists($this->serviceClass) && method_exists($this->serviceClass, 'store'))
        {
            $service = new $this->serviceClass();
            $model = new $this->modelClass($request->all());

            $result = $service->store($model, $request);
        }
        // otherwise use default model operations
        else
        {
            $model = new $this->modelClass($request->all());

            $result = $model->save();
        }

        // chain additional operations based upon needs
        if (!empty($callback)) {
            $result = $callback($model, $request, $result);
        }

        // use api service to transform output
        return response()->json($result ? [
            'message' => sprintf("%s %s has been successfully saved", $model->singular, $model->id)
        ] : [
            'message' => sprintf("Could not save %s %s", $model->singular, $model->id)
        ]);
    }

    public function update(Base $model, Request $request, \Closure $callback = null)
    {
        if (!isset($this->modelClass) || !class_exists($this->modelClass))
            throw new ClassNotFoundException();

        // if service can be used to handle given model, use it
        if (isset($this->serviceClass) && class_exists($this->serviceClass) && method_exists($this->serviceClass, 'update'))
        {
            $service = new $this->serviceClass();
            
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
        if (!empty($callback)) {
            $result = $callback($model, $request, $result);
        }
            
        return response()->json($result ? [
            'message' => sprintf("%s %s has been successfully updated", $model->singular, $model->id)
        ] : [
            'message' => sprintf("Could not update %s %s", $model->singular, $model->id)
        ]);
    }

    public function destroy(Base $model, Request $request, \Closure $callback = null)
    {
        if (!isset($this->modelClass) || !class_exists($this->modelClass))
            throw new ClassNotFoundException();

        // if service can be used to handle given model, use it
        if (isset($this->serviceClass) && class_exists($this->serviceClass) && method_exists($this->serviceClass, 'delete'))
        {
            $service = new $this->serviceClass();
            
            $result = $service->delete($model, $request);
        }
        // otherwise use default model operations
        else
        {
            $result = $model->delete();
        }

        // chain additional operations based upon needs
        if (!empty($callback)) {
            $result = $callback($model, $request, $result);
        }
            
        return response()->json($result ? [
            'message' => sprintf("%s %s has been successfully deleted", $model->singular, $model->id)
        ] : [
            'message' => sprintf("Could not delete %s %s", $model->singular, $model->id)
        ]);
    }
}
