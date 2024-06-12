<div  class="modal fade" tabindex="-1" id="addCategory">
    <form action="" wire:submit="{{ $category ? 'editing' : 'save' }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ $category ? $category->name : 'Nouvelle Catégorie' }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="mb-10">
                        <label class="form-label required">Nom de la catégorie</label>
                        <input type="text" class="form-control" id="name" name="name" wire:model="name" required/>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="{{ $category ? 'editing' : 'save' }}">
                        <span wire:loading.class="d-none" wire:target="{{ $category ? 'editing' : 'save' }}">Sauvegarder</span>
                        <span class="d-none" wire:loading.class.remove="d-none" wire:target="{{ $category ? 'editing' : 'save' }}">
                            <div class="spinner-grow me-2" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                            Chargement...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <x-base.close-modal />
@endpush
