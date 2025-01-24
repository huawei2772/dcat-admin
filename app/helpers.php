<?php

use App\Helpers\SettingHelper;
use Illuminate\Support\Arr;

if (!function_exists('user_admin_config')) {
    function user_admin_config($key = null, $value = null)
    {
        $session = session();

        if (!$config = $session->get('admin.config')) {
            $config = config('admin');

            $config['lang'] = config('app.locale');
        }

        if (is_array($key)) {
            // 保存
            foreach ($key as $k => $v) {
                Arr::set($config, $k, $v);
            }

            $session->put('admin.config', $config);

            return;
        }

        if ($key === null) {
            return $config;
        }

        return Arr::get($config, $key, $value);
    }
}

if (!function_exists('route_lang')) {
    /**
     * 生成自带语言的url
     */
    function route_lang($name, $parameters = [], $absolute = true): string
    {
        $parameters = array_merge((array)$parameters, ['locale' => app()->getLocale()]);
        return route($name, $parameters, $absolute);
    }
}

if (!function_exists('getSetting')) {
    /**
     * 获取cms-setting网站配置
     * @param $key
     * @param $default
     * @return mixed
     */
    function getSetting($key, $default = null): mixed
    {
        return SettingHelper::get($key, $default);
    }
}