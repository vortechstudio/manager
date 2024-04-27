@extends("layouts.app")
@section("title")
    Gestion des Bonus Journaliers
@endsection

@section("content")
    <x-base.toolbar
        title="Gestion des Bonus Journaliers"
        :breads="array('Railway Manager', 'Gestion des Bonus Journaliers')" />

    <div>
        <div class="rounded bg-white mb-10">
            <div class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row w-100 p-5 mb-5">
                <!--begin::Icon-->
                <i class="fa-solid fa-clock fs-2hx text-primary me-4 mb-5 mb-sm-0"></i>                    <!--end::Icon-->

                <!--begin::Content-->
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <h4 class="fw-semibold">Réinitialisation des bonus</h4>
                    <span>Les bonus se réinitialiseront <span class="fw-bold" data-ago="{{ time() + now()->diffInSeconds(now()->endOfMonth()) }}"></span></span>
                </div>
                <!--end::Content-->

                <!--begin::Close-->
                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                    <i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>                    </button>
                <!--end::Close-->
            </div>
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 p-5">
                @foreach($bonuses as $bonus)
                    <div class="card shadow-lg w-150px h-250px mb-10">
                        <div class="card-body">
                            <div class="d-flex flex-column-fluid justify-content-center align-items-center m-0 bg-gray-300 rounded-4 h-50px">
                                <img src="{{ $bonus->icon }}" alt="" class="h-75">
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center h-75 m-auto">
                                {{ $bonus->designation }}
                            </div>
                        </div>
                        <div class="card-footer bg-grey-800 text-white">
                            <div class="d-flex flex-column-fluid justify-content-center align-items-center m-auto">
                                <span class="text-center fw-bold">Jour {{ $bonus->number_day }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script type="text/javascript">
        if (NodeList.prototype.forEach === undefined) {
            NodeList.prototype.forEach = function (callback) {
                [].forEach.call(this, callback)
            }
        }

        let terms = [{
            time: 45,
            divide: 60,
            text: 'moins d\'une minute'
        }, {
            time: 90,
            divide: 60,
            text: 'environ une minute'
        }, {
            time: 45 * 60,
            divide: 60,
            text: '%d minutes'
        }, {
            time: 90 * 60,
            divide: 60 * 60,
            text: 'environ une heure'
        }, {
            time: 24 * 60 * 60,
            divide: 60 * 60,
            text: '%d heures'
        }, {
            time: 42 * 60 * 60,
            divide: 24 * 60 * 60,
            text: 'environ un jour'
        }, {
            time: 30 * 24 * 60 * 60,
            divide: 24 * 60 * 60,
            text: '%d jours'
        }, {
            time: 45 * 24 * 60 * 60,
            divide: 24 * 60 * 60 * 30,
            text: 'environ un mois'
        }, {
            time: 365 * 24 * 60 * 60,
            divide: 24 * 60 * 60 * 30,
            text: '%d mois'
        }, {
            time: 365 * 1.5 * 24 * 60 * 60,
            divide: 24 * 60 * 60 * 365,
            text: 'environ un an'
        }, {
            time: Infinity,
            divide: 24 * 60 * 60 * 365,
            text: '%d ans'
        }]

        document.querySelectorAll('[data-ago]').forEach(function (node) {

            let date = parseInt(node.dataset.ago, 10)

            function setText () {
                let secondes = Math.floor((new Date()).getTime() / 1000 - date)
                let prefix = secondes > 0 ? 'Il y a ' : 'Dans '
                let term = null
                secondes = Math.abs(secondes)
                for (term of terms) {
                    if (secondes < term.time) {
                        break
                    }
                }
                node.innerHTML = prefix + term.text.replace('%d', Math.round(secondes / term.divide))

                let nextTick = secondes % term.divide
                if (nextTick === 0) {
                    nextTick = term.divide
                }

                window.setTimeout(function () {
                    if (node.parentNode) {
                        if (window.requestAnimationFrame) {
                            window.requestAnimationFrame(setText)
                        } else {
                            setText()
                        }
                    }
                }, nextTick * 1000)
            }

            setText()
        })
    </script>
@endpush
