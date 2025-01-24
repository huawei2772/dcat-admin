<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cms_friend_link', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称');
            $table->string('url')->comment('链接');
            $table->string('thumb')->nullable()->comment('缩略图');
            $table->string('lang')->default('')->comment('语言');
            $table->integer('order')->default(0)->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_friend_link');
    }
};
