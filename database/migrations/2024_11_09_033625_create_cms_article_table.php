<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_article', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('column_id')->index()->comment('栏目');
            $table->string('title')->default('')->comment('标题');
            $table->string('desc', 200)->default('')->comment('简介');
            $table->json('thumbs')->nullable()->comment('缩略图');
            $table->json('attachments')->nullable()->comment('附件');
            $table->unsignedInteger('category_id')->index()->comment('分类');
            $table->unsignedInteger('order')->index()->comment('排序');
            $table->string('lang')->index()->default('')->comment('语言');
            $table->unsignedInteger('views')->default(0)->comment('浏览量');
            $table->unsignedTinyInteger('status')->comment('状态');
            $table->json('attr')->nullable()->comment('属性');
            $table->json('tags')->nullable()->comment('标签');
            $table->char('association_id', 36)->index()->nullable()->comment('关联标识');// 同一文章，不同语言的关联标识相同
            $table->json('extension')->nullable()->comment('扩展字段');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('cms_article_content', function (Blueprint $table) {
            $table->unsignedInteger('cms_article_id');
            $table->text('content');
            $table->primary('cms_article_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_article');
        Schema::dropIfExists('cms_article_content');
    }
}
