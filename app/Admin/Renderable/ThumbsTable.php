<?php

namespace App\Admin\Renderable;


use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Widget;

class ThumbsTable extends Widget
{
    public mixed $thumbs = [];
    public mixed $attachments = [];
    public function __construct($params)
    {
        $this->thumbs = $params['thumbs'] ?? [];
        $this->attachments = $params['attachments'] ?? [];
    }

    public function render()
    {
        $row = new Row();

        if ($this->thumbs) {
            foreach ($this->thumbs as $thumb) {
                $data = [];
                $data[] = "<img src='{$thumb}' alt='{$thumb}' class='img-thumbnail'>";
                $data[] = "<div class='text-center p-1'><a href='{$thumb}' target='_blank'>点击链接查看</a></div>";
                $html = implode("\n\r", $data);
                $row->column(4, "<div class='m-1 text-wrap text-break'>{$html}</div>");
            }
        }

        if ($this->attachments) {
            foreach ($this->attachments as $attachment) {
                $data = [];
                $data[] = "<a href='{$attachment}' target='_blank'>{$attachment}</a>";
                $html = implode("\n\r", $data);
                $row->column(4, "<div class='m-1 text-wrap text-break'>{$html}</div>");
            }
        }
        return $row->render();
    }
}
