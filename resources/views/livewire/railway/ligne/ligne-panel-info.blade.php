<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">&nbsp;</h3>
        <div class="card-toolbar gap-2">
            <a href="{{ route('railway.lignes.edit', $ligne) }}" class="btn btn-sm btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-title="Editer la ligne">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <button @if($ligne->active) wire:click="disabled" @else wire:click="enabled" @endif class="btn btn-sm btn-icon btn-outline {{ $ligne->active ? 'btn-outline-danger' : 'btn-outline-success' }}" data-bs-toggle="tooltip" data-bs-title="{{ $ligne->active ? 'Désactiver la ligne' : 'Activer la ligne' }}">
                <i class="fa-solid {{ $ligne->active ? 'fa-toggle-off' : 'fa-toggle-on' }}" wire:loading.remove wire:target="{{ $ligne->active ? 'disabled' : 'enabled' }}"></i>
                <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="{{ $ligne->active ? 'disabled' : 'enabled' }}"></i>
            </button>
            @if($ligne->status->value == 'beta')
                <button wire:click="production" class="btn btn-sm btn-icon btn-outline btn-outline-info" data-bs-toggle="tooltip" data-bs-title="Mettre en production la ligne">
                    <i class="fa-solid fa-boxes" wire:loading.remove wire:target="production"></i>
                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="production"></i>
                </button>
            @endif
            <button wire:click="delete" class="btn btn-sm btn-icon btn-danger" wire:confirm="Voulez-vous supprimer la ligne ?" data-bs-toggle="tooltip" data-bs-title="Supprimer la ligne">
                <i class="fa-solid fa-trash" wire:loading.remove wire:target="delete"></i>
                <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="delete"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex flex-column">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span>Nombre d'arrets</span>
                <span class="badge badge-warning">{{ $ligne->stations()->count() }}</span>
            </div>
            <div class="separator separator-2 border-gray-300 my-3"></div>
        </div>
        <div class="d-flex flex-column">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span>Distance</span>
                <div class="d-flex flex-row align-items-center gap-2">
                    <span>{{ $ligne->distance }} Km</span>
                    <button class="btn btn-xs btn-icon btn-outline btn-outline-primary" wire:click="distance" data-bs-toggle="tooltip" data-bs-title="Mettre a jour la distance">
                        <i class="fa-solid fa-arrows-rotate" wire:loading.remove wire:target="distance"></i>
                        <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="distance"></i>
                    </button>
                </div>
            </div>
            <div class="separator separator-2 border-gray-300 my-3"></div>
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span>Temps de trajet</span>
                <span>{{ convertMinuteToHours($ligne->time_min) }}</span>
            </div>
            <div class="separator separator-2 border-gray-300 my-3"></div>
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span>Prix achat</span>
                <div class="d-flex flex-row align-items-center gap-2">
                    <span>{{ eur($ligne->price) }}</span>
                    <button class="btn btn-xs btn-icon btn-outline btn-outline-primary" wire:click="pricing" data-bs-toggle="tooltip" data-bs-title="Mettre a jour le prix">
                        <i class="fa-solid fa-arrows-rotate" wire:loading.remove wire:target="pricing"></i>
                        <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="pricing"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
