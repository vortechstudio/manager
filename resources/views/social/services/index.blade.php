@extends("layouts.app")
@section("title")
    Gestion des services
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des services"
        :breads="array('Social', 'Gestion des services')" />
    <livewire:social.service />
@endsection
