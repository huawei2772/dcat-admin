<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\CmsSettingKey as CmsSettingKeyRepo;
use App\Models\CmsSettingKey;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CmsSettingKeyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CmsSettingKeyRepo(), function (Grid $grid) {
            $grid->model()->orderBy('order');
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableRefreshButton();
            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->disableRowSelector();
            $grid->enableDialogCreate();
            $grid->setActionClass(Grid\Displayers\Actions::class);

            $grid->number();
            $grid->column('name');
            $grid->column('label');
            $grid->column('type')->using(CmsSettingKey::TYPES);
            $grid->column('group')->using(CmsSettingKey::GROUPS);
            $grid->column('status')->switch();
            $grid->column('is_multilingual')->switch();
            $grid->column('help');
            $grid->order->orderable();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new CmsSettingKeyRepo(), function (Form $form) {
            $form->width(7,3);
            $form->text('name');
            $form->text('label');
            $form->text('help')->saveAsString();
            $form->radio('type')->options(CmsSettingKey::TYPES)->default(CmsSettingKey::TYPE_TEXT);
            $form->radio('group')->options(CmsSettingKey::GROUPS);
            $form->radio('status')->options(CmsSettingKey::STATUSES)->default(CmsSettingKey::STATUS_SHOW);
            $form->radio('is_multilingual')->options(CmsSettingKey::MULTILINGUAL)
                ->default(CmsSettingKey::MULTILINGUAL_TRUE)
                ->help('例如400电话、email这类的不需要支持多语言');
        });
    }
}
