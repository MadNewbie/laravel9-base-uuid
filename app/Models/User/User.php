<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Base\Components\HelperModel;
use App\Base\Components\Uuid;
use App\Traits\User\User\TraitTypeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HelperModel, TraitTypeStatus, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'type_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isDeveloper()
    {
        $roles = json_decode(json_encode($this->getRoleNames()));
        return is_numeric(array_search('Developer', $roles));
    }

    public function modifiedSyncRole($roles)
    {
        $userId = $this->id;
        $userModel = get_class($this);
        $res = true;
        
        $userRoleTableName = config("permission.table_names.model_has_roles");
        $roleIdColumnName = config("permission.column_names.role_pivot_key")?:"role_id";
        $userIdColumnName = config("permission.column_names.model_morph_key")?:"model_id";
        $modelTypeColumnName = "model_type";

        DB::beginTransaction();
        if(DB::table($userRoleTableName)->where($userIdColumnName, "=", $userId)->count() != 0){
            $res &= DB::table($userRoleTableName)->where($userIdColumnName, "=", $userId)->delete();
        }

        foreach($roles as $role){
            $res &= DB::table($userRoleTableName)
                ->insert([
                    $roleIdColumnName => $role,
                    $userIdColumnName => $userId,
                    $modelTypeColumnName => $userModel
                ]);
        }
        $res ? DB::commit() : DB::rollback();
    }
}
