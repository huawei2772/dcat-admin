<?php

namespace App\Admin\Repositories;

use App\Models\CmsSettingKey as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class CmsSettingKey extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
