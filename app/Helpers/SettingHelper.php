<?php

namespace App\Helpers;

use App\Models\CmsSetting;
use App\Models\CmsSettingKey;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    public static function get($key, $default = null)
    {
        $data = self::all();
        return Arr::get($data, $key, $default);
    }

    public static function all()
    {
        $lang = app()->getLocale();
        return Cache::rememberForever((new CmsSetting())->getTable() . "-{$lang}", function () use ($lang) {
            $keys = CmsSettingKey::where('status', true)->pluck('name')->toArray();
            return CmsSetting::whereIn('lang', [$lang, 'all'])->whereIn('key', $keys)->pluck('value', 'key')->toArray();
        });
    }

    public static function clearCache(): void
    {
        $lang = LangHelper::all();
        foreach ($lang as $key => $name) {
            Cache::forget((new CmsSetting())->getTable() . "-{$key}");
        }
    }
}
