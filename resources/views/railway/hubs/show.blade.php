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
        <div class="col-sm-12 col-lg-4">
            <livewire:railway.hubs.hub-panel-info :gare="$gare" />
        </div>
        <div class="col-sm-12 col-lg-9"></div>
    </div>
@endsection
