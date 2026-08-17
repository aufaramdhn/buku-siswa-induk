<?php

namespace App\Http\Controllers;

use App\Actions\School\UpdateSchoolAction;
use App\Http\Requests\SchoolUpdateRequest;
use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SchoolController extends Controller
{
    public function edit(): View
    {
        $schoolData = Cache::remember('active_school_profile', 86400, function () {
            $schoolModel = School::first();
            return $schoolModel ? $schoolModel->toArray() : [];
        });
        $school = new School($schoolData);
        $school->exists = true;

        return view('settings.index', compact('school'));
    }

    public function update(SchoolUpdateRequest $request, UpdateSchoolAction $updateSchoolAction): RedirectResponse
    {
        $school = School::first();

        $updateSchoolAction->execute($school, $request->validated());

        return redirect()->route('settings.edit')->with('success', 'Pengaturan sekolah berhasil diperbarui.');
    }
}
