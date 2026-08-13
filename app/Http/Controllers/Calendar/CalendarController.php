<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calendar\Event;
use App\Models\Leave\LeaveApplication;
use App\Models\NoticeBoard\Announcement;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        // Default to current year and month dynamically if not passed in query params
        $year = (int) $request->get('year', Carbon::now()->year);
        $month = (int) $request->get('month', Carbon::now()->month);

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
                'is_today' => ($dateStr === $todayStr),
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

        // Map events by date
        $eventsByDate = [];

        // A. Custom Database Events
        $customEvents = Event::whereYear('event_date', $year)
            ->whereMonth('event_date', $month)
            ->get();

        foreach ($customEvents as $ev) {
            $dStr = Carbon::parse($ev->event_date)->format('Y-m-d');
            $eventsByDate[$dStr][] = (object) [
                'id' => $ev->id,
                'title' => $ev->title,
                'description' => $ev->description,
                'event_date' => Carbon::parse($ev->event_date),
                'type' => $ev->type ?? 'indigo',
                'is_custom' => true,
            ];
        }

        // B. Dynamic Approved/Pending Leave Applications Live Data
        $leaveApps = LeaveApplication::with(['employee', 'leaveType'])
            ->where(function($q) use ($year, $month) {
                $q->whereYear('start_date', $year)->whereMonth('start_date', $month)
                  ->orWhereYear('end_date', $year)->whereMonth('end_date', $month);
            })->get();

        foreach ($leaveApps as $leave) {
            $start = Carbon::parse($leave->start_date);
            $end = Carbon::parse($leave->end_date);
            for ($dt = $start->copy(); $dt->lte($end); $dt->addDay()) {
                if ((int)$dt->year === $year && (int)$dt->month === $month) {
                    $dStr = $dt->format('Y-m-d');
                    $empName = $leave->employee?->name ?? 'Staff';
                    $typeName = $leave->leaveType?->name ?? 'Leave';
                    $eventsByDate[$dStr][] = (object) [
                        'id' => 'leave_' . $leave->id,
                        'title' => '🌴 ' . $empName . ' (' . $typeName . ')',
                        'description' => 'Reason: ' . ($leave->reason ?? 'N/A') . ' | Status: ' . ucfirst($leave->status),
                        'event_date' => $dt->copy(),
                        'type' => $leave->status === 'approved' ? 'emerald' : 'amber',
                        'is_custom' => false,
                    ];
                }
            }
        }

        // C. Live Company Announcements Live Data
        $announcements = Announcement::whereYear('published_at', $year)
            ->whereMonth('published_at', $month)
            ->get();

        foreach ($announcements as $ann) {
            $dStr = Carbon::parse($ann->published_at)->format('Y-m-d');
            $eventsByDate[$dStr][] = (object) [
                'id' => 'notice_' . $ann->id,
                'title' => '📢 Notice: ' . $ann->title,
                'description' => $ann->body ?? 'Company notice published.',
                'event_date' => Carbon::parse($ann->published_at),
                'type' => 'indigo',
                'is_custom' => false,
            ];
        }

        // Auto-seed default milestone events for the requested month if custom events are empty for this month
        if ($customEvents->isEmpty()) {
            $defaultEventsData = [
                [
                    'title' => '⚡ Monthly Sprint Kickoff & Review',
                    'description' => 'Team Monthly Deliverables Demo & Sprint Review',
                    'event_date' => sprintf('%04d-%02d-05', $year, $month),
                    'type' => 'indigo',
                ],
                [
                    'title' => '💵 Monthly Payroll Processing',
                    'description' => 'Finance Dept Direct Deposit & Payroll Execution',
                    'event_date' => sprintf('%04d-%02d-15', $year, $month),
                    'type' => 'emerald',
                ],
                [
                    'title' => '🛡️ System Security & Backup Audit',
                    'description' => 'Infrastructure Security Compliance & Audit Check',
                    'event_date' => sprintf('%04d-%02d-25', $year, $month),
                    'type' => 'amber',
                ],
            ];

            foreach ($defaultEventsData as $dEvData) {
                $ev = Event::create([
                    'title' => $dEvData['title'],
                    'description' => $dEvData['description'],
                    'event_date' => $dEvData['event_date'],
                    'type' => $dEvData['type'],
                    'created_by' => auth()->id(),
                ]);

                $dStr = Carbon::parse($ev->event_date)->format('Y-m-d');
                $eventsByDate[$dStr][] = (object) [
                    'id' => $ev->id,
                    'title' => $ev->title,
                    'description' => $ev->description,
                    'event_date' => Carbon::parse($ev->event_date),
                    'type' => $ev->type,
                    'is_custom' => true,
                ];
            }
        }

        // Calculate dynamic live statistics
        $totalEventsCount = 0;
        $holidaysCount = Event::where('type', 'red')->count();
        $sprintsCount = Event::whereIn('type', ['indigo', 'amber'])->count();

        foreach ($eventsByDate as $dateEvents) {
            $totalEventsCount += count($dateEvents);
        }

        $stats = [
            'total_events' => $totalEventsCount,
            'holidays_count' => $holidaysCount,
            'sprints_count' => $sprintsCount,
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

        $eventMonth = Carbon::parse($event->event_date)->month;
        $eventYear = Carbon::parse($event->event_date)->year;

        return redirect()->route('calendar.index', ['month' => $eventMonth, 'year' => $eventYear])
            ->with('success', 'Event scheduled successfully for ' . Carbon::parse($event->event_date)->format('M d, Y') . '.');
    }

    public function destroyEvent(Event $event)
    {
        $event->delete();
        return redirect()->back()->with('success', 'Event removed from schedule.');
    }
}
