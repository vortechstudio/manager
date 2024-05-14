@extends("layouts.app")
@section("title")
    Service de messagerie
@endsection

@section("content")
    <x-base.toolbar
        title="Service de messagerie"
        :breads="array('Social', 'Service de messagerie')" />

    <livewire:social.messagerie.messagerie-table />
@endsection
