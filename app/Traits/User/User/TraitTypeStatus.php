<?php
namespace App\Traits\User\User;

use App\Lookups\User\User\UserLookup;

trait TraitTypeStatus
{
    public function getTypeStatus()
    {
        return UserLookup::item(UserLookup::TYPE_STATUS, $this->type_status);
    }

    public static function getTypeStatusList()
    {
        return UserLookup::items(UserLookup::TYPE_STATUS);
    }

    public function isTypeStatusNotYet()
    {
        return $this->type_status == UserLookup::TYPE_STATUS_NOT_YET;
    }

    public function isTypeStatusActive()
    {
        return $this->type_status == UserLookup::TYPE_STATUS_ACTIVE;
    }

    public function isTypeStatusNotActive()
    {
        return $this->type_status == UserLookup::TYPE_STATUS_NOT_ACTIVE;
    }

    public function getTypeStatusBadge()
    {
        $class = '';

        switch($this->type_status){
            case UserLookup::TYPE_STATUS_ACTIVE:
                $class = 'success';
                break;
            case UserLookup::TYPE_STATUS_NOT_YET:
                $class = 'secondary';
                break;
            
            default:
                $class = 'danger';
                break;
        }

        return sprintf(
            '<span class="badge badge-%s">%s</span>',
            $class,
            $this->getTypeStatus()
        );
    }
}