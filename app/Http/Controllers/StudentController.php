<?php

namespace App\Http\Controllers;

use App\Actions\Student\CreateStudentAction;
use App\Actions\Student\UpdateStudentAction;
use App\Http\Requests\StudentStoreRequest;
use App\Models\AuditLog;
use App\Models\Extracurricular;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\JsonResponse
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nipd', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('rombel')) {
            $query->where('rombel', $request->input('rombel'));
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'aktif') {
                $query->where('rombel', 'not like', 'IX%');
            } elseif ($status === 'lulus') {
                $query->where('rombel', 'like', 'IX%');
            }
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortDir = $request->input('sort_dir', 'asc');

        if (in_array($sortBy, ['name', 'nipd', 'nisn', 'rombel', 'created_at'])) {
            $query->orderBy($sortBy, $sortDir === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('name', 'asc');
        }

        $students = $query->paginate(10)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($students);
        }

        $rombels = Student::distinct()->pluck('rombel');

        return view('students.index', compact('students', 'rombels'));
    }

    public function create(): View
    {
        $subjects = Subject::all();
        $extracurriculars = Extracurricular::all();

        return view('students.create', compact('subjects', 'extracurriculars'));
    }

    public function store(StudentStoreRequest $request, CreateStudentAction $createStudentAction): RedirectResponse
    {
        $createStudentAction->execute(
            $request->validated(),
            auth()->user()->school_id,
            auth()->id()
        );

        return redirect()->route('students.index')->with('success', 'Data siswa baru berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $student = Student::with(['address', 'parent', 'academic', 'financial', 'subjects', 'extracurriculars'])->findOrFail($id);
        $subjects = Subject::all();
        $extracurriculars = Extracurricular::all();

        return view('students.edit', compact('student', 'subjects', 'extracurriculars'));
    }

    public function update(int $id, StudentStoreRequest $request, UpdateStudentAction $updateStudentAction): RedirectResponse
    {
        $student = Student::findOrFail($id);

        $updateStudentAction->execute(
            $student,
            $request->validated(),
            auth()->id()
        );

        return redirect()->route('students.edit', $id)->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        if (!Gate::allows('admin-only')) {
            abort(403, 'Tindakan ini tidak diizinkan untuk peran Anda.');
        }

        $student = Student::findOrFail($id);
        $studentName = $student->name;
        $studentNipd = $student->nipd;

        $student->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'DELETE_STUDENT',
            'student_id' => $id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'payload_changes' => [
                'nipd' => $studentNipd,
                'name' => $studentName,
            ],
        ]);

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function singleStudentPrint(int $id): View
    {
        $student = Student::with(['address', 'parent', 'academic', 'financial', 'subjects', 'extracurriculars'])->findOrFail($id);

        $schoolData = \Illuminate\Support\Facades\Cache::remember('active_school_profile', 86400, function () {
            $schoolModel = \App\Models\School::first();
            return $schoolModel ? $schoolModel->toArray() : [];
        });
        $schoolProfile = new \App\Models\School($schoolData);
        $schoolProfile->exists = true;

        return view('students.single_student_print', compact('student', 'schoolProfile'));
    }

    public function allStudentsPrint(Request $request): View
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nipd', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('rombel_filter')) {
            $query->where('rombel', $request->input('rombel_filter'));
        } elseif ($request->filled('rombel')) {
            $query->where('rombel', $request->input('rombel'));
        }

        if ($request->filled('status_filter') || $request->filled('status')) {
            $status = $request->input('status_filter') ?? $request->input('status');
            if ($status === 'aktif') {
                $query->where('rombel', 'not like', 'IX%');
            } elseif ($status === 'lulus') {
                $query->where('rombel', 'like', 'IX%');
            }
        }

        $sortFilter = $request->input('sort_filter');
        if ($sortFilter) {
            switch ($sortFilter) {
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'nipd_asc':
                    $query->orderBy('nipd', 'asc');
                    break;
                case 'nipd_desc':
                    $query->orderBy('nipd', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
                    break;
            }
        } else {
            $sortBy = $request->input('sort_by', 'name');
            $sortDir = $request->input('sort_dir', 'asc');
            if (in_array($sortBy, ['name', 'nipd', 'nisn', 'rombel', 'created_at'])) {
                $query->orderBy($sortBy, $sortDir === 'desc' ? 'desc' : 'asc');
            } else {
                $query->orderBy('name', 'asc');
            }
        }

        $students = $query->with(['parent', 'address'])->get();

        $schoolData = \Illuminate\Support\Facades\Cache::remember('active_school_profile', 86400, function () {
            $schoolModel = \App\Models\School::first();
            return $schoolModel ? $schoolModel->toArray() : [];
        });
        $schoolProfile = new \App\Models\School($schoolData);
        $schoolProfile->exists = true;

        $totalMale = $students->where('gender', 'L')->count();
        $totalFemale = $students->where('gender', 'P')->count();

        return view('students.all_students_print', compact('students', 'schoolProfile', 'request', 'totalMale', 'totalFemale'));
    }

    public function quickSearch(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = $request->input('q');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'students' => [],
                'routes' => []
            ]);
        }

        $students = Student::where('name', 'like', "%{$query}%")
            ->orWhere('nipd', 'like', "%{$query}%")
            ->orWhere('nisn', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name', 'nipd', 'rombel']);

        $allRoutes = [
            ['label' => 'Data Siswa', 'url' => route('students.index'), 'icon' => 'users'],
            ['label' => 'Tambah Siswa Baru', 'url' => route('students.create'), 'icon' => 'plus'],
            ['label' => 'Mata Pelajaran', 'url' => route('subjects.index'), 'icon' => 'bookopen'],
            ['label' => 'Ekstrakurikuler', 'url' => route('extracurriculars.index'), 'icon' => 'award'],
            ['label' => 'Profil Sekolah', 'url' => route('settings.edit'), 'icon' => 'school'],
            ['label' => 'Operator Sekolah', 'url' => route('users.index'), 'icon' => 'user'],
            ['label' => 'Log Audit', 'url' => route('audit_logs.index'), 'icon' => 'activity'],
        ];

        $matchedRoutes = [];
        foreach ($allRoutes as $route) {
            if (stripos($route['label'], $query) !== false) {
                $matchedRoutes[] = $route;
            }
        }

        return response()->json([
            'students' => $students,
            'routes' => $matchedRoutes
        ]);
    }
}
