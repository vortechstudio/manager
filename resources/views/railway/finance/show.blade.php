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
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Intêret</span>
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-end">
                                <span class="fw-bold me-2">Interet Min:</span>
                                <span>{{ number_format($banque->interest_min, 2, '.', ' ')." %" }}</span>
                            </div>
                            <div class="d-flex justify-content-end">
                                <span class="fw-bold me-2">Interet Max:</span>
                                <span>{{ number_format($banque->interest_max, 2, '.', ' ')." %" }}</span>
                            </div>
                            <div class="d-flex justify-content-end">
                                <span class="fw-bold me-2">Interet Actuel:</span>
                                <span class="badge badge-primary">{{ number_format($banque->latest_flux->interest, 2, '.', ' ')." %" }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-2 border-gray-300 my-3"></div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="fw-bold">Emprunt disponible</span>
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-end">
                                <span class="fw-bold me-2">Emprunt express:</span>
                                <span>{{ eur($banque->express_base) }}</span>
                            </div>
                            <div class="d-flex justify-content-end">
                                <span class="fw-bold me-2">Emprunt marché financier:</span>
                                <span>{{ eur($banque->public_base) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8">
            <div class="card shadow-sm" x-data="{card_title: 'Mise à jour du logo du service'}">
                <div class="card-header">
                    <h3 class="card-title" x-text="card_title"></h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#update" x-on:click="card_title = 'Mise à jour du logo du service'">Mise à jour du logo du service</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#stats" x-on:click="card_title = 'Statistique des flux des interets'">Statistique des flux des interets</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="update" role="tabpanel">
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
                    <div class="tab-pane fade" id="stats" role="tabpanel">
                        <div class="card-body">
                            <livewire:railway.finance.stat-flux
                                :banque="$banque" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
