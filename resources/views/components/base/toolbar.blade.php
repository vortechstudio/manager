<div class="rounded-top-0 rounded-bottom-3 shadow-lg bg-light mt-0 mb-10 p-5">
    <div class="d-flex flex-row justify-content-between align-items-center">
        @isset($breads)
            <div class="d-flex flex-column">
                <span class="fs-2 text-dark fw-bold">{{ $title }}</span>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ config('app.name') }}</a>
                    </li>
                    <!--end::Item-->
                    @foreach($breads as $item)
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">{{ $item }}</li>
                    <!--end::Item-->
                    @endforeach

                </ul>
            </div>
        @else
            <span class="fs-2 text-dark fw-bold">{{ $title }}</span>
        @endif
        <div class="">
            @isset($actions)
                @foreach($actions as $action)
                    <a @if(isset($action['wire'])) wire:click="{{ $action['wire'] }}" @else href="{{ $action['link'] }}" @endif class="btn btn-outline btn-outline-{{ $action['color'] }} me-3">{!! $action['text'] !!}</a>
                @endforeach
            @endisset
        </div>
    </div>
</div>
