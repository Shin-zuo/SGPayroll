<?php

namespace SGpayroll\Http\Controllers\Notification;

use Illuminate\Http\Request;
use SGpayroll\Http\Controllers\Controller;
use SGpayroll\AppNotification;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get recent notifications and unread count for current authenticated user.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();

        $unreadCount = AppNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        $notifications = AppNotification::where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->take(20)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'title' => $n->title,
                    'message' => $n->message,
                    'type' => $n->type,
                    'link' => $n->link,
                    'is_read' => (bool) $n->is_read,
                    'time_ago' => $n->time_ago,
                    'created_at' => $n->created_at ? $n->created_at->toDateTimeString() : null,
                ];
            });

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($id)
    {
        $userId = auth()->id();
        $notification = AppNotification::where('user_id', $userId)->findOrFail($id);

        if (!$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => Carbon::now(),
            ]);
        }

        $unreadCount = AppNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
            'notification' => $notification,
        ]);
    }

    /**
     * Mark all notifications as read for current user.
     */
    public function markAllAsRead()
    {
        $userId = auth()->id();

        AppNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => Carbon::now(),
            ]);

        return response()->json([
            'success' => true,
            'unread_count' => 0,
        ]);
    }

    /**
     * Delete a single notification.
     */
    public function destroy($id)
    {
        $userId = auth()->id();
        $notification = AppNotification::where('user_id', $userId)->findOrFail($id);
        $notification->delete();

        $unreadCount = AppNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Delete all notifications for the current user.
     */
    public function clearAll()
    {
        $userId = auth()->id();
        AppNotification::where('user_id', $userId)->delete();

        return response()->json([
            'success' => true,
            'unread_count' => 0,
        ]);
    }
}
