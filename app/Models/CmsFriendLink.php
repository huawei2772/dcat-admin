<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\EloquentSortable\SortableTrait;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class CmsFriendLink extends Model implements Sortable
{
	use HasDateTimeFormatter, SortableTrait;
    protected $table = 'cms_friend_link';

    protected array $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];
}
