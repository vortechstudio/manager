@extends("layouts.app")
@section("title")
    Gestion des Services de location
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des Services de location"
        :breads="array('Railway Manager', 'Gestion des Services de location')" />

    <livewire:railway.location.location-table />
@endsection
