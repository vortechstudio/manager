<?php

namespace App\Models\Social;

use App\Models\Social\Post\Post;
use App\Models\Wiki\WikiCategory;
use Illuminate\Database\Eloquent\Model;

class Cercle extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function wiki_categories()
    {
        return $this->hasMany(WikiCategory::class);
    }
}
