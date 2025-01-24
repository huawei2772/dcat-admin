<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CmsCategory extends Model
{
    use HasDateTimeFormatter, SoftDeletes, ModelTree;

    protected $table = 'cms_category';

    protected $titleColumn = 'name';

    protected $depthColumn = 'depth';

    const  STATUS_ENABLE = 1;
    const  STATUS_DISABLE = 0;

    const  STATUSES = [
        self::STATUS_ENABLE => '启用',
        self::STATUS_DISABLE => '禁用'
    ];

    /**
     * 是否启用
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->status == self::STATUS_ENABLE;
    }

    /**
     * 获取子级分类ID
     * @return array
     */
    public function getChildrenIds(): array
    {
        return $this->children()->pluck('id')->toArray();
    }

    /**
     * 父级分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * 子级分类
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * 递归获取所有子节点ID（包含子节点的子节点）
     * @return array
     */
    public function getAllChildrenIds(): array
    {
        $allIds = [];

        // 获取直接子节点
        $children = $this->children;

        foreach ($children as $child) {
            // 添加直接子节点ID
            $allIds[] = $child->id;
            // 递归获取子节点的子节点ID
            $allIds = array_merge($allIds, $child->getAllChildrenIds());
        }

        return array_unique($allIds);
    }

    /**
     * 自定义selectOptions
     * @param \Closure $closure
     * @param int $parentId
     * @return array
     */
    public static function selectOptionsCustom(\Closure $closure = null, $parentId = 0)
    {
        return (new static())->withQuery($closure)->buildSelectOptions([], $parentId, '', '&nbsp;');
    }
}
