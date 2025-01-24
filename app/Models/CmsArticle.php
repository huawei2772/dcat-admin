<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property string $association_id 同一文章，不同语言的关联标识相同
 */
class CmsArticle extends Model implements Sortable
{
    use HasDateTimeFormatter, SortableTrait, SoftDeletes;

    protected $table = 'cms_article';

    protected $appends = [];

    protected array $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    const  STATUS_ENABLE = 1;
    const  STATUS_DISABLE = 0;

    const  STATUSES = [
        self::STATUS_ENABLE => '已发布',
        self::STATUS_DISABLE => '草稿'
    ];

    const ATTR_RECOMMEND = 1;

    const ATTRS = [
        self::ATTR_RECOMMEND => '推荐',
        2 => '置顶',
    ];

    protected $casts = [
        'thumbs' => 'array',
        'attachments' => 'array',
        'tags' => 'array',
        'attr' => 'array',
        'extension' => 'array',
    ];

    protected $attributes = [
        'extension' => '[]',
    ];

    public function content(): HasOne
    {
        return $this->hasOne(CmsArticleContent::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(CmsCategory::class, 'id', 'category_id');
    }

    public function language()
    {
        return $this->belongsTo(CmsLang::class, 'lang', 'name')->where('status', 1);
    }

    /**
     * 获取一张缩略图
     * @return string
     */
    public function getThumb(): string
    {
        $thumb = Arr::get($this->thumbs, 0);
        if ($thumb) {
            return Storage::url($thumb);
        }
        return '';
    }

    /**
     * 获取第一个附件
     * @return string
     */
    public function getAttachment()
    {
        $attachment = Arr::get($this->attachments, 0);
        if ($attachment) {
            return Storage::url($attachment);
        }
        return '';
    }

    /**
     * 获取缩略图
     * @return array
     */
    public function getThumbs()
    {
        $thumbs = [];
        foreach ($this->thumbs as $thumb) {
            $thumbs[] = Storage::url($thumb);
        }
        return $thumbs;
    }

    /**
     * 获取附件
     * @return array
     */
    public function getAttachments()
    {
        $attachments = [];
        foreach ($this->attachments as $attachment) {
            $attachments[] = Storage::url($attachment);
        }
        return $attachments;
    }
}
