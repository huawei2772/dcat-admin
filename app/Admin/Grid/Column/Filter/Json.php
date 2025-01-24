<?php

namespace App\Admin\Grid\Column\Filter;

use Dcat\Admin\Grid\Column\Filter\In;
use Dcat\Admin\Grid\Model;

/**
 * whereJsonContains 查询
 */
class Json extends In
{
    public function addBinding($value, Model $model)
    {
        if (empty($value)) {
            return;
        }

        $this->withQuery($model, 'whereJsonContains', [$value]);
    }
}