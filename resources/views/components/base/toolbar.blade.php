<div class="rounded-top-0 rounded-bottom-3 shadow-lg bg-light mt-0 mb-10 p-5"
    @if($sticky)
        data-kt-sticky="true"
         data-kt-sticky-name="docs-sticky-summary"
         data-kt-sticky-offset="{default: false, xl: '200px'}"
         data-kt-sticky-width="{lg: '250px', xl: '75%'}"
         data-kt-sticky-left="auto"
         data-kt-sticky-top="auto"
         data-kt-sticky-animation="false"
         data-kt-sticky-zindex="95"
    @endif
>
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
            @if($return)
                <a wire:navigate href="javascript:history.back()" class="btn btn-outline btn-light">
                    <i class="fa-solid fa-arrow-circle-left fs-3 me-3"></i>
                    <span>Retour</span>
                </a>
            @endif
            @isset($actions)
                @foreach($actions as $action)
                    <a @if(isset($action['wire'])) wire:click="{{ $action['wire'] }}" @else href="{{ $action['link'] }}" wire:navigate @endif class="btn btn-outline btn-outline-{{ $action['color'] }} me-3">{!! $action['text'] !!}</a>
                @endforeach
            @endisset
            @if($submit)
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            @endif
        </div>
    </div>
</div>
