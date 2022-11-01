<?php
namespace App\Models\User;

use App\Base\BaseModel;

class UserResetPasswordToken extends BaseModel
{
    protected $table = "user_reset_password_tokens";

    protected $fillable = [
        "user_id",
        "token",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}