<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Liste des évènements</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addEvent">
                    Nouvelle Évènement
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-row align-items-end mb-5">
                <div class="position-relative w-250px">
                    <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un évènement..." data-kt-search-element="input">
                </div>
            </div>
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                @if(count($events) > 0)
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
                {{ $events->links() }}
                @else
                <x-base.is-null
                    text="Aucun évènement enregistrer" />
                @endif
            </div>

            <div wire:ignore.self class="modal fade" tabindex="-1" data-bs-focus="false" id="addEvent">
                <div class="modal-dialog modal-xl">
                    <form action="" wire:submit="save" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Nouvel évènement</h3>

                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <!--end::Close-->
                            </div>

                            <div class="modal-body">
                                <x-form.input
                                    name="title"
                                    label="Titre de l'évènement"
                                    required="true" />

                                <div class="mb-10">
                                    <label for="type_event" class="form-label required">Type d'évènement</label>
                                    <select id="type_event" wire:model="type_event" name="type_event" class="form-select" data-placeholder="-- Selectionner un type d'article --" data-dropdown-parent="#addEvent" required>
                                        <option value=""></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Social\EventTypeEnum::class)->toArray() as $item)
                                            <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-10">
                                    <label for="cercle_id" class="form-label required">Cercles</label>
                                    <select id="cercle_id" wire:model="cercle_id" name="cercle_id" class="form-select" data-placeholder="-- Selectionner un cercle --" data-dropdown-parent="#addEvent" required>
                                        <option value=""></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forModels(\App\Models\Social\Cercle::all())->toArray() as $item)
                                            <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 mb-10">
                                        <input data-format="datetime" class="form-control" wire:model="star_at" name="start_at" placeholder="Pick a date" required />
                                    </div>
                                    <div class="col-lg-6 col-sm-12 mb-10">
                                        <input data-format="datetime" class="form-control" wire:model="end_at" name="end_at" placeholder="Pick a date" required />
                                    </div>
                                </div>

                                <x-form.textarea
                                    type="simple"
                                    name="synopsis"
                                    label="Synopsis de l'évènement"
                                    required="true" />

                                <x-form.textarea
                                    type="ckeditor"
                                    name="contenue"
                                    label="Contenue de l'évènement"
                                    required="true" />

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermé</button>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push("scripts")
    <x-base.close-modal />
@endpush
