@extends("layouts.app")
@section("title")
    {{ $article->title }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$article->title"
        :breads="array('Social', 'Articles', $article->title)"
        return="true"
        sticky="true"
        :actions="[
            [
                'link' => route('social.articles.edit', $article->id),
                'text' => 'Editer',
                'color' => 'info'
            ],
            [
                'link' => $article->status != 'published' ? route('social.articles.publish', $article->id) : route('social.articles.unpublish', $article->id),
                'text' => $article->status != 'published' ? 'Publier' : 'Dépublier',
                'color' => $article->status != 'published' ? 'success' : 'danger'
            ],
        ]"
    />

    <div class="row">
        <div class="col-sm-12 col-lg-4 mb-10">
            <div class="card shadow-sm">
                <img src="{{ $article->image }}" class="card-img-top" alt="{{ $article->title }}">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Cercle</span>
                        <div class="d-flex flex-row align-items-center">
                            <div class="symbol symbol-30px symbol-circle me-3">
                                <img src="{{ $article->cercle->cercle_icon }}" alt="{{ $article->cercle->name }}">
                            </div>
                            <span>{{ $article->cercle->name }}</span>
                        </div>
                    </div>
                    <div class="separator border-3 border-gray-300 my-5"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Type</span>
                        <span>{{ $article->type }}</span>
                    </div>
                    <div class="separator border-3 border-gray-300 my-5"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Auteur</span>
                        <div class="d-flex flex-row align-items-center">
                            <div class="symbol symbol-30px symbol-circle me-3">
                                <img src="{{ $article->author()->first()->socials()->first()->avatar }}"
                                     alt="{{ $article->author()->first()->name }}">
                            </div>
                            <span>{{ $article->author()->first()->name }}</span>
                        </div>
                    </div>
                    <div class="separator border-3 border-gray-300 my-5"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Etat</span>
                        @if($article->published)
                            <span class="badge badge-success">Publier</span>
                        @else
                            <span class="badge badge-danger">Non Publier</span>
                        @endif
                    </div>
                    <div class="separator border-3 border-gray-300 my-5"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Publié sur les réseaux</span>
                        @if($article->publish_social)
                            <span class="badge badge-success">Publier</span>
                        @else
                            <span class="badge badge-danger">Non Publier</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8 mb-10">
            <div class="card shadow-sm">
                <div class="card-header card-header-stretch">
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#post">Article</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#stat">Statistiques</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#images">Images</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="post" role="tabpanel">
                            <p class="fst-italic mb-5">{!! $article->description !!}</p>
                            <img src="{{ $article->image_head }}" alt="{{ $article->title }}" class="img-thumbnail">
                            <div class="separator separator-dashed separator-content border-primary my-15">
                                <i class="fa-solid fa-newspaper fs-1 text-primary"></i>
                            </div>
                            {!! $article->contenue !!}
                        </div>

                        <div class="tab-pane fade" id="stat" role="tabpanel">
                            ...
                        </div>
                        <div class="tab-pane fade" id="images" role="tabpanel">
                            <livewire:social.article-tab-image :article="$article" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
