<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $schoolData = Cache::remember('active_school_profile', 86400, function () {
            $schoolModel = School::first();
            return $schoolModel ? $schoolModel->toArray() : [];
        });
        $school = new School($schoolData);
        $school->exists = true;

        $totalStudents = Student::count();
        $totalRombel = Student::distinct()->count('rombel');
        
        $maleCount = Student::where('gender', 'L')->count();
        $femaleCount = Student::where('gender', 'P')->count();

        $recentStudents = Student::with(['address', 'parent', 'academic', 'financial'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'school',
            'totalStudents',
            'totalRombel',
            'maleCount',
            'femaleCount',
            'recentStudents'
        ));
    }

    public function quickSearch(Request $request): JsonResponse
    {
        $q = trim($request->get('q', ''));
        if (strlen($q) < 2) {
            return response()->json(['students' => [], 'routes' => []]);
        }

        $students = Student::where('name', 'like', "%{$q}%")
            ->orWhere('nipd', 'like', "%{$q}%")
            ->orWhere('nisn', 'like', "%{$q}%")
            ->limit(5)
            ->get(['id', 'name', 'nipd', 'rombel']);

        $user = auth()->user();
        $isAdmin = $user && $user->role === 'admin';

        $allRoutes = [
            ['label' => 'Daftar Siswa', 'url' => route('students.index'), 'icon' => 'users'],
            ['label' => 'Tambah Siswa Baru', 'url' => route('students.create'), 'icon' => 'plus'],
        ];

        if ($isAdmin) {
            $allRoutes[] = ['label' => 'Mata Pelajaran', 'url' => route('subjects.index'), 'icon' => 'bookopen'];
            $allRoutes[] = ['label' => 'Ekstrakurikuler', 'url' => route('extracurriculars.index'), 'icon' => 'award'];
            $allRoutes[] = ['label' => 'Profil Sekolah', 'url' => route('settings.edit'), 'icon' => 'school'];
            $allRoutes[] = ['label' => 'Kelola Operator', 'url' => route('users.index'), 'icon' => 'user'];
            $allRoutes[] = ['label' => 'Log Aktivitas', 'url' => route('audit_logs.index'), 'icon' => 'activity'];
        }

        $matchedRoutes = array_values(array_filter($allRoutes, function ($route) use ($q) {
            return stripos($route['label'], $q) !== false;
        }));

        return response()->json([
            'students' => $students,
            'routes' => $matchedRoutes,
        ]);
    }
}
