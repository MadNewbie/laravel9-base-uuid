<?php
namespace App\Libraries\Mad;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Helper
{
    public static function renderMenus($tmpMenus)
    {
        $menus = $tmpMenus;
        $curRouteName = Route::currentRouteName();
        $arrCurRouteName = explode('.',$curRouteName);

        ob_start();
        foreach($menus as $menu){
            $menu = (object) $menu;?>
            <?php if(Auth::user()->checkPermissionTo($menu->route)):?>
            <?php 
                $active = '';
                if(count($arrCurRouteName) <= 3) {
                    $active = strcmp($curRouteName, $menu->route) == 0 ? 'active' : '';
                } else {
                    if (isset($menu->model)) {
                        $active = strcmp($arrCurRouteName[2], $menu->model) == 0 ? 'active' : '';
                    }
                }
            ?>
            <li class="nav-item">
                <a href="<?= route($menu->route) ?>" class="nav-link <?= $active ?>">
                    <i class="nav-icon <?= $menu->type_icon ?> fa-<?= $menu->icon ?>"></i>
                    <p>
                        <?= $menu->title ?>
                    </p>
                </a>
            </li>
            <?php endif; ?>
        <?php }
        return ob_get_clean();
    }

    public static function renderModule($tmpModules, $tmpModuleName)
    {
        $moduleName = $tmpModuleName;
        $modules = $tmpModules;
        ob_start();
        foreach($modules as $module){
            $module = (object) $module;
            ?>
            <?php if(Auth::user()->checkPermissionTo("backyard.$module->name.home")):?>
                <li class="nav-item d-none d-sm-inline-block <?= strcmp($moduleName, $module->name) == 0 ? 'active' : ''?>">
                    <a href='<?=route("backyard.$module->name.home")?>' class="nav-link">
                        <i class='<?="$module->type_icon fa-$module->icon"?>'></i>
                        <?=$module->title?>
                    </a>
                </li>
            <?php endif;?>
        <?php }
        return ob_get_clean();
    }

    public static function fluentMultiSearch($rootQuery, $searchString, $fieldsCommaSeparated)
    {
        $string = explode(' ', str_replace('  ',' ',$searchString));
        if(is_string($fieldsCommaSeparated)){
            $fields = explode(',',$fieldsCommaSeparated);
        } else {
            $fields = $fieldsCommaSeparated;
        }
        $rootQuery->where(function() use ($rootQuery, $string, $fields) {
            foreach($string as $v){
                $rootQuery->where(function ($andQuery) use ($rootQuery, $fields, $v){
                    foreach($fields as $w){
                        $andQuery->orWhere($w, 'LIKE', "%{$v}%");
                    }
                });
            }
        });
        return $rootQuery;
    }

    public static function createSelect($data, $label, $id = 'id')
    {
        $res = array();
        foreach($data as $v){
            $tmp = false;
            $tmp = gettype($label) === 'object' && get_class($label) === 'Closure' ? $label($v) : $v->label;
            $tmpId = gettype($id) === 'object' && get_class($id) === 'Closuer' ? $id($v) : $v->id;
            $res[$tmpId] = $tmp;
        }
        return $res;
    }
}