<?php

namespace App\Http\Controllers;

use App\Actions\Extracurricular\CreateExtracurricularAction;
use App\Models\Extracurricular;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExtracurricularController extends Controller
{
    public function index(): View
    {
        $extracurriculars = Extracurricular::orderBy('code')->get();
        return view('extracurriculars.index', compact('extracurriculars'));
    }

    public function store(Request $request, CreateExtracurricularAction $createExtracurricularAction): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:extracurriculars,code'],
            'name' => ['required', 'string', 'max:100'],
        ], [
            'code.required' => 'Kode ekstrakurikuler wajib diisi.',
            'code.unique' => 'Kode ekstrakurikuler sudah digunakan.',
            'name.required' => 'Nama ekstrakurikuler wajib diisi.',
        ]);

        $createExtracurricularAction->execute(
            $request->only('code', 'name'),
            auth()->user()->school_id,
            auth()->id()
        );

        return redirect()->route('extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $extracurricular = Extracurricular::findOrFail($id);
        $extracurricular->delete();

        return redirect()->route('extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
