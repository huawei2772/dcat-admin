<?php

namespace App\Http\Controllers\Home;

use App\Models\CmsPage;

class PageController extends BaseController
{
    public function show($locale, $link)
    {
        $page = CmsPage::where('link', $link)->where('lang', $locale)->where('status', CmsPage::STATUS_SHOW)->first();
        if (!$page) {
            abort(404);
        }

        $this->seo()->setTitle($page->name);
        $this->seo()->setDescription($page->description);
        $this->seo()->setKeywords(join(',', $page->keywords));

        return $this->_view('home.page.show', ['page' => $page]);
    }
}
