<?php

namespace App\Livewire\Forms\Social;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ArticleForm extends Form
{
    #[Validate('required|min:5')]
    public $title = '';

    #[Validate('max:255')]
    public $description = '';

    #[Validate('required')]
    public $contenue = '';

    public $published = false;

    public $published_at = null;

    public $publish_social = false;

    public $publish_social_at = null;

    public $promote = false;

    #[Validate('required')]
    public $author = '';

    #[Validate('required')]
    public $cercle_id = '';

    #[Validate('required')]
    public $type = '';

    #[Validate('image|max:2048')]
    public $image;
}
