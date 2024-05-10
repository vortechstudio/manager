<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Post</h3>
        <div class="card-toolbar">
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editContent">
                Editer le contenue
            </button>
        </div>
    </div>
    <img src="{{ $event->getImage('header') }}" alt="{{ $event->title }}">
    <div class="card-body">
        <div class="fs-2x fw-bolder mb-3">{{ $event->title }}</div>
        <div class="d-flex flex-row align-items-center p-5 bg-gray-200 rounded mb-10">
            <div class="symbol symbol-70px symbol-circle me-5">
                <img src="{{ $event->cercles()->first()->cercle_icon }}" alt="{{ $event->cercles()->first()->name }}">
            </div>
            <div class="d-flex flex-column">
                <span class="fs-2 fw-bold">{{ $event->cercles()->first()->name }}</span>
                <span class="text-muted">Par Vortech Studio</span>
            </div>
        </div>

        <div class="fst-italic mb-3">{{ $event->synopsis }}</div>
        {!! $event->contenue !!}
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="editContent">
        <form action="" wire:submit="save" method="POST">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edition du contenue</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.textarea
                            type="ckeditor"
                            name="contenue"
                            :value="$contenue"
                            label="Contenue de l'évènement" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermé</button>
                        <button type="submit" class="btn btn-sm btn-light" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">Valider</span>
                            <span wire:loading  wire:target="save"><i class="fa-solid fa-spinner fa-spin me-2"></i> Edition en cours...</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <x-base.close-modal />
@endpush
