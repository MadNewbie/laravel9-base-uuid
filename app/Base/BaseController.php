<?php

namespace App\Base;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected static $partName = null;
    protected static $moduleName = null;
    protected static $modelName = null;

    public static function getModelInfo()
    {
        return [
            'partName' => static::$partName,
            'moduleName' => static::$moduleName,
            'modelName' => static::$modelName,
            'routePrefix' => static::getRoutePrefix(),
            'modelPrefix' => static::getModelPrefix(),
        ];
    }

    public static function getRoutePrefix($route = null)
    {
        $routePrefix = [];

        if (isset(static::$partName)) {
            $routePrefix[] = static::$partName;
        }

        if (isset(static::$moduleName)) {
            $routePrefix[] = static::$moduleName;
        }

        if (isset(static::$modelName)) {
            $routePrefix[] = static::$modelName;
        }

        if (isset($route)) {
            $routePrefix[] = $route;
        }

        $routePrefix = implode(".", $routePrefix);

        return $routePrefix;
    }

    public static function getModelPrefix()
    {
        $modelPrefix = [];

        if (isset(static::$partName)) {
            $modelPrefix[] = static::$partName;
        }

        if (isset(static::$moduleName)) {
            $modelPrefix[] = static::$moduleName;
        }

        if (isset(static::$modelName)) {
            $modelPrefix[] = static::$modelName;
        }

        $modelPrefix = implode(".", $modelPrefix);

        return $modelPrefix;
    }

    public static function makeView($view, $data = [], $mergeData = [])
    {
        $data+=static::getModelInfo();

        $pathView = [];

        if(isset(static::$partName)){
            $pathView[] = static::$partName;
        }

        if(isset(static::$moduleName)){
            $pathView[] = static::$moduleName;
        }

        if(isset(static::$modelName)){
            $pathView[] = static::$modelName;
        }

        $pathView[] = $view;

        $pathView = implode(".",$pathView);

        return view($pathView, $data, $mergeData);
    }
}