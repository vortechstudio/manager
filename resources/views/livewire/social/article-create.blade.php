<div>
    <x-base.toolbar
        title="Création d'un article"
        :breads="array('Social', 'Articles', 'Création d\'un article')" />

    <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8 col-sm-12 mb-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <x-form.input
                            name="title"
                            label="Titre"
                            is-model="true"
                            model="form"
                            required="true" />
                        <x-form.textarea
                            name="description"
                            is-model="true"
                            model="form"
                            label="Courte description" />

                        <x-form.textarea
                            type="ckeditor"
                            name="contenue"
                            label="Contenue de l'article"
                            is-model="true"
                            model="form"
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
                                name="image" />
                        </div>
                        <div class="mb-10">
                            <label for="cercle_id" class="form-label required">Type</label>
                            <div wire:ignore>
                                <select id="cercle_id" name="cercle_id" class="form-select" data-control="select2" data-placeholder="-- Selectionner un cercle --" data-pharaonic="select2"  wire:model="form.cercle_id">
                                    <option value=""></option>
                                    @foreach($cercles as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-10">
                            <label for="type" class="form-label required">Type</label>
                            <div wire:ignore>
                                <select id="type" name="type" class="form-select" data-control="select2" data-placeholder="-- Selectionner un type d'article --" data-pharaonic="select2"  wire:model="form.type">
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
                                <select id="author" name="author" class="form-select" data-control="select2" data-placeholder="-- Selectionner un auteur --" data-pharaonic="select2"  wire:model="form.author">
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
                                is-model="true"
                                model="form"
                                label="Promouvoir l'article" />
                        </div>
                        <div x-data="{show_published_at: false}" class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.switches
                                name="form.published"
                                label="Publié l'article"
                                value="1"
                                class-check="primary"
                                alpine="true"
                                fun-alpine="show_published_at = ! show_published_at" />

                            <div x-show="show_published_at">
                                <label for="published_at" class="form-label">Publié le:</label>
                                <input data-format="datetime" class="form-control" wire:model="form.published_at" placeholder="Pick a date"/>
                            </div>
                        </div>
                        <div x-data="{show_published_social_at: false}" class="d-flex flex-row justify-content-between align-items-center mb-10">
                            <x-form.switches
                                name="form.publish_social"
                                label="Publié l'article sur les réseaux"
                                value="1"
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
                            text-submit="Créer un article"
                            text-loading="Création en cours..." />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push("scripts")
    <script type="text/javascript">
        $("#cercle_id").on('change', e => {
            let data = $("#cercle_id").select2("val")
            @this.set('cercle_id', data)
        })

        $("#type").on('change', e => {
            let data = $("#type").select2("val")
            @this.set('type', data)
        })

        $("#author").on('change', e => {
            let data = $("#author").select2("val")
            @this.set('author', data)
        })
    </script>
@endpush
