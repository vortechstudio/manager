<div>
    <a href="{{ route('railway.materiels.edit', $engine) }}" class="btn btn-sm btn-icon btn-outline btn-outline-primary" data-bs-toggle="tooltip" data-bs-title="Editer le matériel"><i class="fa fa-edit"></i></a>
    <button @if($engine->active) wire:click="disabled" @else wire:click="enabled" @endif class="btn btn-sm btn-icon {{ $engine->active ? 'btn-outline btn-outline-danger' : 'btn-outline btn-outline-success' }}" data-bs-toggle="tooltip" data-bs-title="{{ $engine->active ? 'Inactiver le système' : 'Activer le système' }}">
        <i class="fa-solid {{ $engine->active ? 'fa-times' : 'fa-check' }}" wire:loading.remove wire:target="{{ $engine->active ? 'disabled' : 'enabled' }}"></i>
        <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="{{ $engine->active ? 'disabled' : 'enabled' }}"></i>
    </button>
    @if($engine->visual == 'beta')
        <button wire:click="production" wire:confirm="Voulez-vous passer ce matériel roulant en production ?" class="btn btn-sm btn-icon btn-outline btn-outline-info" data-bs-toggle="tooltip" data-bs-title="Passage en production">
            <i class="fa-solid fa-boxes" wire:loading.remove wire:target="production"></i>
            <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="production"></i>
        </button>
    @endif
    <button wire:click="delete" wire:confirm="Voulez-vous supprimer ce matériel roulant ?" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-title="Supprimer le matériel">
        <i class="fa-solid fa-trash" wire:loading.remove wire:target="delete"></i>
        <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="delete"></i>
    </button>
</div>
