<?php

namespace App\Models;

use App\Helpers\SettingHelper;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class CmsSettingKey extends Model implements Sortable
{
    use HasDateTimeFormatter;
    use SortableTrait;

    protected array $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'order',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];

    protected $table = 'cms_setting_key';
    public $timestamps = false;

    const TYPE_TEXT = 1;
    const TYPE_TEXTAREA = 2;
    const TYPE_IMAGE = 3;
    const TYPE_FILE = 4;

    const TYPES = [
        self::TYPE_TEXT => '文本',
        self::TYPE_TEXTAREA => '多行文本',
        self::TYPE_IMAGE => '图片',
        self::TYPE_FILE => '文件',
    ];

    const GROUP_WEB = 1;
    const GROUP_COMPANY = 2;
    const GROUP_OTHER = 10;

    const GROUPS = [
        self::GROUP_WEB => '网站信息',
        self::GROUP_COMPANY => '公司信息',
        self::GROUP_OTHER => '其他',
    ];

    const STATUS_SHOW = TRUE;
    const STATUS_HIDE = FALSE;

    const STATUSES = [
        self::STATUS_SHOW => '显示',
        self::STATUS_HIDE => '隐藏',
    ];

    // 支持多言语
    const MULTILINGUAL_TRUE = TRUE;

    // 不支持多语言
    const MULTILINGUAL_FALSE = FALSE;

    const MULTILINGUAL = [
        self::MULTILINGUAL_TRUE => '是',
        self::MULTILINGUAL_FALSE => '否',
    ];

    protected $fillable = ['name', 'label', 'type', 'group', 'help', 'status'];

    protected $casts = [
        'help' => 'string'
    ];

    protected static function booted(): void
    {
        static::saved(function ($model) {
            // 更新模型才需要处理事项
            if (!$model->wasRecentlyCreated) {
                // 只要没有['name', 'status', 'is_multilingual']这三个字段的修改，就不需要处理
                $updateKey = array_keys($model->getChanges());
                if (!empty(array_intersect(['name', 'status', 'is_multilingual'], $updateKey))) {
                    $name = $model->getOriginal('name');
                    // 删除cms-setting表中的数据
                    CmsSetting::where('key', $name)->delete();
                }
            }
            SettingHelper::clearCache();
        });
        static::deleted(function () {
            SettingHelper::clearCache();
        });
    }
}
