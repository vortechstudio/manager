@extends("layouts.app")
@section("title")
    Création d'un service de location
@endsection

@section("content")
    <form action="{{ route('railway.location.store') }}" method="POST">
        @csrf
        <x-base.toolbar
            title="Création d'un service de location"
            :breads="array('Railway Manager', 'Gestion des Services de location', 'Création d\'un service de location')"
            submit="true"
            return="true"
            sticky="true" />

        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-9">
                        <x-form.input
                            name="name"
                            label="Nom du service de location"
                            required="true" />
                    </div>

                    <div class="col-sm-12 col-lg-3">
                        <x-form.input
                            name="contract_duration"
                            label="Durée du contrat"
                            required="true"
                            hint="En semaine pleine" />
                    </div>
                </div>

                <div class="mb-10">
                    <label for="type" class="form-label required">Type de matériel acceptée</label>
                    <select name="type[]" id="type" class="form-select" data-control="select2" multiple="multiple" data-allow-clear="true" data-close-on-select="false" data-placeholder="---  Selectionner un type de matériel ---" required>
                        <option></option>
                        <option value="ter" data-select-image="{{ Storage::url('icons/railway/transport/logo_ter.svg') }}">TER</option>
                        <option value="tgv" data-select-image="{{ Storage::url('icons/railway/transport/logo_tgv.svg') }}">TGV</option>
                        <option value="intercity" data-select-image="{{ Storage::url('icons/railway/transport/logo_intercity.svg') }}">INTERCITE</option>
                        <option value="tram" data-select-image="{{ Storage::url('icons/railway/transport/logo_tram.svg') }}">TRAM</option>
                        <option value="metro" data-select-image="{{ Storage::url('icons/railway/transport/logo_metro.svg') }}">METRO</option>
                        <option value="other" data-select-image="{{ Storage::url('icons/railway/transport/default.png') }}">AUTRE</option>
                    </select>
                </div>


            </div>
        </div>
    </form>


@endsection

@push("scripts")
    <script type="text/javascript">
        let formatOption = function (item) {
            if ( !item.id ) {
                return item.text;
            }
            let span = document.createElement('span');
            let imgUrl = item.element.getAttribute('data-select-image');
            let template = '';

            template += '<img src="' + imgUrl + '" class="rounded-circle h-20px w-20px me-2" alt="image"/>';
            template += item.text;

            span.innerHTML = template;

            return $(span);
        }

        $("#type").select2({
            templateSelection: formatOption,
            templateResult: formatOption
        })
    </script>
@endpush
