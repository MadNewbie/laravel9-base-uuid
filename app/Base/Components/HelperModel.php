<?php

namespace App\Base\Components;

trait HelperModel
{
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}