<?php

namespace App\Admin\Renderable;

use App\Admin\Repositories\CmsPage;
use Dcat\Admin\Support\LazyRenderable;

class PageTable extends LazyRenderable
{
    public function render()
    {
        $resource = $this->payload['resource'];
        $id = $this->payload['key'];

        return CmsPage::getRelationPage($id, $resource);
    }
}