<?php

namespace App\Admin\Repositories;

use App\Models\CmsLang as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CmsLang extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;


    /**
     * 以键值对形式获取所有语言信息
     * @return array|string
     */
    public static function getAll($key = null)
    {
        $array = Model::where('status', 1)->orderBy('order')->pluck('cn_name', 'name')->toArray();
        if (empty($key)) {
            return $array;
        } else {
            return Arr::get($array, $key);
        }
    }
}
