<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('username', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('action')) {
            $action = $request->input('action');
            $query->where('action', 'like', "%{$action}%");
        }

        $sortDir = $request->input('sort_dir', 'desc');
        $query->orderBy('created_at', $sortDir === 'asc' ? 'asc' : 'desc');

        $auditLogs = $query->paginate(25)->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            $items = collect($auditLogs->items())->map(function ($log) {
                $badgeType = 'warning';
                if (str_contains($log->action, 'DELETE')) {
                    $badgeType = 'danger';
                } elseif (str_contains($log->action, 'CREATE')) {
                    $badgeType = 'success';
                }

                return [
                    'id' => $log->id,
                    'created_at' => $log->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') . ' WIB',
                    'username' => $log->user->username ?? 'Sistem / Terhapus',
                    'action' => $log->action,
                    'badge_type' => $badgeType,
                    'ip_address' => $log->ip_address,
                ];
            });

            return response()->json([
                'data' => $items,
                'total' => $auditLogs->total(),
                'first_item' => $auditLogs->firstItem(),
                'last_item' => $auditLogs->lastItem(),
                'current_page' => $auditLogs->currentPage(),
                'last_page' => $auditLogs->lastPage(),
            ]);
        }

        return view('audit_logs.index', compact('auditLogs'));
    }
}
