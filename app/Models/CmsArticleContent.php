<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class CmsArticleContent extends Model
{
    protected $table = 'cms_article_content';

    public $timestamps = false;
    protected $primaryKey = 'cms_article_id';
}
