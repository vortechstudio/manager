<?php

namespace App\Http\Controllers\Social;

use App\Enums\Social\EventStatusEnum;
use App\Enums\Social\EventTypeEnum;
use App\Http\Controllers\Controller;
use App\Jobs\FormatImageJob;
use App\Jobs\ResizeImageJob;
use App\Models\Social\Cercle;
use App\Models\Social\Event;
use App\Tables\Social\SocialEvent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Spatie\LaravelOptions\Options;
use Storage;

class EventController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(SocialEvent $table, Request $request)
    {
        if ($request->expectsJson()) {
            return $table->getData($request);
        }
        $types = Options::forEnum(EventTypeEnum::class)->toArray();
        $cercles = Options::forModels(Cercle::class)->toArray();
        //dd($cercles);

        return view('social.events.index', compact('types', 'cercles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type_event' => 'required',
            'synopsis' => 'required',
            'contenue' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'image' => 'image',
            'cercle_id' => 'required',
        ]);

        try {
            $event = Event::create([
                'title' => $request->title,
                'type_event' => $request->type_event,
                'synopsis' => $request->synopsis,
                'contenue' => $request->contenue,
                'start_at' => Carbon::parse($request->start_at),
                'end_at' => Carbon::parse($request->end_at),
                'status' => 'draft',
            ]);

            $event->cercles()->attach($request->get('cercle_id'));

            if ($request->hasFile('image')) {
                try {
                    $request->file('image')
                        ->storeAs(
                            path: "events/$event->id",
                            name: "default.{$request->file('image')->extension()}"
                        );

                    dispatch(new ResizeImageJob(
                        filePath: Storage::path("events/$event->id/default.{$request->file('image')->extension()}"),
                        directoryUpload: Storage::path("events/$event->id"),
                        sector: 'event'
                    ));

                    dispatch(new FormatImageJob(
                        filePath: Storage::path("events/$event->id/default.{$request->file('image')->extension()}"),
                        directoryUpload: Storage::path("events/$event->id"),
                        sector: 'event'
                    ));

                } catch (Exception $exception) {
                    toastr()
                        ->addError("Erreur lors du transformation de l'image de l'évènement");
                }
            }

            toastr()
                ->addSuccess('Évènement enregistré avec succès');

            return redirect()->back();
        } catch (\Exception $exception) {
            toastr()
                ->addError("Erreur lors de l'enregistrement de l'évènement");

            return redirect()->back();
        }
    }

    public function edit(int $eventId)
    {
        $event = Event::findOrFail($eventId);
        if ($event->status === EventStatusEnum::DRAFT) {
            $types = Options::forEnum(EventTypeEnum::class)->toArray();
            $cercles = Options::forModels(Cercle::class)->toArray();

            return view('social.events.edit', compact('event', 'types', 'cercles'));
        }

        toastr()
            ->addError("L'évènement n'est pas en cours d'édition");

        return redirect()->back();
    }

    public function update(int $eventId, Request $request)
    {
       return match ($request->get('action')) {
            'update' => $this->updateEvent($eventId, $request),
        };
    }

    private function updateEvent(int $eventId, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'synopsis' => 'required',
        ]);

        try {
            $event = Event::findOrFail($eventId);

            $event->update([
                'title' => $request->title,
                'start_at' => Carbon::parse($request->start_at),
                'end_at' => Carbon::parse($request->end_at),
                'synopsis' => $request->synopsis,
            ]);

            toastr()
                ->addSuccess('Évènement mis à jour avec succès');
        } catch (Exception $exception) {
            toastr()
                ->addError("Erreur lors de la mise à jour de l'évènement");

            return redirect()->back();
        }

        return redirect()->route('social.events.index');
    }
}
