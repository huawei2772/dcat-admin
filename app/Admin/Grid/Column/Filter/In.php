<?php

namespace App\Admin\Grid\Column\Filter;

use Dcat\Admin\Grid\Column\Filter;
use Dcat\Admin\Grid\Model;

class In extends Filter
{
    use Checkbox;

    /**
     * @var array
     *  eg: $group = [
     *         [
     *         'label' => 'xxxx',
     *         'options' => [
     *             1 => 'foo',
     *             2 => 'bar',
     *             ...
     *         ],
     *         ...
     *      ]
     */
    protected $group = [];

    /**
     * CheckFilter constructor.
     *
     * @param array $group
     */
    public function __construct(array $group)
    {
        $this->group = $group;

        $this->class = [
            'all' => uniqid('column-filter-all-'),
            'item' => uniqid('column-filter-item-'),
        ];
    }

    /**
     * Add a binding to the query.
     *
     * @param array $value
     * @param Model $model
     */
    public function addBinding($value, Model $model)
    {
        if (empty($value)) {
            return;
        }

        $this->withQuery($model, 'whereIn', [$value]);
    }

    /**
     * Render this filter.
     *
     * @return string
     */
    public function render()
    {
        return $this->renderCheckbox();
    }
}
