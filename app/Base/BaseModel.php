<?php
namespace App\Base;

use App\Base\Components\HelperModel;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HelperModel;
}