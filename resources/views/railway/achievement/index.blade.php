@extends("layouts.app")
@section("title")
    Gestion des Succès & Trophées
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des Succès & Trophées"
        :breads="array('Railway Manager', 'Gestion des Succès & Trophées')" />

    <livewire:railway.achievement.achievement-table />

@endsection

@push("scripts")
    <script type="text/javascript">

    </script>
@endpush
