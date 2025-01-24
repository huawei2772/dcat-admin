<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'cms_pages';
    public $timestamps = false;

    protected $casts = [
        'keywords' => 'array',
        'extension' => 'array',
    ];

    const STATUS_SHOW = TRUE;
    const STATUS_HIDE = FALSE;

    const STATUSES = [
        self::STATUS_SHOW => '显示',
        self::STATUS_HIDE => '隐藏',
    ];
}
