<?php

namespace App\Http\Controllers\Home;

use App\Services\SeoService;
use App\Models\CmsFriendLink;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;

abstract class BaseController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->data['controller'] = class_basename(static::class);
        $this->data['friendLinks'] = $this->friendLinks();
    }

    protected function seo(): SeoService
    {
        return app(SeoService::class);
    }

    /**
     * 友情链接
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function friendLinks()
    {
        return CmsFriendLink::orderBy('order')->get();
    }

    /**
     * @param $view
     * @return View|Factory|Application
     */
    public function _view($view, $data = []): View|Factory|Application
    {
        return view($view, array_merge($this->data, $data));
    }
}
