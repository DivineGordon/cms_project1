<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageAnalytics extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'page_id',
        'ip_address',
        'user_agent',
        'referer',
        'session_id',
        'is_unique_visitor',
        'viewed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_unique_visitor' => 'boolean',
            'viewed_at' => 'datetime',
        ];
    }

    /**
     * Get the page that owns the analytics.
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
