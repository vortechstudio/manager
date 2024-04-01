<div class="d-flex flex-wrap">
    <!--begin::Stat-->
    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
        <!--begin::Number-->
        <div class="d-flex align-items-center">
            @if($avgSubscribers < 0)
                <i class="fa-solid fa-arrow-down fs-3 text-danger me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            @elseif($avgSubscribers == 0)
                <i class="fa-solid fa-equals fs-3 text-warning me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            @else
                <i class="fa-solid fa-arrow-up fs-3 text-success me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            @endif
            <div class="fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="{{ $subscribersCount }}" data-kt-initialized="1">{{ $subscribersCount }}</div>
        </div>
        <!--end::Number-->

        <!--begin::Label-->
        <div class="fw-semibold fs-6 text-gray-500">Souscriptions à l'évènement</div>
        <!--end::Label-->
    </div>
    <!--end::Stat-->

</div>
