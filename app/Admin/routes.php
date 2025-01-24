<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('cms/lang', 'CmsLangController', ['except' => ['show', 'delete']]);
    $router->resource('cms/category', 'CmsCategoryController', ['except' => ['show']]);

    // 新闻
    $router->resource('cms/news', 'CmsNewsController');

    // 设置
    $router->resource('cms/setting', 'CmsSettingController', ['only' => ['index', 'store']]);
    $router->resource('cms/setting-key', 'CmsSettingKeyController', ['except' => ['show', 'delete']]);

    // 单页
    $router->resource('cms/page', 'CmsPageController');

    // 友情链接
    $router->resource('cms/friend-link', 'CmsFriendLinkController');

    $router->any('file/upload', 'FileController@upload');
});
