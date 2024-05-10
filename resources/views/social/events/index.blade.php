@extends("layouts.app")
@section("title")
    Gestion des Évènements
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des évènements"
        :breads="array('Social', 'Gestion des évènements')" />

    <livewire:social.event-table />
@endsection
