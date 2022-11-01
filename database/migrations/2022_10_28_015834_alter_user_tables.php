<?php

use App\Models\User\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('username')->after('name')->nullable();
            $table->unsignedTinyInteger('type_status')->after('email')->nullable();
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
            $table->dropColumn('username');
        });
    }
};
