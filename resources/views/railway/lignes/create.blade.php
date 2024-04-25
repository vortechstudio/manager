@extends("layouts.app")
@section("title")
    Création d'une ligne
@endsection

@section("content")
    <form action="{{ route('railway.lignes.store') }}" method="POST">
        @csrf
        <x-base.toolbar
            title="Gestion des Lignes"
            :breads="array('Railway Manager', 'Gestion des Lignes', 'Création d\'une ligne')"
            return="true"
            sticky="true"
            submit="true" />

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="mb-10">
                    <label for="railway_hub_id" class="form-label required">Hub Affilier</label>
                    <select name="railway_hub_id" id="railway_hub_id" class="form-select" data-control="select2" data-placeholder="---  Selectionner un hub ---" required>
                        <option></option>
                        @foreach(\App\Models\Railway\Gare\RailwayHub::where('active', true)->get() as $hub)
                            <option value="{{ $hub->id }}">{{ $hub->gare->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="mb-10">
                            <label for="start_gare_id" class="form-label required">Gare de départ</label>
                            <select name="start_gare_id" id="start_gare_id" class="form-select" data-control="select2" data-placeholder="---  Selectionner une gare ---" required>
                                <option></option>
                                @foreach(\App\Models\Railway\Gare\RailwayGare::all() as $gare)
                                    <option value="{{ $gare->id }}">{{ $gare->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="mb-10">
                            <label for="end_gare_id" class="form-label required">Gare d'arrivée</label>
                            <select name="end_gare_id" id="end_gare_id" class="form-select" data-control="select2" data-placeholder="---  Selectionner une gare ---" required>
                                <option></option>
                                @foreach(\App\Models\Railway\Gare\RailwayGare::all() as $gare)
                                    <option value="{{ $gare->id }}">{{ $gare->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row gap-5">
                    <x-form.switches
                        name="active"
                        label="Activer la ligne" />

                    <div class="mb-10">
                        <label for="status" class="form-label required">Status de la ligne</label>
                        <select name="status" id="status" class="form-select" data-control="select2" data-placeholder="---  Selectionner un status ---" required>
                            <option></option>
                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Ligne\LigneStatusEnum::class)->toArray() as $status)
                                <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-10">
                        <label for="type" class="form-label required">Type de Ligne</label>
                        <select name="type" id="type" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de ligne ---" required>
                            <option></option>
                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Ligne\LigneTypeEnum::class)->toArray() as $type)
                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push("scripts")
    <script type="text/javascript">
        document.querySelectorAll("[data-control='select2']").forEach(select => {
            $(select).select2()
        })
    </script>
@endpush
