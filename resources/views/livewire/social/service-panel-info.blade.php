<div class="card shadow-sm">
    <img class="card-img-top" src="{{ $service->getImage($service->id, 'default') }}" alt="{{ $service->name }}">
    <div class="card-body">
        <livewire:social.service-panel-action :service="$service" />
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
            @isset($service->versions()->where('published', true)->orderBy('version', 'desc')->first()->version)
            <div class="separator border-2 border-primary  my-5"></div>
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span class="fw-bold">Dernière version</span>
                <div>
                    <a href="#showVersion" data-bs-toggle="modal" class="me-3">{{ $service->versions()->where('published', true)->orderBy('version', 'desc')->first()->version }}</a>
                </div>
            </div>
            @endif
        </div>
    </div>
    @isset($service->versions()->where('published', true)->orderBy('version', 'desc')->first()->version)
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
                                    <x-markdown>
                                        {!! $service->latest_version->contenue !!}
                                    </x-markdown>
                                </div>
                                @foreach($service->other_versions as $version)
                                    <div class="tab-pane fade" id="{{ Str::slug($version->version) }}">
                                        <div class="fs-2 fw-bold mb-2">{{ $version->title }}</div>
                                        <div class="fst-italic text-muted mb-2">{{ $version->description }}</div>
                                        <x-markdown>
                                            {!! $version->contenue !!}
                                        </x-markdown>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>
