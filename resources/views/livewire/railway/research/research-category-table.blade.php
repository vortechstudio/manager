<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Liste des catégories de recherche</h3>
            <div class="card-toolbar gap-5">
                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addCategory">
                    Nouvelle catégorie
                </button>
                <button wire:click="export" class="btn btn-sm btn-light" wire:loading.attr="disabled" wire:target="export">
                    <span wire:loading.remove wire:target="export"><i class="fa-solid fa-file-export me-2"></i> Exporter</span>
                    <span class="d-none" wire:loading.class.remove="d-none" wire:target="export"><i class="fa-solid fa-spinner fa-spin me-2"></i> Export en cours...</span>
                </button>
                <button wire:click="import" class="btn btn-sm btn-light" wire:loading.attr="disabled" wire:target="import">
                    <span wire:loading.remove wire:target="import"><i class="fa-solid fa-file-import me-2"></i> Importer</span>
                    <span class="d-none" wire:loading.class.remove="d-none" wire:target="import"><i class="fa-solid fa-spinner fa-spin me-2"></i> Import en cours...</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            @if(count($categories) == 0)
                <x-base.is-null text="Aucune catégories de recherche enregistrée" />
            @else
                <table class="table table-row-bordered table-row-gray-300 w-50 mx-auto shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                    <thead>
                    <tr class="fw-bold">
                        <th>Désignation</th>
                        <th>Nb Recherches</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->railwayResearches->count() }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('railway.researches.category', $category->id) }}" class="btn btn-sm btn-secondary btn-icon">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <button wire:click="delete({{ $category->id }})" class="btn btn-sm btn-danger btn-icon" wire:loading.attr="disabled">
                                        <span wire:loading.remove><i class="fa-solid fa-trash"></i></span>
                                        <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i> </span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @livewire('railway.research.research-category-form')
</div>
@push('scripts')
    <x-base.close-modal />
@endpush