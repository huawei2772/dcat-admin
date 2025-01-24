<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\CmsCategory as CmsCategoryRepo;
use App\Models\CmsCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Tree;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form as WidgetForm;

class CmsCategoryController extends AdminController
{
    public function index(Content $content): Content
    {
        return $content->header('类别')
            ->body(function (Row $row) {
                $row->column(7, $this->treeView());
                $row->column(5, $this->createForm());
            });
    }

    protected function treeView(): Tree
    {
        $tree = new Tree(new CmsCategoryRepo());
        $tree->query(function ($model) {
            return $model->where('lang', user_admin_config('lang'));
        });
        $tree->maxDepth(3);
        $tree->disableCreateButton();
        $tree->disableQuickCreateButton();
        $tree->branch(function ($branch) {
            /** @var CmsCategory $branch */
            $title = "{$branch['name']}";
            $aliasHtml = empty($branch['alias']) ? '' : "&nbsp;&nbsp;[<span class=\"text-primary\">{$branch['alias']}]</span>";
            $class = $branch->isEnable() ? 'primary' : 'danger';
            $statusName = CmsCategory::STATUSES[$branch['status']];
            $status = "<span class='label bg-{$class}'>{$statusName}</span>";
            return "<div class='pull-left' style='min-width:310px'>{$title}{$aliasHtml}</div>$status";
        });
        return $tree;
    }

    protected function createForm(): Box
    {
        $form = new WidgetForm();
        $form->action(admin_url('cms/category'));
        $form->select('parent_id')->options(CmsCategoryRepo::selectOptions())->required();
        $form->text('name')->required();
        $form->switch('status')->options(CmsCategory::STATUSES)->default(CmsCategory::STATUS_ENABLE);
        $form->hidden('lang')->value(user_admin_config('lang'));
        $form->text('alias')->help('要在左侧菜单栏展示，必填')->saveAsString();

        $form->width(8, 3);
        return Box::make(trans('admin.new'), $form);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(): Form
    {
        return Form::make(new CmsCategoryRepo(), function (Form $form) {
            $form->display('id');
            $form->select('parent_id')->options(CmsCategoryRepo::selectOptions());
            $form->text('name')->required();
            $form->switch('status')->options(CmsCategory::STATUSES)->default(CmsCategory::STATUS_ENABLE);
            $form->hidden('lang');
            $form->text('alias')->help('要在左侧菜单栏展示，必填')->saveAsString();
            $form->hidden('created_at');
            $form->hidden('updated_at');
        });
    }
}
