<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("unique_id");
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('platform_id')->nullable()->references('id')->on('platforms')->nullOnDelete();
            $table->foreignId('subscription_id')->nullable()->references('id')->on('subscriptions')->nullOnDelete();
            $table->index('user_id');
            $table->index('platform_id');
            $table->index('subscription_id');
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
        Schema::dropIfExists('apps');
    }
};
