<?php
namespace App\Models\User;

use App\Base\BaseModel;

class UserVerifyToken extends BaseModel
{
    protected $table = "user_verify_tokens";

    protected $fillable = [
        "user_id",
        "token",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}