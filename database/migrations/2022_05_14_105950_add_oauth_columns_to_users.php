<?php

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
        Schema::table('users', function (Blueprint $table) {
            // $table->string('oauth_id')->nullable();
            // $table->string('oauth_type')->nullable();
            // $table->string('token')->nullable();
            $table->string('oauth_google_id')->nullable();
            $table->string('oauth_github_id')->nullable();
            $table->string('google_token')->nullable();
            $table->string('github_token')->nullable();
        });
    }

};
