<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Fetch notifications for the authenticated user (JSON for AJAX dropdown).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = $request->input('limit', 10);

        $notifications = Notification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take($limit)
            ->get()
            ->map(function ($notif) {
                return [
                    'id'         => $notif->id,
                    'type'       => $notif->type,
                    'title'      => $notif->title,
                    'message'    => $notif->message,
                    'data'       => $notif->data,
                    'read_at'    => $notif->read_at,
                    'is_unread'  => $notif->isUnread(),
                    'created_at' => $notif->created_at,
                    'time_ago'   => $notif->created_at
                        ? \Carbon\Carbon::parse($notif->created_at)->diffForHumans()
                        : '',
                ];
            });

        $unreadCount = Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success'       => true,
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($id)
    {
        $user = Auth::user();

        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $notification->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
        ]);
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead()
    {
        $user = Auth::user();

        Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read.',
        ]);
    }
}
