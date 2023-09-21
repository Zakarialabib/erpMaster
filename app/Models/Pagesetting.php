<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PageType;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Support\HasAdvancedFilter;

class PageSetting extends Model
{
    use HasFactory;
    use HasAdvancedFilter;

    public $table = 'pagesettings';

    protected $fillable = [
        'status',
        'page_id',
        'section_id',
        'page_type',
        'layout_type',
        'layout_config',
    ];

    protected $casts = [
        'status'        => Status::class,
        'page_type'     => PageType::class,
        'layout_config' => 'json',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
