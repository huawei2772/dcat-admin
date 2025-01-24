<?php

namespace App\Admin\Repositories;

use App\Models\CmsArticleContent as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class CmsArticleContent extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
