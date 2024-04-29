<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title"></div>
            <div class="card-toolbar">
                <button wire:click="$toggle('showModal')" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#cercleForm">Nouveau cercle</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5">
                <thead>
                <tr class="fw-bold fs-3">
                    <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                    <x-base.table-header :direction="$orderDirection" name="name" :field="$orderField">Désignation</x-base.table-header>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($cercles as $cercle)
                    <tr>
                        <td>{{ $cercle->id }}</td>
                        <td>
                            <div class="d-flex flex-row align-items-center">
                                <div class="symbol symbol-70px symbol-2by3 me-5">
                                    <img src="{{ \App\Models\Social\Cercle::getImage($cercle->id, 'icon') }}" alt="{{ $cercle->name }}">
                                </div>
                                <span class="fw-bolder text-light">{{ $cercle->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button wire:click="edit({{ $cercle->id }})" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#cercleForm">
                                    <i class="fa-solid fa-edit"></i>
                                </button>
                                <button wire:click="destroy({{ $cercle->id }})" onclick="confirm('Voulez-vous supprimer ce cercle ?') || event.stopImmediatePropagation()" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer l'article">
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
            {{ $cercles->links() }}
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="cercleForm">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit="save" wire:loading.class="bg-gray-700">
                    <div class="modal-header">
                        <h3 class="modal-title">{{ $cercle_id ? "Modification du cercle" : "Nouveau cercle" }}</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            label="Nom du cercle"
                            required="true" />
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
