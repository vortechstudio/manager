<div class="d-flex my-4 gap-4">
    <a href="{{ route('social.events.edit', $event->id) }}" class="btn btn-sm btn-light">Editer</a>

    <button wire:click="destroy({{ $event->id }})" onclick="confirm('Voulez-vous supprimer ce service ?') || event.stopImmediatePropagation()" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer l'évènement">
        <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $event->id }})"></i>
        <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $event->id }})"></i>
    </button>
    <!--begin::Menu-->
    <div class="me-0">
        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <i class="ki-solid ki-dots-horizontal fs-2x"></i>
        </button>

        <!--begin::Menu 3-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
            <!--begin::Heading-->
            <div class="menu-item px-3">
                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                    Actions
                </div>
            </div>
            <!--end::Heading-->

            @if($event->status === \App\Enums\Social\EventStatusEnum::DRAFT)
                <div class="menu-item px-3">
                    <a href="" wire:click="publish" class="menu-link text-success px-3">
                        Publier l'évènement
                    </a>
                </div>
            @elseif($event->status === \App\Enums\Social\EventStatusEnum::PUBLISHED)
                <div class="menu-item px-3">
                    <a href="" wire:click="unpublish" class="menu-link text-danger px-3">
                        Dépublier l'évènement
                    </a>
                </div>
            @endif
        </div>
        <!--end::Menu 3-->
    </div>
    <!--end::Menu-->
</div>
