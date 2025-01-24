<?php

namespace App\Admin\Controllers;

use App\Models\CmsSetting;
use App\Models\CmsSettingKey;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Traits\HasFormResponse;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form as WidgetForm;

class CmsSettingController extends AdminController
{
    use HasFormResponse;

    public function index(Content $content)
    {
        return $content->header('网站设置')
            ->body(function (Row $row) {
                $row->column(12, $this->createForm());
            });
    }


    private function createForm()
    {
        $data = CmsSetting::whereIn('lang', [user_admin_config('lang'), 'all'])->pluck('value', 'key')->all();
        $form = new WidgetForm($data);
        $form->action(admin_url('cms/setting'));

        $keys = CmsSettingKey::where('status', CmsSettingKey::STATUS_SHOW)->orderBy('order')->get()->toArray();
        $lastColumn = [];
        foreach ($keys as $column) {
            // 不同组之间添加分割线
            $lastGroup = $lastColumn['group'] ?? '';
            if ($lastGroup && $lastGroup != $column['group']) {
                $form->divider();
            }

            $this->generateForm($form, $column);
            $lastColumn = $column;
        }

        $form->width(8, 3);
        return Box::make(trans('admin.edit'), $form);
    }

    public function store()
    {
        $data = request()->all();
        $allowAttr = [];
        $cmsSettingKeys = CmsSettingKey::where('status', CmsSettingKey::STATUS_SHOW)->get()->toArray();
        foreach ($cmsSettingKeys as $cmsSettingKey) {
            $allowAttr[$cmsSettingKey['name']] = $cmsSettingKey;
        }
        foreach ($data as $k => $v) {
            if (key_exists($k, $allowAttr)) {
                $lang = ($allowAttr[$k]['is_multilingual'] ? user_admin_config('lang') : 'all');
                CmsSetting::updateOrCreate(['key' => $k, 'lang' => $lang], ['value' => (string)$v]);
            }
        }

        $response = new JsonResponse();
        $response->success(trans('admin.update_succeeded'));
        return $response->send();
    }

    /**
     * 生成form
     * @param WidgetForm $form
     * @param array $config
     * @return void
     */
    private function generateForm(WidgetForm &$form, array $config): void
    {
        switch ($config['type']) {
            case CmsSettingKey::TYPE_TEXTAREA:
                $object = $form->textarea($config['name'], $config['label'])->rows(2);
                break;
            case CmsSettingKey::TYPE_IMAGE:
                $object = $form->image($config['name'], $config['label'])->url('file/upload')->autoUpload();
                break;
            case CmsSettingKey::TYPE_FILE:
                $object = $form->file($config['name'], $config['label'])->url('file/upload')->autoUpload();
                break;
            default:
                $object = $form->text($config['name'], $config['label']);
        }
        if (!empty($config['help'])) {
            $object->help($config['help']);
        }
    }
}
