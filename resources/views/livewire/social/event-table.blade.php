<div>
    <div class="d-flex flex-row align-items-end">
        <div class="position-relative w-250px">
            <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un évènement..." data-kt-search-element="input">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
            <thead>
            <tr class="fw-bold fs-3">
                <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="title" :field="$orderField">Titre</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="type_event" :field="$orderField">Type</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="status" :field="$orderField">Status</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="start_at" :field="$orderField">Début évènement</x-base.table-header>
                <x-base.table-header :direction="$orderDirection" name="end_at" :field="$orderField">Fin évènement</x-base.table-header>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->id }}</td>
                    <td>
                        <div class="d-flex flex-row align-items-center">
                            <div class="symbol symbol-70px symbol-2by3 me-5">
                                <img src="{{ \App\Models\Social\Event::getImage($event->id, "default") }}" alt="{{ $event->title }}">
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-bolder">{{ $event->title }}</span>
                                @if($event->cercles()->count() > 0)
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-25px me-3">
                                            <img src="{{ $event->cercles()->first()->cercle_icon }}" alt="{{ $event->cercles()->first()->name }}">
                                        </div>
                                        <span>{{ $event->cercles()->first()->name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        {!! $event->type_label !!}
                    </td>
                    <td>
                        {!! $event->status_label !!}
                    </td>
                    <td>{{ $event->start_at->format('d/m/Y à H:i') }}</td>
                    <td>
                        @if($event->end_at <= now())
                            <div class="d-flex flex-column">
                                <span class="">{{ $event->end_at->format('d/m/Y à H:i') }}</span>
                                <span class="badge badge-light-danger">Fin {{ $event->end_at->diffForHumans() }}</span>
                            </div>
                        @else
                            <span class="">{{ $event->end_at->format('d/m/Y à H:i') }}</span>
                            <span class="badge badge-light-success">Terminer</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('social.events.show', $event->id) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gérer l'évènement">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if($event->status === \App\Enums\Social\EventStatusEnum::DRAFT)
                                <button wire:click="publish({{ $event->id }})" onclick="confirm('Voulez-vous publier cette évènement ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Publier l'évènement">
                                    <i class="fa-solid fa-check-circle" wire:loading.remove wire:target="publish({{ $event->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="publish({{ $event->id }})"></i>
                                </button>
                            @elseif($event->status === \App\Enums\Social\EventStatusEnum::PUBLISHED)
                                <button wire:click="unpublish({{ $event->id }})" onclick="confirm('Voulez-vous dépublier cette évènement ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dépublier l'évènement">
                                    <i class="fa-solid fa-xmark-circle" wire:loading.remove wire:target="unpublish({{ $event->id }})"></i>
                                    <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="unpublish({{ $event->id }})"></i>
                                </button>
                            @endif
                            <a href="{{ route('social.events.edit', $event->id) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edité l'évènement">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button wire:click="destroy({{ $event->id }})" onclick="confirm('Voulez-vous supprimer ce service ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer l'évènement">
                                <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $event->id }})"></i>
                                <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $event->id }})"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $events->links() }}
</div>
