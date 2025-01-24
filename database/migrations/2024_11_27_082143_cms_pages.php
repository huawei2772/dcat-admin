<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('link', 50);
            $table->string('thumbs')->comment('缩略图');
            $table->string('keywords')->comment('网页关键字');
            $table->string('description')->comment('描述');
            $table->string('lang', 20)->comment('语言');
            $table->text('content')->nullable()->comment('富文本内容');
            $table->json('extension')->nullable()->comment('扩展字段');
            $table->boolean('status')->default(true)->comment('状态');
            $table->unique(['link', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_pages');
    }
};
