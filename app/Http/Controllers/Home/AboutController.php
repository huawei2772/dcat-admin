<?php

namespace App\Http\Controllers\Home;

class AboutController extends BaseController
{
    public function us()
    {
        $this->seo()->setTitle(__('home.about us'));
        return $this->_view('home.about.us');
    }
}