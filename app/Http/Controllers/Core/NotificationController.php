<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        $user = auth()->user();

        Notification::where(function($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user?->id);
        })->where('is_read', false)->update(['is_read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    public function fetch(Request $request)
    {
        $user = auth()->user();
        $filter = $request->input('filter', 'all');

        $query = Notification::where(function($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user?->id);
        });

        if ($filter === 'unread') {
            $query->where('is_read', false);
        }

        $notifications = $query->latest()->take(15)->get();
        $unreadCount = Notification::where(function($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user?->id);
        })->where('is_read', false)->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }
}
