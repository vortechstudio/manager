@extends("layouts.app")
@section("title")
    {{ $location->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$location->name"
        :breads="array('Railway Manager', 'Gestion des Services de location', $location->name)"
        return="true"
        sticky="true" />

    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <div class="card shadow-sm">
                <img src="{{ $location->image }}" alt="{{ $location->name }}">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Nom du service</span>
                        <span>{{ $location->name }}</span>
                    </div>
                    <div class="separator separator-2 border-gray-300 my-3"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Durée des contrats</span>
                        <span>{{ $location->contract_duration }} {{ Str::plural('semaine', $location->contract_duration) }}</span>
                    </div>
                    <div class="separator separator-2 border-gray-300 my-3"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Type de matériel</span>
                        <div class="d-flex flex-row gap-3">
                            @foreach(json_decode($location->type, true) as $type)
                                <div class="symbol symbol-30px symbol-2by3">
                                    <img src="{{ Storage::url('icons/railway/transport/logo_'.$type.'.svg') }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Mise à jour du logo du service</h3>
                </div>
                <form action="{{ route('upload', ['type' => 'rental', 'model' => $location]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <x-form.image-input
                            name="file"
                            :default="$location->image"
                            width="w-100" />

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push("scripts")
    <script type="text/javascript">

    </script>
@endpush
