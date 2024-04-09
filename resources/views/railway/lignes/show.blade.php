@extends("layouts.app")
@section("title")
    {{ $ligne->name }}
@endsection

@section("content")
    <x-base.toolbar
        title="<i class='fa-solid fa-train text-success me-3'></i> {{ $ligne->name }} <i class='fa-solid fa-train text-danger ms-3'></i>"
        :breads="array('Railway Manager', 'Gestion des Lignes', $ligne->name)"
        sticky="true"
        return="true" />

    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <livewire:railway.ligne.ligne-panel-info :ligne="$ligne" />
        </div>
        <div class="col-sm-12 col-lg-8">
            <div class="card shadow-sm" x-data="{card_title: 'Plan de route'}">
                <div class="card-header">
                    <h3 class="card-title" x-text="card_title"></h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#map" x-on:click="card_title = 'Plan de route'">Plan de route</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#stations" x-on:click="card_title = 'Liste des arrets'">Liste des Arrets</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="map" role="tabpanel">
                            <x-laravel-map :options="$options" :initial-markers="$initialMarkers" />
                        </div>
                        <div class="tab-pane fade" id="stations" role="tabpanel">
                            <livewire:railway.ligne.ligne-station-table :ligne="$ligne" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
