<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('user_id', auth()->id());

        if ($request->tab === 'unread') {
            $query->where('is_read', false);
        } elseif ($request->tab === 'read') {
            $query->where('is_read', true);
        }

        $sort = $request->sort === 'asc' ? 'asc' : 'desc';
        $notifications = $query->orderBy('created_at', $sort)->paginate(10);

        return view('notification.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['is_read' => true]);

        return back();
    }

    public function readSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array'
        ]);

        Notification::whereIn('id', $request->ids)
            ->where('user_id', auth()->id())
            ->update(['is_read' => true]);

        return back();
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array'
        ]);

        Notification::whereIn('id', $request->ids)
            ->where('user_id', auth()->id())
            ->delete();

        return back();
    }
}
