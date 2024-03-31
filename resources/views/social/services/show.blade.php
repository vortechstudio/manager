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
            <div class="card shadow-sm">
                <img src="{{ \App\Models\Config\Service::getImage($serviceId, 'default') }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Type</span>
                            {!! $service->type_label !!}
                        </div>
                        <div class="separator border-2 border-primary  my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Status</span>
                            {!! $service->status_label !!}
                        </div>
                        <div class="separator border-2 border-primary  my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Url du projet</span>
                            <a href="{{ $service->url }}" target="_blank">{{ $service->url }}</a>
                        </div>
                        <div class="separator border-2 border-primary  my-5"></div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <span class="fw-bold">Dernière version</span>
                            <div>
                                <a href="#showVersion" data-bs-toggle="modal" class="me-3">{{ $service->versions()->where('published', true)->orderBy('version', 'desc')->first()->version }}</a>
                                <button class="btn btn-sm btn-icon btn-outline btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addVersion"><i class="fa-solid fa-plus"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8">
            <div class="card shadow-sm mb-5">
                <div class="card-body">
                    {!! $service->description !!}
                </div>
            </div>
            <div class="card shadow-sm">
                <img src="{{ \App\Models\Config\Service::getImage($serviceId, 'header') }}" class="card-img-top" alt="...">
                <div class="card-body">
                    {!! $service->page_content !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="showVersion">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Changelog: {{ $service->name }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-3">
                            <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6 min-w-lg-200px">
                                <li class="nav-item w-100 me-0 mb-md-2">
                                    <a class="nav-link w-100 active btn btn-flex btn-active-light-success" data-bs-toggle="tab" href="#{{ Str::slug($service->latest_version->version) }}">
                                        <span class="d-flex flex-column align-items-start">
                                            <span class="fs-4 fw-bold">{{ $service->latest_version->version }}</span>
                                            <span class="badge badge-info">Latest</span>
                                        </span>
                                    </a>
                                </li>
                                @foreach($service->other_versions as $version)
                                <li class="nav-item w-100 me-0 mb-md-2">
                                    <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab" href="#{{ Str::slug($version->version) }}">
                                        <span class="d-flex flex-column align-items-start">
                                            <span class="fs-4 fw-bold">{{ $version->version }}</span>
                                        </span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-12 col-lg-9">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="{{ Str::slug($service->latest_version->version) }}">
                                    <div class="fs-2 fw-bold mb-2">{{ $service->latest_version->title }}</div>
                                    <div class="fst-italic text-muted mb-2">{{ $service->latest_version->description }}</div>
                                    {!! $service->latest_version->contenue !!}
                                </div>
                                @foreach($service->other_versions as $version)
                                <div class="tab-pane fade" id="{{ Str::slug($version->version) }}">
                                    <div class="fs-2 fw-bold mb-2">{{ $version->title }}</div>
                                    <div class="fst-italic text-muted mb-2">{{ $version->description }}</div>
                                    {!! $version->contenue !!}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="addVersion">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <form action="{{ route('social.services.version.store', $service->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title">Nouvelle Version</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-8">
                                <x-form.input
                                    name="version"
                                    label="Version du programme"
                                    required="true" />

                                <x-form.input
                                    name="title"
                                    label="Titre de la version"
                                    required="true" />

                                <x-form.textarea
                                    type="simple"
                                    name="description"
                                    label="Description de la version" />

                                <x-form.textarea
                                    type="laraberg"
                                    name="contenue"
                                    label="Contenue de la version" />
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <x-form.checkbox
                                    name="published"
                                    label="Publier la version" />

                                <x-form.checkbox
                                    name="publish_social"
                                    label="Publier sur le site social" />

                                <x-form.button
                                    text-submit="Créer la version" />
                            </div>
                        </div>
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
