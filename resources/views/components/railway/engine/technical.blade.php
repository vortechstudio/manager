<div class="table-responsive">
    <table class="table table-rounded border border-gray-300 gap-5 gy-5 gs-5">
        <tbody>
        <tr class="border-bottom border-gray-300">
            <td class="border-right-1">Essieux</td>
            <td>{{ $engine->technical->essieux }}</td>
        </tr>
        <tr class="border-bottom border-gray-300">
            <td class="border-right-1">Vitesse Maximal</td>
            <td>{{ $engine->technical->velocity }} Km/h</td>
        </tr>
        <tr class="border-bottom border-gray-300">
            <td class="border-right-1">Durée de la maintenance</td>
            <td>{{ $engine->duration_maintenance->format("H:i:s") }}</td>
        </tr>
        @if($engine->type_train->value == 'automotrice')
            <tr class="border-bottom border-gray-300">
                <td class="border-right-1">Nombre de voitures</td>
                <td>{{ $engine->technical->nb_wagon }}</td>
            </tr>
        @endif
        <tr class="border-bottom border-gray-300">
            <td class="border-right-1">Type de motorisation</td>
            <td>{{ (new \App\Actions\Railway\EngineSelectAction())->selectorTypeMotor($engine->technical->motor->value, 'value') }}</td>
        </tr>
        <tr class="border-bottom border-gray-300">
            <td class="border-right-1">Type de marchandises</td>
            <td>{{ (new \App\Actions\Railway\EngineSelectAction())->selectorTypeMarchandise($engine->technical->marchandise->value, 'value') }}</td>
        </tr>
        @if($engine->technical->marchandise->value != 'none')
            <tr class="border-bottom border-gray-300">
                <td class="border-right-1">Capacité</td>
                <td>{{ $engine->technical->nb_marchandise }}</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
