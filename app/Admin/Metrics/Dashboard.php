<?php

namespace App\Admin\Metrics;


use Dcat\Admin\Widgets\Callout;
use Dcat\Admin\Widgets\Table;
use Illuminate\Support\Facades\DB;

class Dashboard
{
    public static function environment()
    {
        $pdo = DB::connection()->getPdo();
        $envs = [
            ['name' => 'PHP版本', 'value' => PHP_VERSION],
            ['name' => '服务器版本', 'value' => PHP_OS],
            ['name' => 'WEB服务器', 'value' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',],
            ['name' => '内存', 'value' => ini_get('memory_limit')],
            ['name' => 'Laravel版本', 'value' => app()->version()],
            ['name' => '数据库', 'value' => config('database.default').' '.$pdo->getAttribute(\PDO::ATTR_SERVER_VERSION)],
        ];

        return Callout::make(Table::make([], $envs))->primary();
    }
}
