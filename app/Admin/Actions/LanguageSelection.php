<?php

namespace App\Admin\Actions;

use App\Admin\Repositories\CmsLang as CmsLangRepo;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Actions\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LanguageSelection extends Action
{
    /**
     * @return string
     */
    protected $title = '语言选择';

    protected $selector = '.mark-language-selection';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $lang = $request->get('lang');
        user_admin_config(['lang' => $lang]);

        return $this->response()->script(<<<'JS'
setTimeout(()=>location.reload(), 100);
JS);
    }

    /**
     * 设置按钮的HTML，这里我们需要附加上弹窗的HTML
     *
     * @return string
     */
    public function html()
    {
        return admin_view('admin.actions.language-selection', $this->getData());
    }

    protected function getData()
    {
        $allLang = CmsLangRepo::getAll();
        $locale = user_admin_config('lang');
        $lang = Arr::get($allLang, $locale, '不支持该语言');
        unset($allLang[$locale]);
        return [
            'lang' => $lang,
            'selector' => trim($this->selector, '.'),
            'allLang' => $allLang,
        ];
    }
}
