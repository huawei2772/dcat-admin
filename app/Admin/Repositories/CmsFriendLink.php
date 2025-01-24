<?php

namespace App\Admin\Repositories;

use App\Models\CmsFriendLink as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class CmsFriendLink extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
