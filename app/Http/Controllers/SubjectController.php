<?php

namespace App\Http\Controllers;

use App\Actions\Subject\CreateSubjectAction;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(): View
    {
        $subjects = Subject::orderBy('code')->get();
        return view('subjects.index', compact('subjects'));
    }

    public function store(Request $request, CreateSubjectAction $createSubjectAction): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code'],
            'name' => ['required', 'string', 'max:100'],
        ], [
            'code.required' => 'Kode mata pelajaran wajib diisi.',
            'code.unique' => 'Kode mata pelajaran sudah digunakan.',
            'name.required' => 'Nama mata pelajaran wajib diisi.',
        ]);

        $createSubjectAction->execute(
            $request->only('code', 'name'),
            auth()->user()->school_id,
            auth()->id()
        );

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
