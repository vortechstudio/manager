<?php

namespace App\Tables\Social;

use App\Models\Social\Event;
use Illuminate\Http\Request;
use Takielias\TablarKit\DataTable\DataTable;
use Takielias\TablarKit\Enums\ExportType;

class SocialEvent extends DataTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDataSource(Event::query()->select('id', 'title', 'type_event', 'synopsis', 'contenue', 'start_at', 'end_at', 'status'))
            ->column(name: 'id', title: '#')
            ->column(name: 'title', title: 'Titre')
            ->column(name: 'type_event', title: 'Type')
            ->column(name: 'start_at', title: 'Debut')
            ->column(name: 'end_at', title: 'Fin')
            ->column(name: 'status', title: 'Statut')
            ->setExportTypes([ExportType::CSV, ExportType::PDF, ExportType::XLS])
            ->paginate(10);
    }

}
