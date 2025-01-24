<?php

namespace App\Admin\Renderable;

use App\Admin\Repositories\CmsArticle as CmsArticleAlias;
use Dcat\Admin\Support\LazyRenderable;

class ArticleTable extends LazyRenderable
{
    public function render()
    {
        $resource = $this->payload['resource'];
        $id = $this->payload['key'];

        return CmsArticleAlias::getRelationArticle($id, $resource);
    }
}