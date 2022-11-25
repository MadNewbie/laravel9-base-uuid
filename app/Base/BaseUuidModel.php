<?php
namespace App\Base;

use App\Base\BaseModel;
use App\Base\Components\Uuid;

class BaseUuidModel extends BaseModel
{
    use Uuid;
}