<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CmsSettingKey;

class CmsSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 如果CMS设置已经初始化过,跳过
        if (CmsSettingKey::where('name', 'web_title')->exists()) {
            $this->command->getOutput()->writeln('CMS设置已经初始化过,跳过...');
            return;
        }

        $data = [
            ['name' => 'web_title', 'label' => '网站名称', 'type' => CmsSettingKey::TYPE_TEXT, 'group' => CmsSettingKey::GROUP_WEB],
            ['name' => 'web_logo', 'label' => '网站logo', 'type' => CmsSettingKey::TYPE_IMAGE, 'group' => CmsSettingKey::GROUP_WEB],
            ['name' => 'web_keywords', 'label' => '网站关键词', 'type' => CmsSettingKey::TYPE_TEXT, 'group' => CmsSettingKey::GROUP_WEB, 'help' => '使用英文逗号隔开'],
            ['name' => 'web_description', 'label' => '网站描述', 'type' => CmsSettingKey::TYPE_TEXTAREA, 'group' => CmsSettingKey::GROUP_WEB],
            ['name' => 'company_name', 'label' => '公司名称', 'type' => CmsSettingKey::TYPE_TEXT, 'group' => CmsSettingKey::GROUP_COMPANY],
            ['name' => 'company_address', 'label' => '公司地址', 'type' => CmsSettingKey::TYPE_TEXT, 'group' => CmsSettingKey::GROUP_COMPANY],
            ['name' => 'company_contact', 'label' => '联系电话', 'type' => CmsSettingKey::TYPE_TEXT, 'group' => CmsSettingKey::GROUP_COMPANY, 'is_multilingual' => false],
            ['name' => 'company_400', 'label' => '400电话', 'type' => CmsSettingKey::TYPE_TEXT, 'group' => CmsSettingKey::GROUP_COMPANY, 'is_multilingual' => false],
            ['name' => 'company_email', 'label' => '公司邮箱', 'type' => CmsSettingKey::TYPE_TEXT, 'group' => CmsSettingKey::GROUP_COMPANY, 'is_multilingual' => false],
        ];

        // 初始化CMS设置
        $this->command->getOutput()->writeln('初始化CMS设置');

        foreach ($data as $item) {
            CmsSettingKey::create($item);
        }

        // 初始化完成
        $this->command->getOutput()->writeln('初始化完成...');
    }
}
