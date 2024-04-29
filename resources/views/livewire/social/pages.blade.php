<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="position-relative">
                    <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher une page..." data-kt-search-element="input">
                </div>
            </div>
            <div class="card-toolbar">
                <a data-bs-toggle="modal" href="#addPage" class="btn btn-sm btn-light">
                    <i class="fa-solid fa-plus me-2"></i> Nouvelle Page
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5">
                    <thead>
                    <tr class="fw-bold fs-3">
                        <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="title" :field="$orderField">Titre</x-base.table-header>
                        <th>Auteur</th>
                        <x-base.table-header :direction="$orderDirection" name="updated_at" :field="$orderField">Date</x-base.table-header>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($pages->total() > 0)
                        @foreach($pages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>
                                    <span class="fw-bolder text-light">{{ $page->translateOrDefault(app()->getLocale())->title }}</span>
                                </td>
                                <td>

                                </td>
                                <td>
                                    {{ $page->created_at->format("d/m/Y à H:i") }}
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a wire:navigate href="{{ route("social.pages.show", $page->id) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir la page">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        @if($page->published)
                                            <a href="" wire:click="unpublished({{ $page->id }})" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dépublier la page">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        @else
                                            <a href="" wire:click="published({{ $page->id }})" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Publier la page">
                                                <i class="fa-solid fa-check"></i>
                                            </a>
                                        @endif
                                        <a wire:navigate href="{{ route('social.pages.edit', $page->id) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editer la page">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <a href="" wire:click="destroy({{ $page->id }})" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer la page">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">
                                <x-base.is-null
                                    text="Aucune page définie actuellement !" />
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $pages->links() }}
        </div>
    </div>
    <div class="modal fade" wire:ignore.self tabindex="-1" id="addPage">
        <form action="" wire:submit="save" method="POST">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouvelle Page</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-9">
                                <x-form.input
                                    name="title"
                                    label="Titre de la page"
                                    required="true" />

                                <x-form.textarea
                                    type="simple"
                                    name="description"
                                    label="Courte description de la page" />

                                <x-form.textarea
                                    type="ckeditor"
                                    name="content"
                                    label="Contenue de la page"
                                    required="true" />
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <div class="mb-10" wire:ignore>
                                    <label for="keywords" class="form-label">Mots clefs</label>
                                    <input id="keywords" type="text" wire:model="keywords" name="keywords" class="form-control">
                                </div>
                                <div class="mb-10">
                                    <label for="author" class="form-label required">Auteur de la page</label>
                                    <select name="author" wire:model="author" id="author" class="form-select" data-control="select2" data-placeholder="---  Selectionner un auteur ---" required>
                                        <option></option>
                                        @foreach(\App\Models\User\User::where('admin', true)->get() as $user)
                                            <option value="{{ $user->id }}" data-avatar="{{ $user->socials()->first()->avatar }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-10">
                                    <x-form.switches
                                        name="published"
                                        label="Publié la page"
                                        value="1"
                                        class-check="primary" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="resetForm">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save"><i class="fa-solid fa-check-circle me-3"></i> Enregistrer</span>
                            <span wire:loading wire:target="save"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push("scripts")
    <x-base.close-modal />
    <x-script.select2.base />
    <x-script.select2.with-image name="author" />
@endpush
