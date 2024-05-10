<div class="card shadow-sm">
    <form action="" wire:submit="save" method="POST" enctype="multipart/form-data">
        <div class="card-header">
            <h3 class="card-title">Images de l'évènement</h3>
            <div class="card-toolbar">
                <button type="submit" class="btn btn-sm btn-light" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Valider</span>
                    <span wire:loading  wire:target="save"><i class="fa-solid fa-spinner fa-spin me-2"></i> Upload en cours...</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-lg-4 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Image ICON</h3>
                        </div>
                        <div class="card-body">
                            <img src="{{ $event->getImage('icon') }}" class="img-responsive mb-2" alt="">
                            <x-form.image-input
                                name="icon" />

                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Image Default</h3>
                        </div>
                        <div class="card-body">
                            <img src="{{ $event->getImage('default') }}" class="img-responsive mb-2" alt="">
                            <x-form.image-input
                                name="default"
                                width="w-400px h-250px" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Image Header</h3>
                        </div>
                        <div class="card-body">
                            <img src="{{ $event->getImage('header') }}" class="img-responsive mb-2" alt="">
                            <x-form.image-input
                                name="header"
                                width="w-375px" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
