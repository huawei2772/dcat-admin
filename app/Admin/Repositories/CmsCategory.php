<?php

namespace App\Admin\Repositories;

use App\Models\CmsCategory as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class CmsCategory extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    /**
     * 获取对应语言的select options
     *
     * @return array
     */
    public static function selectOptions(): array
    {
        return Model::selectOptions(function ($model) {
            return $model->where('lang', user_admin_config('lang'));
        });
    }
}
