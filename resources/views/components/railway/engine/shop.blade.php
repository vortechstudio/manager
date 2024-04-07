<div class="table-responsive">
    <table class="table table-rounded border border-gray-300 gap-5 gy-5 gs-5">
        <tbody>
            <tr class="border-bottom border-gray-300">
                <td class="border-right-1">Type de monnaie</td>
                <td>{{ (new \App\Actions\Railway\EngineSelectAction())->selectorMoneyShop($engine->shop->money->value, 'value') }}</td>
            </tr>
            <tr class="border-bottom border-gray-300">
                <td class="border-right-1">prix en boutique</td>
                <td>{{ eur($engine->shop->price) }}</td>
            </tr>
        </tbody>
    </table>
</div>
