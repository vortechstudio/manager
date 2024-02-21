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
                            label="description" />

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
                            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        Footer
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
