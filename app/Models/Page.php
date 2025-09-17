<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'theme_id',
        'title',
        'slug',
        'content',
        'customizations',
        'meta_title',
        'meta_description',
        'is_published',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => 'array',
            'customizations' => 'array',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Get the client that owns the page.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the theme for the page.
     */
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Get the analytics for the page.
     */
    public function analytics()
    {
        return $this->hasMany(PageAnalytics::class);
    }

    /**
     * Get the public URL for the page.
     */
    public function getPublicUrlAttribute()
    {
        return route('page.show', ['client' => $this->client->slug, 'page' => $this->slug]);
    }
}
