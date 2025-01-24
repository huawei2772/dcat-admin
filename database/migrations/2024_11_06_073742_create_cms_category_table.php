<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->default('0')->comment('父ID');
            $table->integer('order')->default('0')->comment('排序');
            $table->string('name')->default('')->comment('名称');
            $table->string('lang')->default('')->comment('语言');
            $table->tinyInteger('depth')->default(1)->comment('深度');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->string('alias', 100)->default('')->comment('别名');
            $table->json('extension')->nullable()->comment('扩展字段');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_category');
    }
}
