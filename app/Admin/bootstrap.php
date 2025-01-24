<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Navbar;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

// 覆盖默认配置
config(['admin' => user_admin_config()]);
config(['app.locale' => config('admin.lang') ?: config('app.locale')]);

Admin::style('.table-main { min-height: 500px; }');

Admin::navbar(function (Navbar $navbar) {
    // ajax请求不执行
    if (!Dcat\Admin\Support\Helper::isAjaxRequest()) {
        $navbar->right(App\Admin\Actions\AdminSetting::make()->render());
        $navbar->right(App\Admin\Actions\LanguageSelection::make()->render());

        // 前台链接
        $html = "<ul class='nav navbar-nav'><li class='nav-item'><a href='/' class='dropdown-toggle nav-link' target='_blank'>网站前台</a></li></ul>";
        $navbar->right($html);
    }
});
