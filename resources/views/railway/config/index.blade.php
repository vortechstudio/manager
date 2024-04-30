@extends("layouts.app")
@section("title")
    Gestion des Configurations
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des Configurations"
        :breads="array('Railway Manager', 'Gestion des Configurations')" />

    <livewire:railway.config.config-table />
@endsection

@push("scripts")
    <script type="text/javascript">

    </script>
@endpush
