<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Dashboard;
use App\Http\Controllers\Controller;

use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Dashboard')
            ->description('Description...')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row(Dashboard::environment());
                });
            });
    }
}
