<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="position-relative">
                    <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher un article..." data-kt-search-element="input">
                </div>
            </div>
            <div class="card-toolbar">
                <button data-bs-toggle="modal" data-bs-target="#addArticle" class="btn btn-sm btn-light">
                    <i class="fa-solid fa-plus me-2"></i> Nouvelle article
                </button>
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
                                        <img src="{{ $article->image }}" alt="{{ $article->title }}">
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
                                    <a wire:navigate href="{{ route("social.articles.show", $article->id) }}" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir l'article">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @if($article->published)
                                        <a href="" wire:click="unpublished({{ $article->id }})" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Dépublier l'article">
                                            <i class="fa-solid fa-xmark"></i>
                                        </a>
                                    @else
                                        <a href="" wire:click="published({{ $article->id }})" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Publier l'article">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    @endif
                                    <a wire:navigate href="{{ route('social.articles.edit', $article->id) }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editer l'article">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <a href="" wire:click="destroy({{ $article->id }})" class="btn btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Supprimer l'article">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $articles->links() }}
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="addArticle">
        <form action="" method="post" wire:submit="save" enctype="multipart/form-data">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouvelle article</h3>

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
                                    label="Titre"
                                    required="true" />

                                <x-form.textarea
                                    name="description"
                                    label="Courte Description de l'article (Introduction)" />

                                <x-form.textarea
                                    type="ckeditor"
                                    name="contenue"
                                    label="Contenue de l'article"
                                    required="true" />
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <div class="mb-10">
                                    <label for="cercle_id" class="form-label required">Cercle</label>
                                    <select name="cercle_id" wire:model="cercle_id" id="cercle_id" class="form-select" data-control="select2" data-placeholder="---  Selectionner un cercle ---" required>
                                        <option></option>
                                        @foreach(\App\Models\Social\Cercle::all() as $cercle)
                                            <option value="{{ $cercle->id }}">{{ $cercle->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-10">
                                    <label for="type" class="form-label required">Type d'article</label>
                                    <select name="type" wire:model="type" id="type" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type d'article ---" required>
                                        <option></option>
                                        @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Social\ArticleTypeEnum::class)->toArray() as $type)
                                            <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-10">
                                    <label for="author" class="form-label required">Auteur de l'article</label>
                                    <select name="author" wire:model="author" id="author" class="form-select" data-control="select2" data-placeholder="---  Selectionner un auteur ---" required>
                                        <option></option>
                                        @foreach(\App\Models\User\User::where('admin', true)->get() as $user)
                                            <option value="{{ $user->id }}" data-avatar="{{ $user->socials()->first()->avatar }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="separator border border-2 border-gray-300 my-5"></div>
                                <div class="d-flex flex-row justify-content-between align-items-center mb-10">
                                    <x-form.checkbox
                                        name="promote"
                                        label="Promouvoir l'article" />
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
