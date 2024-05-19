<div>
    <div class="row gap-5">
        @foreach($rewards as $reward)
            <div class="col-sm-12 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-3">
                                    <img src="{{ $reward->icon }}" alt="">
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $reward->name }}</span>
                                    <span class="text-muted">{{ $reward->description }}</span>
                                </div>
                            </div>
                            <button class="btn btn-outline btn-icon btn-outline-danger" wire:click="delete({{ $reward->id }})" wire:confirm="Supprimée cette récompense ?" wire:loading.attr="disabled">
                                <span wire:loading.remove><i class="fa-solid fa-trash"></i></span>
                                <span wire:loading wire:loading.class="spinner-grow spinner-grow-sm"> </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
