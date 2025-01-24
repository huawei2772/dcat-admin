<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CmsLang;

class CmsLangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 如果多语言已经初始化过,跳过
        if (CmsLang::where('name', 'zh_CN')->exists()) {
            $this->command->getOutput()->writeln('多语言已经初始化过,跳过...');
            return;
        }

        // 初始化多语言
        $this->command->getOutput()->writeln('初始化多语言');

        CmsLang::create(['name' => 'zh_CN', 'cn_name' => '简体中文', 'status' => true, 'frontend_state' => true]);
        CmsLang::create(['name' => 'zh_HK', 'cn_name' => '繁体中文', 'status' => true]);
        CmsLang::create(['name' => 'en', 'cn_name' => 'English', 'status' => false]);

        // 初始化完成
        $this->command->getOutput()->writeln('初始化完成...');
    }
}
