<?php

namespace Database\Seeders;

use App\Models\CmsLang;
use App\Models\CmsCategory;
use Illuminate\Database\Seeder;

class CmsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 如果栏目分类已经初始化过,跳过
        if (CmsCategory::where('name', '资讯中心')->exists()) {
            $this->command->getOutput()->writeln('栏目分类已经初始化过,跳过...');
            return;
        }

        // 初始化栏目分类
        $this->command->getOutput()->writeln('初始化栏目分类');

        CmsCategory::create(['parent_id' => '0', 'name' => '资讯中心', 'lang' => 'zh_CN', 'alias' => 'news']);
        CmsCategory::create(['parent_id' => '0', 'name' => '資訊中心', 'lang' => 'zh_HK', 'alias' => 'news']);

        // 初始化完成
        $this->command->getOutput()->writeln('初始化完成...');
    }
}
