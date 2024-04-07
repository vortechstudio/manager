@extends("layouts.app")
@section("title")
    Engine: {{ $engine->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$engine->name"
        :breads="array('Railway Manager', 'Gestion des matériels roulants', $engine->name)"
        return="true"
        sticky="true" />

    <div class="row">
        <div class="col-sm-12 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">&nbsp;</h3>
                    <div class="card-toolbar">
                        <livewire:railway.engine.engine-show-action :engine="$engine" />
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Type de Transport</span>
                            <div class="d-flex flex-row align-items-center">
                                <div class="symbol symbol-25px symbol-2by3 me-2">
                                    <img
                                        src="{{ (new \App\Actions\Railway\EngineSelectAction())->selectorTypeTransport($engine->type_transport->value, 'image') }}"
                                        alt="{{ (new \App\Actions\Railway\EngineSelectAction())->selectorTypeTransport($engine->type_transport->value, 'value') }}">
                                </div>
                                <span>{{ (new \App\Actions\Railway\EngineSelectAction())->selectorTypeTransport($engine->type_transport->value, 'value') }}</span>
                            </div>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Type de Matériel</span>
                            <span>{{ (new \App\Actions\Railway\EngineSelectAction())->selectorTypeTrain($engine->type_train->value, 'value') }}</span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Energie utilisé</span>
                            <span>{{ (new \App\Actions\Railway\EngineSelectAction())->selectorTypeEnergy($engine->type_energy->value, 'value') }}</span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Status</span>
                            <span class="badge badge-{{ $engine->statusFormat('color') }}">
                                <i class="fa-solid fa-{{ $engine->statusFormat('icon') }} text-white me-2"></i>
                                <span>{{ $engine->statusFormat('text') }}</span>
                            </span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Disponible dans le jeux</span>
                            <span class="badge badge-{{ $engine->inGameFormat('color') }}">
                                <i class="fa-solid fa-{{ $engine->inGameFormat('icon') }} text-white me-2"></i>
                                <span>{{ $engine->inGameFormat('text') }}</span>
                            </span>
                        </div>
                        <div class="separator border-2 border-gray-500 my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Disponible dans la boutique</span>
                            <span class="badge badge-{{ $engine->inShopFormat('color') }}">
                                <i class="fa-solid fa-{{ $engine->inShopFormat('icon') }} text-white me-2"></i>
                                <span>{{ $engine->inShopFormat('text') }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-9">
            <div class="rounded-3 shadow-lg bg-white p-5 mb-10">
                <div class="d-flex flex-wrap justify-content-center align-items-baseline w-1200px scroll scroll-x">
                    @if($engine->type_train->value == 'automotrice')
                        @for($i=0; $i <= $engine->technical->nb_wagon -1; $i++)
                            <img src="{{ Storage::url("engines/automotrice/{$engine->slug}-{$i}.gif") }}" alt="">
                        @endfor
                    @else
                        <img src="{{ Storage::url("engines/{$engine->type_train->value}/{$engine->slug}.gif") }}" alt="">
                    @endif
                </div>
            </div>
            <div class="card shadow-sm" x-data="{card_title: 'Technique'}">
                <div class="card-header bg-bluegrey-600">
                    <h3 class="card-title text-white fs-2 fw-semibold" x-text="card_title"></h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link text-white active" data-bs-toggle="tab" href="#technical" x-on:click="card_title = 'Technique'">Information Technique</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" data-bs-toggle="tab" href="#gestion" x-on:click="card_title = 'Gestion & Tarifs'">Gestion & Tarifs</a>
                            </li>
                            @if($engine->in_shop)
                                <li class="nav-item">
                                    <a class="nav-link text-white" data-bs-toggle="tab" href="#shop" x-on:click="card_title = 'Boutique'">Gestion de la boutique</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="technical" role="tabpanel">
                            @include('components.railway.engine.technical', ['engine' => $engine])
                        </div>
                        <div class="tab-pane fade" id="gestion" role="tabpanel">
                            @include('components.railway.engine.gestion', ['engine' => $engine])
                        </div>
                        @if($engine->in_shop)
                            <div class="tab-pane fade" id="shop" role="tabpanel">
                                @include('components.railway.engine.shop', ['engine' => $engine])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
