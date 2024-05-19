@extends("layouts.app")
@section("title")
    {{ $achievement->name }}
@endsection

@section("content")
    <x-base.toolbar
        title="Trophée: {{ $achievement->name }}"
        :breads="array('Railway Manager', 'Gestion des Succès & Trophées', 'Trophée: '.$achievement->name)"
        :return="true" />

    <div class="row">
        <div class="col-sm-12 col-lg-4 mb-5">
            <div class="card shadow-sm">
                <img src="{{ $achievement->icon }}" class="card-img-top" alt="">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center border-2 border-bottom-2 border-top-0 border-left-0 border-right-0 border-gray-400 p-5 mb-5">
                        <span class="fw-bold">Secteur</span>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-30px me-3">
                                <img src="{{ $achievement->icon_sector }}" alt="">
                            </div>
                            <span>{{ $achievement->sector }}</span>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center border-2 border-bottom-2 border-top-0 border-left-0 border-right-0 border-gray-400 p-5 mb-5">
                        <span class="fw-bold">Niveau</span>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-30px me-3">
                                <img src="{{ $achievement->icon }}" alt="">
                            </div>
                            <span>{{ $achievement->level }}</span>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-5">
                        <span class="fw-bold">Action</span>
                        <div class="d-flex align-items-center">
                            <span>{{ $achievement->action }}</span>
                            <span class="badge badge-primary ms-3">{{ $achievement->goal }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8 mb-5">
            <livewire:railway.achievement.achievement-panel :achievement="$achievement" />
        </div>
    </div>


@endsection

@push("scripts")
    <script type="text/javascript">

    </script>
@endpush
