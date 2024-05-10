<div class="row">
    <div class="col-sm-12 col-lg-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Icone du cercle</h3>
            </div>
            <div class="card-body">
                <img src="{{ $cercle->getImage($cercle->id, 'icon') }}" alt="" class="img-thumbnail">
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Image du cercle</h3>
            </div>
            <div class="card-body">
                <img src="{{ $cercle->getImage($cercle->id, 'default') }}" alt="" class="img-thumbnail">
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4 mb-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Header du cercle</h3>
            </div>
            <div class="card-body">
                <img src="{{ $cercle->getImage($cercle->id, 'header') }}" alt="" class="img-thumbnail">
            </div>
        </div>
    </div>

    <form action="" wire:submit="save" method="POST" enctype="multipart/form-data">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Edition de l'image du cercle</h3>
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-sm btn-light" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Valider</span>
                        <span wire:loading  wire:target="save"><i class="fa-solid fa-spinner fa-spin me-2"></i> Upload en cours...</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-4 mb-2">
                        <span class="fw-bold">Header</span>
                        <x-form.image-input
                            name="header" />
                    </div>
                    <div class="col-sm-12 col-lg-4 mb-2">
                        <span class="fw-bold">Image par default</span>
                        <x-form.image-input
                            name="default" />
                    </div>
                    <div class="col-sm-12 col-lg-4 mb-2">
                        <span class="fw-bold">Icone</span>
                        <x-form.image-input
                            name="icon"
                            width="w-90px" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
