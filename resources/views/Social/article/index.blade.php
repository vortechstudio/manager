@extends("layouts.app")

@section("content")
    <x-base.toolbar
        title="Gestion des articles"
        :breads="array('Social', 'Gestion des articles')" />
    <livewire:social.articles />
@endsection
