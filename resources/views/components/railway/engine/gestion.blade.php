<div class="table-responsive">
    <table class="table table-rounded border border-gray-300 gap-5 gy-5 gs-5">
        <tbody>
            <tr class="border-bottom border-gray-300">
                <td class="border-right-1">Prix à l'achat</td>
                <td>{{ eur($engine->price->achat) }}</td>
            </tr>
            <tr class="border-bottom border-gray-300">
                <td class="border-right-1">Prix de la maintenance</td>
                <td>{{ eur($engine->price->maintenance) }} / par heure</td>
            </tr>
            <tr class="border-bottom border-gray-300">
                <td class="border-right-1">Prix de la location</td>
                <td>{{ eur($engine->price->location) }} / par jour</td>
            </tr>
        </tbody>
    </table>
</div>
