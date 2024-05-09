<div>
    <div class="row">
        <div class="col-sm-12 col-lg-6 mb-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Image par default</h3>
                </div>
                <div class="card-body">
                    <img src="{{ $article->image }}" class="img-thumbnail" alt="">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6 mb-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Image header d'article</h3>
                </div>
                <div class="card-body">
                    <img src="{{ $article->image_head }}" class="img-thumbnail" alt="">
                </div>
            </div>
        </div>
    </div>
    <form action="" wire:submit="save" method="POST" enctype="multipart/form-data">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Mise à jour de l'image de l'article</h3>
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-sm btn-light" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Valider</span>
                        <span wire:loading  wire:target="save"><i class="fa-solid fa-spinner fa-spin me-2"></i> Upload en cours...</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <x-form.image-input
                    name="image"
                    width="w-600px" />

            </div>
        </div>
    </form>
</div>
