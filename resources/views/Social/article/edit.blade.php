@extends("layouts.app")

@section("title")
    Création d'un article
@endsection

@section("content")
    <x-base.toolbar
        title="Edition d'un article"
        :breads="array('Social', 'Articles', 'Création d\'un article')"
        sticky="true"
        return="true" />

    <form action="{{ route('social.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8 col-sm-12 mb-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <x-form.input
                            name="title"
                            label="Titre"
                            :value="$article->title"
                            required="true" />
                        <x-form.textarea
                            name="description"
                            :value="$article->description"
                            label="Courte description" />

                        <x-form.textarea
                            type="laraberg"
                            name="contenue"
                            label="Contenue de l'article"
                            :value="$article->contenue"
                            required="true" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 mb-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-10 d-flex flex-column">
                            <label for="img_cover" class="form-label required">Image de couverture</label>
                            <x-form.image-input
                                width="w-300px"
                                is-model="true"
                                model="form"
                                name="image"
                                :default="Storage::disk('vortech')->url('blog/' . $article->id . '/default.webp')" />
                        </div>
                        <div class="mb-10">
                            <label for="cercle_id" class="form-label required">Type</label>
                            <div wire:ignore>
                                <select id="cercle_id" name="cercle_id" class="form-select" data-control="select2" data-placeholder="-- Selectionner un cercle --" data-pharaonic="select2"  wire:model.defer="form.cercle_id">
                                    <option value=""></option>
                                    @foreach($cercles as $item)
                                        <option value="{{ $item->id }}" @if($item->id == $article->cercle_id) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-10">
                            <label for="type" class="form-label required">Type</label>
                            <div wire:ignore>
                                <select id="type" name="type" class="form-select" data-control="select2" data-placeholder="-- Selectionner un type d'article --" data-pharaonic="select2"  wire:model.defer="form.type">
                                    <option value=""></option>
                                    @foreach($types as $item)
                                        <option value="{{ $item['value'] }}" @if($item['label'] == $article->type) selected @endif>{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-10">
                            <label for="type" class="form-label required">Auteur</label>
                            <div wire:ignore>
                                <select id="author" name="author" class="form-select" data-control="select2" data-placeholder="-- Selectionner un auteur --" data-pharaonic="select2"  wire:model.defer="form.author">
                                    <option value=""></option>
                                    @foreach($authors as $item)
                                        <option value="{{ $item->id }}" @if($item->id == $article->author) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="separator border border-2 border-gray-300 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.checkbox
                                name="promote"
                                is-model="true"
                                model="form"
                                :checked="$article->promote"
                                label="Promouvoir l'article" />
                        </div>
                        <div x-data="{show_published_at: {{ $article->published ? 'true' : 'false' }}}" class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.switches
                                name="form.published"
                                label="Publié l'article"
                                value="1"
                                :checked="$article->published"
                                class-check="primary"
                                alpine="true"
                                fun-alpine="show_published_at = ! show_published_at" />

                            <div x-show="show_published_at">
                                <label for="published_at" class="form-label">Publié le:</label>
                                <input data-format="datetime" class="form-control" wire:model="form.published_at" placeholder="Pick a date"/>
                            </div>
                        </div>
                        <div x-data="{show_published_social_at: {{ $article->publish_social ? 'true' : 'false' }}}" class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.switches
                                name="form.publish_social"
                                label="Publié l'article sur les réseaux"
                                value="1"
                                :checked="$article->publish_social"
                                class-check="warning"
                                alpine="true"
                                fun-alpine="show_published_social_at = ! show_published_social_at" />

                            <div x-show="show_published_social_at">
                                <label for="publish_social_at" class="form-label">Publié le:</label>
                                <input data-format="datetime" class="form-control" wire:model="form.publish_social_at" placeholder="Pick a date"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-form.button
                            text-submit="Editer un article"
                            text-loading="Création en cours..." />
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
