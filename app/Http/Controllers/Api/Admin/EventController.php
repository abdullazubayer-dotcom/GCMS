<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();
                $query->where(fn ($query) => $query->where('title', 'like', "%{$search}%")->orWhere('slug', 'like', "%{$search}%")->orWhere('venue', 'like', "%{$search}%"));
            })->orderByDesc('event_date')->paginate(min($request->integer('per_page', 15), 100))->withQueryString();

        return EventResource::collection($events);
    }

    public function store(StoreEventRequest $request, ActivityLogger $logger): JsonResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? null) ?: $data['title']);
        $data['created_by'] = $request->user()->id;
        $event = Event::create($data);
        $logger->log('create', 'event', "Created event {$event->title}.", $event, null, $event->toArray());

        return (new EventResource($event))->response()->setStatusCode(201);
    }

    public function show(Event $event): EventResource { return new EventResource($event); }

    public function update(UpdateEventRequest $request, Event $event, ActivityLogger $logger): EventResource
    {
        $old = $event->toArray();
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? null) ?: $data['title'], $event);
        $data['updated_by'] = $request->user()->id;
        $event->update($data);
        $logger->log('update', 'event', "Updated event {$event->title}.", $event, $old, $event->fresh()->toArray());
        return new EventResource($event->fresh());
    }

    public function destroy(Event $event, ActivityLogger $logger): JsonResponse
    {
        $old = $event->toArray();
        $logger->log('delete', 'event', "Deleted event {$event->title}.", $event, $old);
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully.']);
    }

    private function uniqueSlug(string $value, ?Event $event = null): string
    {
        $base = Str::slug($value) ?: 'event'; $slug = $base; $number = 2;
        while (Event::where('slug', $slug)->when($event, fn ($query) => $query->whereKeyNot($event->id))->exists()) $slug = $base.'-'.$number++;
        return $slug;
    }
}
