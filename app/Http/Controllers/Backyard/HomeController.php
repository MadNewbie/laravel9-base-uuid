<?php
namespace App\Http\Controllers\Backyard;

use App\Base\BaseController;

class HomeController extends BaseController
{
    public static $partName = 'backyard';

    public function __construct()
    {
        $this->middleware('is_verify_email');
        $this->middleware('permission:' . self::getRoutePrefix('home'),['only' => 'index']);
    }

    public function index(){
        return self::makeView('home');
    }
}