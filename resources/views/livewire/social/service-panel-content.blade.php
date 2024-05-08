<div>
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            {!! $service->description !!}
        </div>
    </div>
    <div class="card shadow-sm">
        <img src="{{ $service->getImage($service->id, 'header') }}" class="card-img-top" alt="...">
        <div class="card-body">
            {!! $service->page_content !!}
        </div>
    </div>
</div>
