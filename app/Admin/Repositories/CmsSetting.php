<?php

namespace App\Admin\Repositories;

use App\Models\CmsSetting as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class CmsSetting extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

}
