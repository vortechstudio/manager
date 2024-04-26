@extends("layouts.app")
@section("title")
    Gestion des Bonus Journaliers
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des Bonus Journaliers"
        :breads="array('Railway Manager', 'Gestion des Bonus Journaliers')" />

    <div>
        <div class="rounded bg-white mb-10">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 p-5">
                @foreach($bonuses as $bonus)
                    <div class="card shadow-lg w-150px h-250px mb-10">
                        <div class="card-body">
                            <div class="d-flex flex-column-fluid justify-content-center align-items-center m-0 bg-gray-300 rounded-4 h-50px">
                                <img src="{{ $bonus->icon }}" alt="" class="h-75">
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center h-75 m-auto">
                                {{ $bonus->designation }}
                            </div>
                        </div>
                        <div class="card-footer bg-grey-800 text-white">
                            <div class="d-flex flex-column-fluid justify-content-center align-items-center m-auto">
                                <span class="text-center fw-bold">Jour {{ $bonus->number_day }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
