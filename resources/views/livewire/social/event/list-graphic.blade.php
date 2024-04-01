<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Liste des Médias soumis</h3>
        @if($event->graphics()->count() > 0)
            <div class="card-toolbar gap-2">
                <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px" id="perPage">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        @endif
    </div>
    <div class="card-body">
        @if($event->graphics()->count() > 0)
            <div class="table-responsive">
                <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info  rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                    <thead>
                    <tr class="fw-bold fs-3">
                        <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="media" :field="$orderField">Média</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="type_media" :field="$orderField">Type</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Membre</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="notation" :field="$orderField">Note</x-base.table-header>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($graphics as $graphic)
                        <tr>
                            <td>{{ $graphic->id }}</td>
                            <td>
                                <a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ $graphic->link_storage }}">
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-100px"
                                         style="background-image:url('{{ $graphic->link_storage }}')">
                                    </div>
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                        <i class="bi bi-eye-fill text-white fs-3x"></i>
                                    </div>
                                </a>
                            </td>
                            <td>{{ $graphic->type_media }}</td>
                            <td>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-30px symbol-circle me-5">
                                        <img src="{{ $graphic->user->socials()->first()->avatar }}" alt="{{ $graphic->user->name }}">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bolder">{{ $graphic->user->name }}</span>
                                        <div class="text-muted">Tag #{{ shortUserTag($graphic->user->uuid) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{!! $graphic->format_note !!}</td>
                            <td>
                                @if($event->status == \App\Enums\Social\EventStatusEnum::EVALUATION)
                                    <a href="{{ route('social.events.graphics.evaluate', [$event->id, $graphic->id]) }}" class="btn btn-icon btn-sm btn-info" data-bs-toggle="tooltip" data-bs-title="Evaluer la publication">
                                        <i class="bi bi-patch-check-fill"></i>
                                    </a>
                                @endif
                                    <button wire:click="destroy({{ $graphic->id }})" onclick="confirm('Voulez-vous supprimer ce média ?') || event.stopImmediatePropagation()" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le média">
                                        <i class="fa-solid fa-trash" wire:loading.remove wire:target="destroy({{ $graphic->id }})"></i>
                                        <i class="fa-solid fa-spinner fa-spin-pulse" wire:loading wire:target="destroy({{ $graphic->id }})"></i>
                                    </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-base.is-null
                text="Aucun participant" />
        @endif
    </div>
    <div class="card-footer">
        {{ $graphics->links() }}
    </div>
</div>
@push('scripts')
    <script src="{{ asset('/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

@endpush
