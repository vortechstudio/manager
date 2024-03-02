<div>
    <x-base.toolbar
        :title="$article->title"
        :breads="array('Social', 'Articles','Edition: '. $article->title)"
        return="true"
        sticky="true"
    />

    <form wire:submit.prevent="update" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-sm-12 mb-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <x-form.input
                            name="article.title"
                            label="Titre"
                            required="true"
                            :value="$article->title" />
                        <x-form.textarea
                            name="description"
                            label="Courte description"
                            :value="$article->description"
                        />

                        <x-form.textarea
                            type="tinymce"
                            name="contenue"
                            label="Contenue de l'article"
                            required="true"
                            :value="$article->contenue" />
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
                                name="image"
                                default="{{ $article->image }}" />
                        </div>
                        <div class="mb-10">
                            <label for="cercle_id" class="form-label required">Cercle</label>
                            <div wire:ignore>
                                <select id="cercle_id" name="cercle_id" class="form-select" data-control="select2" data-placeholder="-- Selectionner un cercle --" data-pharaonic="select2"  wire:model="cercle_id">
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
                                <select id="type" name="type" class="form-select" data-control="select2" data-placeholder="-- Selectionner un type d'article --" data-pharaonic="select2"  wire:model="article.type">
                                    <option value=""></option>
                                    @foreach($types as $item)
                                        <option value="{{ $item['value'] }}" @if($item['value'] == $article->type->value) selected @endif>{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-10">
                            <label for="type" class="form-label required">Auteur</label>
                            <div wire:ignore>
                                <select id="author" name="author" class="form-select" data-control="select2" data-placeholder="-- Selectionner un auteur --" data-pharaonic="select2"  wire:model="author">
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
                                :checked="$article->promote ? 'checked' : ''"
                                label="Promouvoir l'article" />
                        </div>
                        <div x-data="{show_published_at: false}" class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.switches
                                name="published"
                                label="Publié l'article"
                                value="1"
                                :checked="$article->published ? 'checked' : ''"
                                class-check="primary"
                                alpine="true"
                                fun-alpine="show_published_at = ! show_published_at" />

                            <div x-show="show_published_at">
                                <label for="published_at" class="form-label">Publié le:</label>
                                <input data-format="datetime" value="{{ $article->published_at }}" class="form-control" wire:model="published_at" placeholder="Pick a date"/>
                            </div>
                        </div>
                        <div x-data="{show_published_social_at: false}" class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.switches
                                name="article.publish_social"
                                label="Publié l'article sur les réseaux"
                                value="1"
                                class-check="warning"
                                :checked="$article->publish_social ? 'checked' : ''"
                                alpine="true"
                                fun-alpine="show_published_social_at = ! show_published_social_at" />

                            <div x-show="show_published_social_at">
                                <label for="publish_social_at" class="form-label">Publié le:</label>
                                <input data-format="datetime" value="{{ $article->publish_social_at }}" class="form-control" wire:model="publish_social_at" placeholder="Pick a date"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-form.button
                            text-submit="Mettre à jour"
                            text-loading="Mise à jour..." />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>