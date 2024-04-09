@extends("layouts.app")
@section("title")
    {{ $gare->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="'Gare : ' . $gare->name"
        :breads="array('Railway Manager', 'Gestion des Gares & Hubs', 'Gare : ' . $gare->name)"
        return="true"
        sticky="true" />

    <div class="row">
        <div class="col-sm-12 col-lg-4 mb-5">
            <livewire:railway.hubs.hub-panel-info :gare="$gare" />
        </div>
        <div class="col-sm-12 col-lg-8">
            <div class="card shadow-lg" x-data="{card_title: 'Localisation'}">
                <div class="card-header">
                    <div class="card-title" x-text="card_title"></div>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#map" x-on:click="card_title = 'Localisation'">Localisation</a>
                            </li>
                            @if($gare->is_hub)
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#lignes" x-on:click="card_title = 'Liste des lignes'">Liste des lignes</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="map" role="tabpanel">
                            <x-laravel-map :options="$options" :initial-markers="$initialMarkers" />
                        </div>
                        @if($gare->is_hub)
                            <div class="tab-pane fade" id="lignes" role="tabpanel">
                                <livewire:railway.hubs.hub-ligne-table :gare="$gare" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
