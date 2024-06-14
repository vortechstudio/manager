@extends("layouts.app")
@section("title")
    {{ $research->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$research->name"
        :breads="array('Railway Manager', 'Gestion des recherches & Développements', $research->railwayResearchCategory->name, $research->name)"
        :return="true" />

        <div class="row">
            <div class="col-sm-12 col-lg-3 mb-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-center flex-column mb-5">
                            <div class="symbol symbol-100px symbol-circle border border-gray-400">
                                <img src="{{ $research->image }}" alt="">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Désignation</span>
                            <span>{{ $research->name }}</span>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">Catégorie</span>
                            <span>{{ $research->railwayResearchCategory->name }}</span>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">Cout de base</span>
                            <span>{{ Helpers::eur($research->cost) }}</span>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">Nombre de Niveau</span>
                            <span>{{ $research->level }}</span>
                        </div>
                        @if($research->parent)
                            <div class="separator separator-dashed my-3"></div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Parent</span>
                                <span>{{ $research->parent->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-9 mb-5">
                <div class="card shadow-sm" x-data="{card_title: 'Bénéfice'}">
                    <div class="card-header">
                        <h3 class="card-title" x-text="card_title"></h3>
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#benefits" x-on:click="card_title = 'Bénéfice'">Bénéfices</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#users" x-on:click="card_title = 'Utilisateurs'">Utilisateurs</a>
                                </li>
                                @if($research->hasChildrens())
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#childrens" x-on:click="card_title = 'Enfants'">Enfants</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="benefits" role="tabpanel">
                                @livewire('railway.research.research-benefits-table', ['researches' => $research])
                            </div>
                            <div class="tab-pane fade" id="users" role="tabpanel">
                                @livewire('user.user-table', ['action' => false, 'type' => 'research'])
                            </div>
                            <div class="tab-pane fade" id="childrens" role="tabpanel">
                                @livewire('railway.research.research-table', ['category' => $research->railwayResearchCategory, 'type' => 'childrens'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
