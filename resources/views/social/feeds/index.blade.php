@extends("layouts.app")
@section("title")
    Gestion des articles
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des articles"
        :breads="array('Social', 'Gestion des articles')" />

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Liste des articles et posts des membres</h3>
        </div>
        <div class="card-body">
            <livewire:social.post-table />
        </div>
    </div>
@endsection
