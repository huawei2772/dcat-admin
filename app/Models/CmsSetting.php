<?php

namespace App\Models;

use App\Helpers\SettingHelper;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class CmsSetting extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'cms_setting';
    public $timestamps = false;

    protected $fillable = ['key', 'value', 'lang'];

    protected static function booted(): void
    {
        static::saved(function () {
            SettingHelper::clearCache();
        });
        static::deleted(function () {
            SettingHelper::clearCache();
        });
    }
}
