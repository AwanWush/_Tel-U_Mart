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

        // Filter berdasarkan Tab
        if ($request->tab === 'read') {
            $query->where('is_read', true);
        } elseif ($request->tab === 'unread') {
            $query->where('is_read', false);
        }

        // Sorting & Pagination
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

        return back()->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    // Fungsi sesuai nama route: notifications.markAllRead
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    // Fungsi sesuai nama route: notifications.deleteAll
    public function deleteAll()
    {
        Notification::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }

    public function readSelected(Request $request)
    {
        Notification::whereIn('id', $request->ids ?? [])
            ->where('user_id', Auth::id())
            ->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi terpilih ditandai dibaca.');
    }

    public function deleteSelected(Request $request)
    {
        Notification::whereIn('id', $request->ids ?? [])
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Notifikasi terpilih dihapus.');
    }

    public function destroy($id)
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Notifikasi dihapus.');
    }
}