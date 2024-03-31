<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="position-relative">
                    <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un service..." data-kt-search-element="input">
                </div>
            </div>
            <div class="card-toolbar">
                <button wire:click="$toggle('showModal')" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#serviceForm">Nouveau service</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                <thead>
                <tr class="fw-bold fs-3">
                    <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                    <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                    <x-base.table-header :direction="$orderDirection" name="type" :field="$orderField">Type</x-base.table-header>
                    <x-base.table-header :direction="$orderDirection" name="status" :field="$orderField">Status</x-base.table-header>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>
                            <div class="d-flex flex-row align-items-center">
                                <div class="symbol symbol-70px symbol-2by3 me-5">
                                    <img src="{{ App\Models\Config\Service::getImage($service->id, 'default') }}" alt="{{ $service->title }}">
                                </div>
                                <span class="fw-bolder text-light">{{ $service->name }}</span>
                            </div>
                        </td>
                        <td >
                            {!! $service->type_label !!}
                        </td>
                        <td>{!! $service->status_label !!}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('social.services.show', $service->id) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gérer le service">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @if($service->status == 'idea')
                                    <button wire:click="transfer({{ $service->id }}, 'develop')" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Transférer le service">
                                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                    </button>
                                @elseif($service->status == 'develop')
                                    <button wire:click="transfer({{ $service->id }}, 'production')" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Transférer le service">
                                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                    </button>
                                @endif
                                <button wire:click="edit({{ $service->id }})" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#serviceForm">
                                    <i class="fa-solid fa-edit"></i>
                                </button>
                                <button wire:click="destroy({{ $service->id }})" onclick="confirm('Voulez-vous supprimer ce service ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer le service">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $services->links() }}
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="serviceForm">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit="save" wire:loading.class="bg-gray-700">
                    <div class="modal-header">
                        <h3 class="modal-title">{{ $serviceId ? "Modification du service" : "Nouveau service" }}</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            label="Nom du service"
                            required="true" />

                        <x-form.input
                            name="url"
                            label="Url du projet" />

                        <div class="mb-10">
                            <label for="type" class="form-label required">Type</label>
                            <div wire:ignore>
                                <select id="type" wire:model="type" name="type" class="form-select" data-control="select2" data-placeholder="-- Selectionner un type de service --">
                                    <option value=""></option>
                                    @foreach($types as $item)
                                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-10">
                            <label for="status" class="form-label required">Status</label>
                            <div wire:ignore>
                                <select id="status" wire:model="status" name="status" class="form-select" data-control="select2" data-placeholder="-- Selectionner un type de service --">
                                    <option value=""></option>
                                    @foreach($statuses as $item)
                                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <x-form.textarea
                            type="simple"
                            name="description"
                            label="Description du service"
                            required="true" />

                        <x-form.textarea
                            type="laraberg"
                            name="page_content"
                            label="Contenue de la page" />


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermé</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
                <div wire:loading>
                    <div class="modal-body">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push("scripts")
    <script type="text/javascript">
        $("#type").on('change', e => {
            @this.set('type', $("#type").select2("val"))
        })

        $("#status").on('change', e => {
            @this.set('status', $("#status").select2("val"))
        })
    </script>
@endpush
