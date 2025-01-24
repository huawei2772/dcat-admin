<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\PageTable;
use App\Admin\Repositories\CmsLang;
use App\Admin\Repositories\CmsPage as CmsPageRepo;
use App\Models\CmsPage;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CmsPageController extends AdminController
{
    /**
     * 获取当前页面配置语言
     * @return string
     */
    public function getCurrentLang()
    {
        return request('lang', user_admin_config('lang'));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(CmsPage::where('lang', $this->getCurrentLang()), function (Grid $grid) {
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->disableDeleteButton();
            $grid->disableRowSelector();

            $grid->number();
            $grid->column('name');
            $grid->column('link');
            $grid->column('thumbs')->image();
            $grid->column('status')->switch();
            $grid->column('lang')->display(function ($value) {
                return CmsLang::getAll($value);
            })->modal('多言语页面', PageTable::make(['resource' => $grid->resource()]));
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
        return Show::make($id, new CmsPageRepo(), function (Show $show) {
            $show->disableDeleteButton();

            $show->field('id');
            $show->field('name');
            $show->field('link');
            $show->field('thumbs')->image();
            $show->field('keywords')->label();
            $show->field('description');
            $show->field('lang');
            $show->field('content')->unescape();
            $show->json('extension');
            $show->field('status')->using(CmsPage::STATUSES);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new CmsPageRepo(), function (Form $form) {
            $form->disableDeleteButton();
            $form->defaultViewChecked();

            //添加其他语言版本时的提醒
            $sourceId = request('source_id');
            if ($sourceId) {
                $page = CmsPage::find($sourceId);
                $lang = CmsLang::getAll($this->getCurrentLang());
                $html = "<div class=\"alert alert-primary alert-dismissable\"><i class=\"fa fa-exclamation-circle\"></i>正在创建【{$page['name']}】页面的【{$lang}版】</div>";
                $form->html($html);

                // 设置关联id
                $link = $page['link'];
            } else {
                $link = '';
            }

            $form->tab('基础信息', function (Form $form) use ($link) {
                $form->display('id');
                $form->text('name')->required();
                if ($link) {
                    $form->hidden('link')->default($link);
                } else {
                    $form->text('link')->required();
                }
                $form->editor('content')->height('600');
                $form->switch('status')->default(true);
                $form->hidden('lang')->default($this->getCurrentLang());
            });
            $form->tab('SEO信息', function (Form $form) {
                $form->image('thumbs')->url('file/upload')->autoUpload()->saveAsString();
                $form->tags('keywords')->help('输入逗号后按回车键');
                $form->textarea('description')->rows(2)->saveAsString();
            });
            $form->tab('自定义数据', function ($form) {
                $form->array('extension', function ($table) {
                    $table->text('key');
                    $table->textarea('value');
                })->saveAsJson();
            });
        });
    }
}
