<?php

namespace App\Livewire\Table;

use Livewire\Component;

abstract class Table extends Component
{
    abstract public function query(): \Illuminate\Database\Eloquent\Builder;

    abstract public function columns(): array;

    public function data()
    {
        return $this
            ->query()
            ->get();
    }

    public function render()
    {
        return view('livewire.table.table', [
            'columns' => $this->columns(),
            'data' => $this->data(),
        ]);
    }
}
