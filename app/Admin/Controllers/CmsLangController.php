<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\CmsLang as CmsLangRepo;
use App\Models\CmsLang;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Callout;

class CmsLangController extends AdminController
{
    protected function grid()
    {
        $row = new Row();
        $row->column(12, function (Column $column) {
            $callout = Callout::make('请先开启【后台状态】并在后台完成相关配置后，再打开【前端状态】', '注意事项')->primary();
            $column->row($callout);
        });
        $row->column(12, $this->_grid());
        return $row;
    }

    private function _grid()
    {
        return Grid::make(new CmsLangRepo(), function (Grid $grid) {
            $grid->model()->orderBy('order');
            $grid->disableActions();
            $grid->disableBatchActions();
            $grid->disableRowSelector();
            $grid->enableDialogCreate();

            $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
                $create->text('name');
                $create->text('cn_name');
                $create->select('status')->options(CmsLang::STATUSES)->default(true);
            });

            $grid->number();
            $grid->column('name');
            $grid->column('cn_name')->editable();
            $grid->column('status')->switch();
            $grid->column('frontend_state')->switch();
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
        return Form::make(new CmsLangRepo(), function (Form $form) {
            $form->text('name')->rules('required|unique:cms_lang');
            $form->text('cn_name')->rules('required');
            $form->switch('status')->rules(function (Form $form) {
                $status = $form->input('status');
                if (!is_null($status) && empty($status)) {
                    $count = CmsLang::where('status', 1)->count();
                    if ($count == 1) {
                        // 中断后续逻辑
                        $form->deleteInput('status');
                        $form->responseValidationMessages('status', '不能禁用所有语言');
                    }
                }
            });
            $form->switch('frontend_state');
            $form->hidden('order');

            $form->hidden('extension');
        });
    }
}
