<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;

class NotificationHelper
{
    /**
     * Send a notification to a specific user or broadcast to all HR/Admin users.
     */
    public static function send(
        ?int $userId = null,
        string $senderName = 'System',
        string $title = '',
        ?string $body = null,
        ?string $targetName = null,
        string $badgeIcon = 'bi-bell-fill',
        string $badgeColor = 'bg-primary',
        ?string $senderAvatar = null,
        bool $hasActions = false,
        string $declineLabel = 'Decline',
        string $acceptLabel = 'Accept',
        ?string $actionUrl = null
    ): Notification {
        return Notification::create([
            'user_id' => $userId,
            'sender_name' => $senderName,
            'sender_avatar' => $senderAvatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80',
            'badge_icon' => $badgeIcon,
            'badge_color' => $badgeColor,
            'title' => $title,
            'target_name' => $targetName,
            'body' => $body,
            'action_url' => $actionUrl,
            'has_actions' => $hasActions,
            'action_decline_label' => $declineLabel,
            'action_accept_label' => $acceptLabel,
            'is_read' => false,
        ]);
    }

    /**
     * Broadcast a notification to all Admin & HR users.
     */
    public static function notifyAdminsAndHR(
        string $senderName,
        string $title,
        ?string $body = null,
        ?string $targetName = null,
        string $badgeIcon = 'bi-bell-fill',
        string $badgeColor = 'bg-primary',
        ?string $actionUrl = null
    ): void {
        $admins = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['Super Admin', 'Admin', 'HR', 'HR Manager']);
        })->get();

        if ($admins->isEmpty()) {
            $admins = User::all();
        }

        foreach ($admins as $admin) {
            self::send(
                userId: $admin->id,
                senderName: $senderName,
                title: $title,
                body: $body,
                targetName: $targetName,
                badgeIcon: $badgeIcon,
                badgeColor: $badgeColor,
                actionUrl: $actionUrl
            );
        }
    }
}
