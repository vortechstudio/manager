@extends("layouts.app")
@section("title")
    {{ $service->name }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$service->name"
        :breads="array('Social', 'Gestion des services', $service->name)"
        return="true"
        sticky="true" />

    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <livewire:social.service-panel-info :service="$service" />
        </div>
        <div class="col-sm-12 col-lg-8">
            <div class="card shadow-sm" x-data="{card_title: 'Contenue de la page'}">
                <div class="card-header">
                    <h3 class="card-title" x-text="card_title"></h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#content" x-on:click="card_title = 'Contenue de la page'">Contenue de la page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#versions" x-on:click="card_title = 'Notes de version'">Notes de version</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="content" role="tabpanel">
                            <livewire:social.service-panel-content :service="$service" />
                        </div>
                        <div class="tab-pane fade" id="versions" role="tabpanel">
                            <livewire:social.service-panel-version :service="$service" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script type="text/javascript">

    </script>
@endpush
