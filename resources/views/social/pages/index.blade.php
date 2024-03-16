@extends("layouts.app")
@section("title")
    Gestion des Pages
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des pages"
        :breads="array('Social', 'Gestion des pages')" />
    <livewire:social.pages />
@endsection
