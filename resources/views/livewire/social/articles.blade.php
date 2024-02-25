<div>
    <x-base.toolbar
        title="Gestion des articles"
        :breads="array('Social', 'Gestion des articles')" />

    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="position-relative">
                    <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un article..." data-kt-search-element="input">
                </div>
            </div>
            <div class="card-toolbar">
                <a href="{{ route("social.articles.create") }}" class="btn btn-sm btn-light">
                    <i class="fa-solid fa-plus me-2"></i> Nouvelle article
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5">
                <thead>
                    <tr class="fw-bold fs-3">
                        <x-base.table-header :direction="$orderDirection" name="id" :field="$orderField">#</x-base.table-header>
                        <x-base.table-header :direction="$orderDirection" name="title" :field="$orderField">Titre</x-base.table-header>
                        <th>Cercle</th>
                        <th>Auteur</th>
                        <x-base.table-header :direction="$orderDirection" name="updated_at" :field="$orderField">Date</x-base.table-header>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-70px symbol-2by3 me-5">
                                        <img src="{{ Storage::disk('vortech')->url("blog/$article->id/default.webp") }}" alt="{{ $article->title }}">
                                    </div>
                                    <span class="fw-bolder text-light">{{ $article->title }}</span>
                                </div>
                            </td>
                            <td >
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-30px symbol-circle me-3">
                                        <img src="{{ $article->cercle->cercle_icon }}" alt="">
                                    </div>
                                    <span>{{ $article->cercle->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="symbol symbol-30px symbol-circle me-3">
                                        @isset($article->author()->first()->socials()->first()->avatar)
                                            <img src="{{ $article->author()->first()->socials()->first()->avatar }}" alt="{{ $article->author()->first()->name }}">
                                        @else
                                            <span class="symbol-label text-primary">{{Str::limit($article->author()->first()->name, 2, '') }}</span>
                                        @endif
                                    </div>
                                    <span>{{ $article->author()->first()->name }}</span>
                                </div>
                            </td>
                            <td>
                                @if($article->published)
                                    Publié le {{ $article->published_at->format("d/m/Y à H:i") }}
                                @else
                                    Mise à jour le {{ $article->updated_at->format("d/m/Y à H:i") }}
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir l'article">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if($article->published)
                                        <a href="" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dépublier l'article">
                                            <i class="fa-solid fa-xmark"></i>
                                        </a>
                                    @else
                                        <a href="" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Publier l'article">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    @endif
                                    <a href="" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editer l'article">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <a href="" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer l'article">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $articles->links() }}
        </div>
    </div>
</div>
