<div>
    @if($this->service->hasVersions())
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6 min-w-lg-200px">
                    <li class="nav-item w-100 me-0 mb-md-2">
                        <a class="nav-link w-100 active btn btn-flex btn-active-light-success" data-bs-toggle="tab" href="#version_{{ $service->latest_version->id }}">
                                        <span class="d-flex flex-column align-items-start">
                                            <span class="fs-4 fw-bold">{{ $service->latest_version->version }}</span>
                                            <span class="badge badge-info">Latest</span>
                                        </span>
                        </a>
                    </li>
                    @foreach($service->other_versions as $version)
                        <li class="nav-item w-100 me-0 mb-md-2">
                            <a class="nav-link w-100 btn btn-flex btn-active-light-info" data-bs-toggle="tab" href="#version_{{ $version->id }}">
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
                    <div class="tab-pane fade active show" id="version_{{ $service->latest_version->id }}">
                        <div class="fs-2 fw-bold mb-2">{{ $service->latest_version->title }}</div>
                        <div class="fst-italic text-muted mb-2">{{ $service->latest_version->description }}</div>
                        <x-markdown>
                            {!! $service->latest_version->contenue !!}
                        </x-markdown>
                    </div>
                    @foreach($service->other_versions as $version)
                        <div class="tab-pane fade" id="version_{{ $version->id }}">
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
    @else
        <x-base.is-null
        text="Aucune version publier pour ce service" />
    @endif
</div>
