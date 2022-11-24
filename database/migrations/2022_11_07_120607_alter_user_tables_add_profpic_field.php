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
        Schema::table(User::getTableName(), function(Blueprint $table) {
            $table->text('photo_filename')->after('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(User::getTableName(), function(Blueprint $table) {
            $table->dropColumn('photo_filename');
        });
    }
};
