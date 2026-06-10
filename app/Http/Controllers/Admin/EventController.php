<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Models\Event;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::query()
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status')->toString());
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('venue', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('event_date')
            ->paginate(10)
            ->withQueryString();

        return view('admin.events.index', [
            'events' => $events,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? null) ?: $data['title']);
        $data['created_by'] = Auth::id();

        $event = Event::create($data);

        $activityLogger->log(
            'create',
            'event',
            "Created event {$event->title}.",
            $event,
            null,
            $event->toArray()
        );

        return redirect()
            ->route('admin.events.show', $event)
            ->with('status', 'Event created successfully.');
    }

    public function show(Event $event): View
    {
        $event->load(['creator', 'updater']);

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event, ActivityLogger $activityLogger): RedirectResponse
    {
        $oldValues = $event->toArray();
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug(($data['slug'] ?? null) ?: $data['title'], $event);
        $data['updated_by'] = Auth::id();

        $event->update($data);

        $activityLogger->log(
            'update',
            'event',
            "Updated event {$event->title}.",
            $event,
            $oldValues,
            $event->fresh()->toArray()
        );

        return redirect()
            ->route('admin.events.show', $event)
            ->with('status', 'Event updated successfully.');
    }

    public function destroy(Event $event, ActivityLogger $activityLogger): RedirectResponse
    {
        $oldValues = $event->toArray();
        $eventTitle = $event->title;
        $event->delete();

        $activityLogger->log(
            'delete',
            'event',
            "Deleted event {$eventTitle}.",
            $event,
            $oldValues
        );

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event deleted successfully.');
    }

    private function uniqueSlug(string $value, ?Event $event = null): string
    {
        $baseSlug = Str::slug($value);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'event';
        $slug = $baseSlug;
        $counter = 2;

        while (Event::where('slug', $slug)
            ->when($event, fn ($query) => $query->whereKeyNot($event->id))
            ->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
