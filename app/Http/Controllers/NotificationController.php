<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());

        if ($request->tab === 'read') {
            $query->where('is_read', true);
        } elseif ($request->tab === 'unread') {
            $query->where('is_read', false);
        }

        $notifications = $query
            ->orderBy('created_at', $request->sort === 'asc' ? 'asc' : 'desc')
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['is_read' => true]);

        return back();
    }

    public function readSelected(Request $request)
    {
        Notification::whereIn('id', $request->ids ?? [])
            ->where('user_id', Auth::id())
            ->update(['is_read' => true]);

        return back();
    }

    public function deleteSelected(Request $request)
    {
        Notification::whereIn('id', $request->ids ?? [])
            ->where('user_id', Auth::id())
            ->delete();

        return back();
    }

    public function destroy($id)
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back();
    }
}
