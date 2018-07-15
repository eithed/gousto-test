<?php

namespace App\Http\Controllers;

use App\Traits\CrudControllerTrait;

class ApiController extends Controller
{
    static public $modelClass;
    static public $transformerClass;
    static public $serviceClass;
}
