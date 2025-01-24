<?php

namespace App\Admin\Controllers;

use App\Admin\Grid\Column\Filter\Json;
use App\Admin\Renderable\ArticleTable;
use App\Admin\Renderable\ThumbsTable;
use App\Admin\Repositories\CmsArticle as CmsArticleRepo;
use App\Admin\Repositories\CmsLang;
use App\Models\CmsArticle;
use App\Models\CmsCategory;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class CmsArticleController extends AdminController
{
    protected $translation = 'cms-article';

    public function __construct()
    {
        Admin::translation($this->translation);
    }

    abstract function getAlias();

    /**
     * 获取栏目
     */
    public function getColumn()
    {
        return CmsCategory::where('lang', $this->getCurrentLang())->where('alias', $this->getAlias())->first();
    }

    /**
     * 获取栏目ID
     */
    public function getColumnId()
    {
        return Arr::get($this->getColumn(), 'id');
    }

    /**
     * 获取当前页面配置语言
     * @return string
     */
    public function getCurrentLang()
    {
        return request('lang', user_admin_config('lang'));
    }

    /**
     * 获取分类选择选项
     * @return array
     */
    public function getCategorySelectOption()
    {
        $options = CmsCategory::selectOptionsCustom(function ($query) {
            return $query->whereIn('id', $this->getColumn()->getAllChildrenIds());
        }, $this->getColumnId());

        return $options;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $model = CmsArticle::where('column_id', $this->getColumnId())
            ->where('lang', user_admin_config('lang'))
            ->with('category');

        return Grid::make($model, function (Grid $grid) {
            $grid->fixColumns(2, -1);
            $grid->number();
            $grid->column('title');
            $grid->column('category.name')->filter(Grid\Column\Filter\In::make($this->getCategorySelectOption())->setColumnName('category_id'));
            $grid->column('status')->switch()->filter(Grid\Column\Filter\In::make(CmsArticle::STATUSES));
            $grid->column('attr')->checkbox(CmsArticle::ATTRS)->filter(Json::make(CmsArticle::ATTRS));
            $grid->column('thumbs')->display(function ($value) {
                return count($value) . '个';
            })->modal('缩略图', function ($grid) {
                return ThumbsTable::make(['thumbs' => $grid->row->getThumbs()]);
            });

            $grid->column('attachments')->display(function ($value) {
                return count($value) . '个';
            })->modal('附件', function ($grid) {
                return ThumbsTable::make(['attachments' => $grid->row->getAttachments()]);
            });


            $grid->column('lang')->display(function ($value) {
                return CmsLang::getAll($value);
            })->modal('关联文章', ArticleTable::make(['resource' => $grid->resource()]));

            $grid->column('updated_at')->sortable();

            $grid->quickSearch('title');
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        // 详情
        $detail = Show::make($id, CmsArticle::with(['category', 'content']), function (Show $show) {
            // 获取当前对象
            /** @var CmsArticle $model */
            $model = $show->model();

            $show->field('title');
            $show->field('desc');
            $show->field('category.name');
            $show->field('lang');
            $show->field('status')->using(CmsArticle::STATUSES);
            $show->field('content.content')->unescape();
            $show->field('tags')->label();
            $show->field('attr')->as(function ($attr) {
                $result = [];
                foreach ($attr as $v) {
                    $result[] = Arr::get(CmsArticle::ATTRS, $v);
                }
                return $result;
            })->label();
            $show->field('created_at');
            $show->field('updated_at');
            // 显示缩略图
            $show->field('thumbs')->as(function () use ($model) {
                return ThumbsTable::make(['thumbs' => $model->getThumbs()]);
            })->unescape();
            // 显示附件
            $show->field('attachments')->as(function () use ($model) {
                return ThumbsTable::make(['attachments' => $model->getAttachments()]);
            })->unescape();

            // 显示关联文章
            $resource = $show->resource();
            $show->html(function ($model) use ($resource) {
                return CmsArticleRepo::getRelationArticle($model['id'], $resource);
            });
        });

        // 当前语言关联的其他文章

        return $detail;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(CmsArticle::with(['content']), function (Form $form) {

            //添加其他语言版本时的提醒
            $sourceId = request('source_id');
            if ($sourceId) {
                $article = CmsArticle::find($sourceId);
                $lang = CmsLang::getAll($this->getCurrentLang());
                $html = "<div class=\"alert alert-primary alert-dismissable\"><i class=\"fa fa-exclamation-circle\"></i>正在创建【{$article['title']}】文章的【{$lang}版】</div>";
                $form->html($html);

                // 设置关联id
                $associationId = $article['association_id'];
            } else {
                $associationId = Str::orderedUuid();
            }

            $form->hidden('id');
            $options = $this->getCategorySelectOption();
            $help = $form->select('category_id')->options($options);
            if (empty($options)) {
                $help->help("未添加相关分类，现在去<a href='" . admin_url('cms/category') . "'>添加</a>");
            }

            $form->text('title')->required();
            $form->textarea('desc')->rows(2)->required();
            $form->multipleImage('thumbs')->move(date('Y/m/d'))->uniqueName();
            $form->multipleFile('attachments')->move(date('Y/m/d'))->uniqueName();
            $form->editor('content.content')->required();
            $form->hidden('association_id')->default($associationId);
            $form->hidden('lang')->default($this->getCurrentLang());
            $form->tags('tags');
            $form->checkbox('attr')->options(CmsArticle::ATTRS);
            $form->radio('status')->options(CmsArticle::STATUSES)->default(CmsArticle::STATUS_DISABLE);
            $form->hidden('column_id')->default($this->getColumnId());
        });
    }
}
