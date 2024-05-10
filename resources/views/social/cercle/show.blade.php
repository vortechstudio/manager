@extends("layouts.app")
@section("title")
    {{ $cercle->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$cercle->name"
        :breads="array('Social', 'Gestion des cercles', $cercle->name)"
        return="true" />

    <div class="row">
        <div class="col-sm-12 col-lg-3 mb-5">
            <div class="card shadow-sm">
                <img src="{{ $cercle->getImage($cercle->id, 'default') }}" class="card-img-top" alt="">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Nombre d'évènements</span>
                        <span class="badge badge-primary">{{ count($cercle->events) }}</span>
                    </div>
                    <div class="separator my-3"></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Nombre d'articles</span>
                        <span class="badge badge-primary">{{ count($cercle->articles) }}</span>
                    </div>
                    <div class="separator my-3"></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Nombre de catégorie de wiki</span>
                        <span class="badge badge-primary">{{ count($cercle->wiki_categories) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-9 mb-5">
            <div class="card shadow-sm" x-data="{card_title: 'Images'}">
                <div class="card-header">
                    <h3 class="card-title" x-text="card_title"></h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#images" x-on:click="card_title = 'Images'">Images</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#events" x-on:click="card_title = 'Évènements'">Évènements</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#articles" x-on:click="card_title = 'Articles'">Articles</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="images" role="tabpanel">
                            <livewire:social.cercle-image :cercle="$cercle" />
                        </div>
                        <div class="tab-pane fade" id="events" role="tabpanel">
                            <livewire:social.event-table :event="$cercle->events" />
                        </div>
                        <div class="tab-pane fade" id="articles" role="tabpanel">
                            <livewire:social.articles :articles="$cercle->articles" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
