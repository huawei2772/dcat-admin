<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\CmsFriendLink;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CmsFriendLinkController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CmsFriendLink(), function (Grid $grid) {
            $grid->model()->orderBy('order');

            $grid->disableViewButton();
            $grid->disableRefreshButton();
            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->disableRowSelector();
            $grid->enableDialogCreate();
            $grid->setActionClass(Grid\Displayers\Actions::class);

            $grid->number();
            $grid->column('name');
            $grid->column('url');
            $grid->column('thumb')->image('', 200, 50);
            // $grid->column('lang');
            $grid->column('order')->orderable();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new CmsFriendLink(), function (Form $form) {
            $form->text('name');
            $form->text('url');
            $form->image('thumb')->url('file/upload')->autoUpload();
            $form->hidden('lang')->default(user_admin_config('lang'));
        });
    }
}
