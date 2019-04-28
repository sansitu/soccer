<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->collation('utf8_unicode_ci');
            $table->string('email')->unique()->collation('utf8_unicode_ci');
            $table->boolean('email_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->collation('utf8_unicode_ci');
            $table->rememberToken()->collation('utf8_unicode_ci');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
