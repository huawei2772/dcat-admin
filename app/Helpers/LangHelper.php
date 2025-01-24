<?php

namespace App\Helpers;

use App\Models\CmsLang;
use Illuminate\Support\Facades\Cache;

class LangHelper
{
    /**
     * 获取语言后端缓存
     * @return mixed
     */
    public static function all()
    {
        return Cache::rememberForever((new CmsLang())->getTable(), function () {
            return CmsLang::where('status', 1)->orderBy('order')->pluck('cn_name', 'name')->toArray();
        });
    }

    /**
     * 获取语言前端缓存
     * @return mixed
     */
    public static function frontendAll()
    {
        return Cache::rememberForever((new CmsLang())->getTable() . '-frontend', function () {
            try {
                // 测试数据库连接，如果连接失败，则返回空数组
                // 初始化的时候，数据库可能还没有准备好
                \Illuminate\Support\Facades\DB::connection()->getPdo();
                return CmsLang::where('frontend_state', 1)->orderBy('order')->pluck('cn_name', 'name')->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });
    }

    /**
     * 清除请后台缓存
     * @return void
     */
    public static function clearCache(): void
    {
        Cache::forget((new CmsLang())->getTable() . "-frontend");
        Cache::forget((new CmsLang())->getTable());
    }
}
