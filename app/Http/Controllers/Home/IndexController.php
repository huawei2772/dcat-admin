<?php

namespace App\Http\Controllers\Home;

class IndexController extends BaseController
{
    public function index()
    {
        $this->seo()->setTitle(__('home.home'));

        return $this->_view('home.index.index');
    }
}