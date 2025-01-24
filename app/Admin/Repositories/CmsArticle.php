<?php

namespace App\Admin\Repositories;

use App\Models\CmsArticle as Model;
use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;

class CmsArticle extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public static function getRelationArticle($modelId, $resource)
    {
        $article = Model::find($modelId);
        $association_id = $article['association_id'];
        $models = Model::where('association_id', $association_id)
            ->whereNot('id', $article['id'])
            ->with(['category', 'language']);

        $lang = CmsLang::getAll();
        unset($lang[$article['lang']]);

        return Grid::make($models, function (Grid $grid) use ($resource, $lang, $modelId) {
            $grid->withBorder();
            $grid->setResource($resource);
            $grid->disableCreateButton();
            $grid->disableRefreshButton();
            $grid->disableRowSelector();
            $grid->disablePagination();

            $grid->setActionClass(Grid\Displayers\Actions::class);

            $grid->number();
            $grid->column('title');
            $grid->column('category.name');
            $grid->column('status')->switch();
            $grid->column('attr')->checkbox(Model::ATTRS);
            $grid->column('language.cn_name');
            $grid->column('updated_at');

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
