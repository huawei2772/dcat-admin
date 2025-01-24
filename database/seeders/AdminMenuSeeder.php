<?php

namespace Database\Seeders;

use Dcat\Admin\Models\Menu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 如果菜单已经初始化过,跳过
        if (Menu::where('title', 'CMS设置')->exists()) {
            $this->command->getOutput()->writeln('菜单已经初始化过,跳过...');
            return;
        }

        // 初始化后台菜单
        $this->command->getOutput()->writeln('初始化后台菜单');

        $model = Menu::create(['parent_id' => 0, 'title' => 'CMS设置', 'icon' => 'fa-align-justify']);
        Menu::create(['parent_id' => $model->id, 'title' => '多语言', 'uri' => 'cms/lang']);
        Menu::create(['parent_id' => $model->id, 'title' => '栏目分类', 'uri' => 'cms/category']);
        Menu::create(['parent_id' => $model->id, 'title' => '资讯中心', 'uri' => 'cms/news']);
        Menu::create(['parent_id' => $model->id, 'title' => '网站设置', 'uri' => 'cms/setting']);
        Menu::create(['parent_id' => $model->id, 'title' => '单页管理', 'uri' => 'cms/page']);
        
        $this->command->getOutput()->writeln('初始化完成...');
    }
}
