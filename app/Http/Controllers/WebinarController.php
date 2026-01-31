<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Webinar;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Str;

class WebinarController extends Controller
{
    public function show($slug)
    {
        $webinar = Webinar::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Generate Schema.org structured data for Event
        $startDateTime = null;
        if ($webinar->event_date) {
            $time = $webinar->event_time ?? '10:00:00';
            $startDateTime = $webinar->event_date->format('Y-m-d') . 'T' . $time;
        }

        $event = Schema::event()
            ->name($webinar->title)
            ->description(strip_tags($webinar->excerpt ?? Str::limit($webinar->content, 200)))
            ->organizer(
                Schema::organization()
                    ->name('SmartPath Education Consulting')
                    ->email('info@smartpathedu.in')
                    ->telephone('+91-8073889090')
                    ->url(url('/'))
            )
            ->eventAttendanceMode('https://schema.org/OnlineEventAttendanceMode')
            ->eventStatus('https://schema.org/EventScheduled');

        if ($startDateTime) {
            $event->startDate($startDateTime);
        }

        if ($webinar->location) {
            $event->location(
                Schema::place()->name($webinar->location)
            );
        } else {
            $event->location(
                Schema::virtualLocation()
                    ->url($webinar->registration_link ?? url("/webinars/{$webinar->slug}"))
            );
        }

        if ($webinar->image_url) {
            $event->image($webinar->image_url);
        }

        if ($webinar->registration_link) {
            $event->offers(
                Schema::offer()
                    ->url($webinar->registration_link)
                    ->price('0')
                    ->priceCurrency('INR')
                    ->availability('https://schema.org/InStock')
            );
        }

        $schemaJson = $event->toScript();

        return view('webinars.show', compact('webinar', 'schemaJson'));
    }
}
