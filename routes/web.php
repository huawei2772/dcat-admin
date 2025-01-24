<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

// 限制的目的是防止脏地址，影响seo
$all = \App\Helpers\LangHelper::frontendAll();
Route::pattern('locale', join('|', array_keys($all)));

Route::namespace('App\Http\Controllers\Home')->group(function () {
    Route::group(['prefix' => '{locale}'], function () {
        Route::middleware([SetLocale::class])->group(function () {
            Route::get('/', 'IndexController@index')->name('index');

            Route::get('/about/us', 'AboutController@us')->name('about.us');

            // 单页
            Route::get('/page/{link}', 'PageController@show')->name('page.show');
        });
    });
});

Route::redirect('/', '/zh_CN');
