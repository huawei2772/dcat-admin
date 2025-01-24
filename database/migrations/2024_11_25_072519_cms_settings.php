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
        Schema::create('cms_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 50);
            $table->string('value');
            $table->string('lang', 20)->comment('语言');
            $table->unique(['key', 'lang']);
        });

        Schema::create('cms_setting_key', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->unique()->comment('key名称');
            $table->string('label', 50)->comment('label显示名称');
            $table->string('type')->comment('类型');
            $table->string('group')->comment('分组');
            $table->unsignedInteger('order')->comment('排序');
            $table->boolean('status')->default(true)->comment('状态');
            $table->boolean('is_multilingual')->default(true)->comment('是否支持多语言,400电话为false');
            $table->string('help', 200)->default('')->comment('提示文档');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_setting');
        Schema::dropIfExists('cms_setting_key');
    }
};
