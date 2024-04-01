@extends("layouts.app")
@section("title")
    {{ $event->title }}
@endsection

@section("content")
    <x-base.toolbar
        :title="$event->title"
        :breads="array('Social', 'Gestion des évènements', $event->title)"
        return="true"/>

    <div class="card mb-5 mb-xxl-8">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-2by3 position-relative">
                        <img src="{{ \App\Models\Social\Event::getImage($event->id, 'default') }}" alt="{{ $event->title }}">
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-{{ $event->getStatus('color') }} rounded-circle border border-4 border-body h-20px w-20px" data-bs-toggle="tooltip" data-bs-title="{{ $event->getStatus('text') }}"></div>
                    </div>
                </div>
                <!--end::Pic-->

                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $event->title }}</a>
                            </div>
                            <!--end::Name-->

                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="fa-solid {{ $event->getType('icon') }} fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    {{ $event->getType('text') }}
                                </a>
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="fa-solid fa-calendar-week fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                                    {{ $event->start_at->format("d/m/Y à H:i") }} / {{ $event->end_at->format("d/m/Y à H:i") }}
                                </a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->

                        <!--begin::Actions-->
                        <livewire:social.event.show-action :event="$event" />
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->

                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <livewire:social.event.panel-stat :event="$event" />
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#event">
                        Evènement
                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#content">
                        Contenue
                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                @if($event->type_event == \App\Enums\Social\EventTypeEnum::POLL)
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#poll">
                        Sondages
                    </a>
                </li>
                @endif
                @if($event->type_event == \App\Enums\Social\EventTypeEnum::GRAPHIC)
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#media">
                            Média
                        </a>
                    </li>
                @endif
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 " data-bs-toggle="tab" href="#participants">
                        Participants
                    </a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->
        </div>
    </div>

    <div class="tab-content" id="tabEvent">
        <div class="tab-pane fade show active" id="event" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Post</h3>
                </div>
                <img src="{{ \App\Models\Social\Event::getImage($event->id, 'header') }}" alt="{{ $event->title }}">
                <div class="card-body">
                    <div class="fs-2x fw-bolder mb-3">{{ $event->title }}</div>
                    <div class="d-flex flex-row align-items-center p-5 bg-gray-200 rounded mb-10">
                        <div class="symbol symbol-70px symbol-circle me-5">
                            <img src="{{ $event->cercles()->first()->cercle_icon }}" alt="{{ $event->cercles()->first()->name }}">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fs-2 fw-bold">{{ $event->cercles()->first()->name }}</span>
                            <span class="text-muted">Par Vortech Studio</span>
                        </div>
                    </div>

                    <div class="fst-italic mb-3">{{ $event->synopsis }}</div>
                    {!! $event->contenue !!}
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="content" role="tabpanel">
            <form action="{{ route('social.events.update', $event->id) }}" method="POST">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Edition du contenu</h3>
                        <div class="card-toolbar">
                            <button type="submit" class="btn btn-sm btn-light">
                                Sauvegarder
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="updateContent">

                        <x-form.textarea
                            type="laraberg"
                            name="contenue"
                            value="{!! $event->contenue !!}" />
                    </div>
                </div>
            </form>
        </div>
        @if($event->type_event == \App\Enums\Social\EventTypeEnum::POLL)
            <div class="tab-pane fade" id="poll" role="tabpanel">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Sondage</h3>
                        <div class="card-toolbar">
                            @if(!$event->poll()->exists())
                            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addPoll">
                                Nouvelle question
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <x-base.underline
                            title="Question"
                            style-text="fs-1 fw-bold"
                            size-line="2" />
                        @if($event->poll()->exists())
                            {!! $event->poll->question !!}
                            <div class="mt-5">
                                <x-base.underline
                                    title="Réponses"
                                    style-text="fs-1 fw-bold"
                                    size-line="2" />

                                <div class="d-flex flex-column">
                                    @foreach($event->poll->responses as $response)
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-2 p-3 bg-light-primary rounded shadow-sm">
                                        <span class="">{{ $response->response }}</span>
                                        <span class="badge badge-success">{{ $response->count }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <span class="text-muted">Aucune question définie</span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if($event->type_event == \App\Enums\Social\EventTypeEnum::GRAPHIC)
            <div class="tab-pane fade" id="media" role="tabpanel">
                <livewire:social.event.list-graphic :event="$event" />
            </div>
        @endif
        <div class="tab-pane fade" id="participants" role="tabpanel">
            <livewire:social.event.list-user :event="$event" />
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="addPoll">
        <div class="modal-dialog">
            <form action="{{ route('social.events.store.poll', $event->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouveau Sondage</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.input
                            name="question"
                            label="Question"
                            required="true" />

                        <div id="formRepeatPollResponse">
                            <div data-repeater-list="formRepeatPollResponse">
                                <div data-repeater-item class="d-flex flex-row justify-content-between align-items-center">
                                    <x-form.input
                                        name="response"
                                        label="Reponse" />

                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                        <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                        Supprimer
                                    </a>
                                </div>
                            </div>
                            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                <i class="ki-duotone ki-plus fs-3"></i>
                                Nouvelle réponse
                            </a>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermé</button>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script type="text/javascript">
        $("#formRepeatPollResponse").repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        })
    </script>
@endpush
