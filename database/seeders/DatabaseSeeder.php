<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 初始化多语言、CMS设置、后台菜单
        $this->call([
            CmsLangSeeder::class,
            CmsCategorySeeder::class,
            CmsSettingSeeder::class,
            AdminMenuSeeder::class,
        ]);
    }
}
