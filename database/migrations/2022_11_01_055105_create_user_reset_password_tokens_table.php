<?php

use App\Models\User\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reset_password_tokens', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->string('token');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on(User::getTableName())->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_reset_password_tokens');
    }
};
