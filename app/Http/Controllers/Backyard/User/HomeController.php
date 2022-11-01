<?php
namespace App\Http\Controllers\Backyard\User;

use App\Base\BaseController;

class HomeController extends BaseController
{
    public static $partName = 'backyard';
    public static $moduleName = 'user';

    public function __construct()
    {
        $this->middleware('is_verify_email');
    }

    public function index()
    {
        return self::makeView('home');
    }
}