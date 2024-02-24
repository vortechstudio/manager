<div>
    <x-base.toolbar
        title="Création d'un article"
        :breads="array('Social', 'Articles', 'Création d\'un article')" />

    <form wire:submit="store" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-sm-12 mb-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <x-form.input
                            name="title"
                            label="Titre"
                            required="true" />
                        <x-form.textarea
                            name="description"
                            label="Courte description" />

                        <x-form.textarea
                            type="tinymce"
                            name="contenue"
                            label="Contenue de l'article"
                            required="true" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 mb-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-10">
                            <label for="cercle_id" class="form-label required">Cercle</label>
                            <div wire:ignore>
                                <select name="cercle_id" class="form-select" data-control="select2" data-placeholder="-- Selectionner un cercle --" data-pharaonic="select2"  wire:model="cercle_id">
                                    <option value=""></option>
                                    @foreach($cercles as $cercle)
                                        <option value="{{ $cercle->id }}">{{ $cercle->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-10">
                            <label for="type" class="form-label required">Type</label>
                            <div wire:ignore>
                                <select name="type" class="form-select" data-control="select2" data-placeholder="-- Selectionner un type d'article --" data-pharaonic="select2"  wire:model="type">
                                    <option value=""></option>
                                    @foreach($types as $item)
                                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-10">
                            <label for="type" class="form-label required">Auteur</label>
                            <div wire:ignore>
                                <select name="author" class="form-select" data-control="select2" data-placeholder="-- Selectionner un auteur --" data-pharaonic="select2"  wire:model="author">
                                    <option value=""></option>
                                    @foreach($authors as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="separator border border-2 border-gray-300 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.checkbox
                                name="promote"
                                label="Promouvoir l'article" />
                        </div>
                        <div x-data="{show_published_at: false}" class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.switches
                                name="published"
                                label="Publié l'article"
                                value="1"
                                class-check="primary"
                                alpine="true"
                                fun-alpine="show_published_at = ! show_published_at" />

                            <div x-show="show_published_at">
                                <label for="published_at" class="form-label">Publié le:</label>
                                <div data-format="datetime" class="input-group" id="kt_td_picker_simple" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                    <input id="kt_td_picker_basic_input" wire:model="published_at" type="text" class="form-control" data-td-target="#published_at"/>
                                    <span class="input-group-text" data-td-target="#published_at" data-td-toggle="datetimepicker">
                                        <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div x-data="{show_published_social_at: false}" class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.switches
                                name="publish_social"
                                label="Publié l'article sur les réseaux"
                                value="1"
                                class-check="warning"
                                alpine="true"
                                fun-alpine="show_published_social_at = ! show_published_social_at" />

                            <div x-show="show_published_social_at">
                                <label for="publish_social_at" class="form-label">Publié le:</label>
                                <div data-format="datetime" class="input-group" id="kt_td_picker_simple" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                    <input id="kt_td_picker_basic_input" wire:model="publish_social_at" type="text" class="form-control" data-td-target="#publish_social_at"/>
                                    <span class="input-group-text" data-td-target="#publish_social_at" data-td-toggle="datetimepicker">
                                        <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-form.button
                            text-submit="Créer un article"
                            text-loading="Création en cours..." />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
