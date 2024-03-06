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
                <a href="{{ route("social.articles.create") }}" class="btn btn-sm btn-light">
                    <i class="fa-solid fa-plus me-2"></i> Nouvelle Page
                </a>
            </div>
        </div>
        <div class="card-body">
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
                                    <a wire:navigate href="{{ route("social.pages.show", $article->id) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir la page">
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
        <div class="card-footer">
            {{ $pages->links() }}
        </div>
    </div>
</div>
