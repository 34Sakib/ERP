<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calendar\Event;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->get('year', 2026);
        $month = (int) $request->get('month', 7);

        $firstOfMonth = Carbon::createFromDate($year, $month, 1);
        $monthName = $firstOfMonth->format('F');
        $daysInMonth = $firstOfMonth->daysInMonth;

        // Day of week for 1st of month: 0 (Sun) to 6 (Sat)
        $startDayOfWeek = $firstOfMonth->dayOfWeek;

        // Previous month padding
        $prevMonth = (clone $firstOfMonth)->subMonth();
        $daysInPrevMonth = $prevMonth->daysInMonth;

        $calendarDays = [];

        // 1. Previous Month Days
        for ($i = $startDayOfWeek - 1; $i >= 0; $i--) {
            $dayNum = $daysInPrevMonth - $i;
            $dateStr = sprintf('%04d-%02d-%02d', $prevMonth->year, $prevMonth->month, $dayNum);
            $calendarDays[] = [
                'day' => $dayNum,
                'date' => $dateStr,
                'is_current_month' => false,
                'is_weekend' => in_array(Carbon::parse($dateStr)->dayOfWeek, [0, 6]),
                'is_today' => false,
            ];
        }

        // 2. Current Month Days
        $todayStr = Carbon::today()->format('Y-m-d');
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $d);
            $calendarDays[] = [
                'day' => $d,
                'date' => $dateStr,
                'is_current_month' => true,
                'is_weekend' => in_array(Carbon::parse($dateStr)->dayOfWeek, [0, 6]),
                'is_today' => ($dateStr === '2026-07-25' || $dateStr === $todayStr),
            ];
        }

        // 3. Next Month Days to complete the week rows
        $nextMonth = (clone $firstOfMonth)->addMonth();
        $nextMonthPadding = (7 - (count($calendarDays) % 7)) % 7;
        for ($n = 1; $n <= $nextMonthPadding; $n++) {
            $dateStr = sprintf('%04d-%02d-%02d', $nextMonth->year, $nextMonth->month, $n);
            $calendarDays[] = [
                'day' => $n,
                'date' => $dateStr,
                'is_current_month' => false,
                'is_weekend' => in_array(Carbon::parse($dateStr)->dayOfWeek, [0, 6]),
                'is_today' => false,
            ];
        }

        // Fetch events for this month view
        $events = Event::whereYear('event_date', $year)
            ->whereMonth('event_date', $month)
            ->get();

        $eventsByDate = [];
        foreach ($events as $ev) {
            $dStr = $ev->event_date->format('Y-m-d');
            $eventsByDate[$dStr][] = $ev;
        }

        $stats = [
            'total_events' => $events->count(),
            'holidays_count' => Event::where('type', 'red')->count(),
            'sprints_count' => Event::whereIn('type', ['indigo', 'amber'])->count(),
        ];

        return view('calendar.index', compact(
            'calendarDays',
            'eventsByDate',
            'monthName',
            'year',
            'month',
            'stats'
        ));
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'type' => 'required|in:indigo,emerald,amber,red',
        ]);

        $validated['created_by'] = auth()->id();

        $event = Event::create($validated);

        return redirect()->back()->with('success', 'Event scheduled successfully for ' . Carbon::parse($event->event_date)->format('M d, Y') . '.');
    }

    public function destroyEvent(Event $event)
    {
        $event->delete();
        return redirect()->back()->with('success', 'Event removed from schedule.');
    }
}
