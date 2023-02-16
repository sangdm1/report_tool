<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', config('constants.user_roles'))->nullable()->default(null);
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('google_id')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
            $table->enum('status', ['active', 'inactive'])->default('active');
        });

        DB::table('users')->insert(['role' => '1', 'name' => 'Admin', 'display_name' => 'Admin', 'email' => 'admin@runsystem.net', 'password'=> Hash::make(env('ADMIN_PASSWORD'))]);

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
};
