<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">
            <span class="me-5">{{ $gare->name }}</span>
            @if($gare->is_hub)
                <span class="me-2" data-bs-toggle="tooltip" data-bs-original-title="Est un hub">
                    <i class="fa-solid fa-building-circle-check text-success fs-2x"></i>
                </span>
                {!! $gare->hub->is_active_label !!}
            @endif
        </h3>
        <div class="card-toolbar">
            @if($gare->is_hub)
                @if($gare->hub->status->value == 'beta')
                    <button wire:click="production" class="btn btn-sm btn-icon btn-outline btn-outline-info me-2" data-bs-toggle="tooltip" data-bs-original-title="Passer en production">
                        <i class="fa-solid fa-boxes"></i>
                    </button>
                @endif
                @if($gare->hub->active)
                    <button wire:click="disabled" class="btn btn-sm btn-icon btn-outline btn-outline-danger me-2" data-bs-toggle="tooltip" data-bs-original-title="Désactiver le hub">
                        <i class="fa-solid fa-times-circle"></i>
                    </button>
                @else
                    <button wire:click="enabled" class="btn btn-sm btn-icon btn-outline btn-outline-success me-2" data-bs-toggle="tooltip" data-bs-original-title="Activer le hub">
                        <i class="fa-solid fa-check-circle"></i>
                    </button>
                @endif
            @endif
            <button wire:click="delete" class="btn btn-sm btn-icon btn-danger me-2" data-bs-toggle="tooltip" data-bs-original-title="Supprimer la gare">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex flex-column">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span class="fw-bold">Type de gare</span>
                <span>{{ $gare->type_gare_string }}</span>
            </div>
            <div class="separator separator-2 border-gray-300 my-3"></div>
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span class="fw-bold">Coordonnées</span>
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row align-items-center mb-1">
                        <i class="fa-solid fa-map-marker me-1"></i>
                        <span>{{ $gare->city }},</span>
                        <span>{{ $gare->pays }}</span>
                    </div>
                </div>
            </div>
            <div class="separator separator-2 border-gray-300 my-3"></div>
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span class="fw-bold">Fréquence de base</span>
                <span>{{ number_format(intval($gare->freq_base / 365), 0, ',', ' ') }} / par jour</span>
            </div>
            <div class="separator separator-2 border-gray-300 my-3"></div>
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span class="fw-bold">NB Habitant</span>
                <span>{{ number_format($gare->hab_city, 0, ',', ' ') }} </span>
            </div>
        </div>
    </div>
    <div class="card-footer">
        @foreach(json_decode($gare->equipements, true) as $equipement)
            <i class="fa-solid {{ $gare->getTypeEquipementIconAttribute($equipement)  }} fs-2x text-success me-2" data-bs-toggle="tooltip" data-bs-original-title="{{ $gare->getTypeEquipementStringAttribute($equipement) }}"></i>
        @endforeach
        <div class="separator separator-2 border-gray-300 my-3"></div>
        @foreach(json_decode($gare->transports, true) as $transport)
            <div class="symbol symbol-50px symbol-2by3 me-2">
                <img src="{{ Storage::url('icons/railway/transport/logo_'.$transport.'.svg') }}" alt="">
            </div>
        @endforeach
    </div>
</div>
