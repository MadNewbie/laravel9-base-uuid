<?php 
namespace App\Lookups\User\User;

use App\Base\BaseLookup;

class UserLookup extends BaseLookup
{
    // Constants - Type
    const TYPE_STATUS = 'type_status';

    // Constants - Value
    const TYPE_STATUS_NOT_YET = '10';
    const TYPE_STATUS_ACTIVE = '100';
    const TYPE_STATUS_NOT_ACTIVE = '200';

    // Item List
    public static function getItems()
    {
        return [
            self::TYPE_STATUS => [
                self::TYPE_STATUS_NOT_YET => 'Belum diaktifasi',
                self::TYPE_STATUS_ACTIVE => 'Aktif',
                self::TYPE_STATUS_NOT_ACTIVE => 'Non-Aktif', 
            ],
        ];
    }
}