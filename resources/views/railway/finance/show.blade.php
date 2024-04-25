@extends("layouts.app")
@section("title")
    {{ $banque->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$banque->name"
        :breads="array('Railway Manager', 'Gestion des Services bancaires', $banque->name)"
        return="true"
        sticky="true" />

    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <div class="card shadow-sm">
                <img src="{{ $banque->image }}" alt="{{ $banque->name }}">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Nom du service</span>
                        <span>{{ $banque->name }}</span>
                    </div>
                    <div class="separator separator-2 border-gray-300 my-3"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Mise à jour du logo du service</h3>
                </div>
                <form action="{{ route('upload', ['type' => 'banque', 'model' => $banque]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <x-form.image-input
                            name="file"
                            :default="$banque->image"
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
