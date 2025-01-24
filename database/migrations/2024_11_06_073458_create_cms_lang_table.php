<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_lang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('英文名称');
            $table->string('cn_name')->comment('中文名称');
            $table->boolean('status')->default(true)->comment('状态');
            $table->boolean('frontend_state')->default(true)->comment('前端状态');
            $table->integer('order')->default(0)->comment('排序');
            $table->json('extension')->nullable()->comment('扩展字段');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_lang');
    }
}
