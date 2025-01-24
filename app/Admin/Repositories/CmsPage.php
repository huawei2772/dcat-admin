<?php

namespace App\Admin\Repositories;

use App\Models\CmsPage as Model;
use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;

class CmsPage extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public static function getRelationPage($modelId, $resource)
    {
        $page = Model::find($modelId);
        $models = Model::where('link', $page['link'])
            ->whereNot('id', $page['id']);

        $lang = CmsLang::getAll();
        unset($lang[$page['lang']]);

        return Grid::make($models, function (Grid $grid) use ($resource, $lang, $modelId) {
            $grid->withBorder();
            $grid->setResource($resource);
            $grid->disableCreateButton();
            $grid->disableRefreshButton();
            $grid->disableRowSelector();
            $grid->disablePagination();
            $grid->disableDeleteButton();

            $grid->setActionClass(Grid\Displayers\Actions::class);

            $grid->number();
            $grid->column('name');
            $grid->column('link');
            $grid->column('thumbs')->image();
            $grid->column('status')->switch();
            // $grid->column('lang')->display(function ($value) use ($lang) {
            //     return $lang[$value];
            // });

            // 展示该文章可能需要添加的语言版本
            $grid->footer(function ($collection) use ($grid, $lang, $modelId) {
                $collection->each(function (Model $article) use ($grid, &$lang) {
                    if (array_key_exists($article['lang'], $lang)) {
                        unset($lang[$article['lang']]);
                    }
                });

                if (isset($lang) && $lang) {
                    $html = [];
                    $new = trans('admin.new');
                    foreach ($lang as $k => $v) {
                        $grid->model()->setConstraints(['lang' => $k, 'source_id' => $modelId]);
                        $url = $grid->getCreateUrl();
                        $html[] = "<a href='{$url}' class='btn btn-primary'><span class='d-none d-sm-inline'>&nbsp;&nbsp;{$new} {$v}</span></a>";
                    }
                    $tip = trans('admin.added_other_language_versions');
                    return "<div class='pull-right'><span class='d-none d-sm-inline'>{$tip}&nbsp;&nbsp;</span>" . implode("\n\r", $html) . "</div>";
                } else {
                    return '';
                }
            });
        });
    }
}
