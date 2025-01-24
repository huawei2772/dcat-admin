<?php

namespace App\Models;

use App\Helpers\LangHelper;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class CmsLang extends Model implements Sortable
{
    use HasDateTimeFormatter, SortableTrait;

    protected $table = 'cms_lang';

    protected $primaryKey = 'name';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = ['name', 'cn_name', 'status', 'extension'];

    protected array $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    const  STATUSES = [
        1 => '启用',
        0 => '停用',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            LangHelper::clearCache();
        });
        static::deleted(function () {
            LangHelper::clearCache();
        });
    }
}
