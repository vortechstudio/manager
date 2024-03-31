@php
    $notifications = Cache::remember('user_notifications_' . $user->id, 60, function () use ($user) {
        return $user->unreadNotifications()->limit(5)->get();
    });
@endphp
<!--begin::Notifications-->
<div class="app-navbar-item ms-1 ms-md-3">
    <!--begin::Menu- wrapper-->
    <div class="btn btn-icon btn-custom btn-icon-{{ $user->has_notification ? 'primary' : 'muted' }} btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px position-relative" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">
        <i class="ki-duotone ki-call fs-2 fs-lg-1">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
            <span class="path5"></span>
            <span class="path6"></span>
            <span class="path7"></span>
            <span class="path8"></span>
        </i>
        @if($user->has_notification)
            <span class="position-absolute top-0 start-100 translate-middle  badge badge-sm badge-circle badge-primary">{{ $user->count_notifications }}</span>
        @endif
    </div>
    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
        <!--begin::Heading-->
        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('/media/misc/menu-header-bg.jpg')">
            <!--begin::Title-->
            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
                <span class="fs-8 opacity-75 ps-3">{{ $user->count_notifications }} {{ Str::plural('nouvelle', $user->count_notifications) }} {{ Str::plural('notification', $user->count_notifications) }}</span></h3>
            <!--end::Title-->
            <!--begin::Tabs-->
            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#news">Nouvelle & Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#alerts">Alertes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#update">Mise à jour</a>
                </li>
            </ul>
            <!--end::Tabs-->
        </div>
        <!--end::Heading-->
        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab panel-->
            <div class="tab-pane fade" id="news" role="tabpanel">
                <!--begin::Items-->
                <div class="scroll-y mh-325px my-5 px-8">
                    @foreach($notifications as $notification)
                        @if($notification->data['sector'] == 'news')
                            <!--begin::Item-->
                            <div class="d-flex flex-stack py-4">
                                <!--begin::Section-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-35px me-4">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="{{ $notification->data['icon'] }} fs-2 text-{{ $notification->data['type'] }}"></i>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Title-->
                                    <div class="mb-0 me-2">
                                        <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $notification->data['title'] }}</a>
                                        <div class="text-gray-400 fs-7">{{ $notification->data['description'] }}</div>
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Label-->
                                <span class="badge badge-light fs-8">{{ $notification->created_at->diffForHumans() }}</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Item-->
                        @endif
                    @endforeach
                </div>
                <!--end::Items-->
                <!--begin::View more-->
                <div class="py-3 text-center border-top">
                    <a href="{{ route('notification.index') }}" class="btn btn-color-gray-600 btn-active-color-primary">Tous Voir...
                        <i class="ki-duotone ki-arrow-right fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i></a>
                </div>
                <!--end::View more-->
            </div>
            <div class="tab-pane fade" id="alerts" role="tabpanel">
                <!--begin::Items-->
                <div class="scroll-y mh-325px my-5 px-8">
                    @foreach($notifications as $notification)
                        @if($notification->data['sector'] == 'alerts')
                            <!--begin::Item-->
                            <div class="d-flex flex-stack py-4">
                                <!--begin::Section-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-35px me-4">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="{{ $notification->data['icon'] }} fs-2 text-{{ $notification->data['type'] }}"></i>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Title-->
                                    <div class="mb-0 me-2">
                                        <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $notification->data['title'] }}</a>
                                        <div class="text-gray-400 fs-7">{{ $notification->data['description'] }}</div>
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Label-->
                                <span class="badge badge-light fs-8">{{ $notification->created_at->diffForHumans() }}</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Item-->
                        @endif
                    @endforeach
                </div>
                <!--end::Items-->
                <div class="py-3 text-center border-top">
                    <a href="{{ route('notification.index') }}" class="btn btn-color-gray-600 btn-active-color-primary">Tous Voir...
                        <i class="ki-duotone ki-arrow-right fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i></a>
                </div>
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div class="tab-pane fade show active" id="update" role="tabpanel">
                <!--begin::Items-->
                <div class="scroll-y mh-325px my-5 px-8">
                    @foreach($notifications as $notification)
                        @if($notification->data['sector'] == 'release')
                            <!--begin::Item-->
                            <div class="d-flex flex-stack py-4">
                                <!--begin::Section-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-35px me-4">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="{{ $notification->data['icon'] }} fs-2 text-{{ $notification->data['type'] }}"></i>
                                    </span>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Title-->
                                    <div class="mb-0 me-2">
                                        <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $notification->data['title'] }}</a>
                                        <div class="text-gray-400 fs-7">{{ $notification->data['description'] }}</div>
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Label-->
                                <span class="badge badge-light fs-8">{{ $notification->created_at->diffForHumans() }}</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Item-->
                        @endif
                    @endforeach
                </div>
                <!--end::Items-->
                <div class="py-3 text-center border-top">
                    <a href="{{ route('notification.index') }}" class="btn btn-color-gray-600 btn-active-color-primary">Tous Voir...
                        <i class="ki-duotone ki-arrow-right fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i></a>
                </div>
            </div>
            <!--end::Tab panel-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::Menu-->
    <!--end::Menu wrapper-->
</div>
<!--end::Notifications-->
