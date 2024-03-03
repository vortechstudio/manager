<div>
    <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5">
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ $column->label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
        @foreach($this->data() as $row)
            <tr>
                @foreach($this->columns() as $column)
                    <td>
                        <div class="py-3 px-6 cursor-pointer">
                            <x-dynamic-component
                                :component="$column->component"
                                :value="$row[$column->key]"
                                ></x-dynamic-component>
                        </div>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
