<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Education;
use App\Models\Intern;
use App\Models\Level;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function company()
    {
        $interns = Intern::with(['companies', 'majors', 'educations', 'levels', 'departments'])
            ->get()
            ->map(function ($intern) {
                return [
                    'id' => $intern->intern_id,
                    'desc' => $intern->description,
                    'skill' => json_decode($intern->skill),
                    'require' => json_decode($intern->require),
                    'title' => $intern->majors->pluck('name')->implode(', '),
                    'url' => $intern->companies->url_icon,
                    'company' => $intern->companies->name,
                    'region' => $intern->companies->region,
                    'city' => $intern->companies->city,
                    'education' => $intern->educations->pluck('name'),
                    'level' => $intern->levels->pluck('name')->implode(', '),
                    'jurusan' => $intern->departments->pluck('name'),
                ];
            });

        if ($interns->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Kamu belum memilki program',
            ]);
        }

        return response()->json([
            'interns' => $interns,
        ]);
    }

    public function insert(Request $request)
    {
        try {
            $companies = Auth::guard('company')->user();
            $request->validate([
                'description' => 'nullable',
                'skill' => 'nullable|array',
                'level' => 'nullable|array',
                'education' => 'nullable|array',
                'major' => 'nullable',
                'department' => 'nullable|array',
                'require' => 'nullable'
            ]);

            $level = Level::firstOrCreate(['name' => $request->level]);
            $major = Major::firstOrCreate(['name' => $request->major]);

            $departmentIds = Department::whereIn('name', $request->department)->pluck('department_id')->toArray();
            $educationIds = Education::whereIn('name', $request->education)->pluck('education_id')->toArray();

            $intern = new Intern;
            $intern->description = $request->description;
            $intern->company_id = $companies->company_id;
            $intern->status = 'Open';
            $intern->skill = json_encode($request->skill);
            $intern->require = json_encode($request->require);
            $intern->save();

            $intern->majors()->sync($major->major_id);
            $intern->levels()->sync($level->level_id);
            $intern->departments()->syncWithoutDetaching($departmentIds);
            $intern->educations()->syncWithoutDetaching($educationIds);

            return response()->json([
                'message' => 'Data berhasil ditambahkan.',
                'intern' => $intern,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan data.',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $companies = Auth::guard('company')->user();
        $request->validate([
            'description' => 'nullable',
            'skill' => 'nullable|array',
            'level' => 'nullable|array',
            'education' => 'nullable|array',
            'major' => 'nullable',
            'department' => 'nullable',
            'require' => 'nullable'
        ]);

        $level = Level::firstOrCreate(['name' => $request->level]);
        $major = Major::firstOrCreate(['name' => $request->major]);

        $departmentIds = Department::whereIn('name', $request->department)->pluck('department_id')->toArray();
        $educationIds = Education::whereIn('name', $request->education)->pluck('education_id')->toArray();

        $intern = Intern::find($id);

        if (!$intern) {
            return response()->json([
                'message' => 'Data not found.',
            ], 404);
        }

        if ($intern->company_id !== $companies->company_id) {
            return response()->json([
                'message' => 'Unauthorized action.',
            ], 401);
        }

        $intern->description = $request->description;
        $intern->skill = json_encode($request->skill);
        $intern->require = json_decode($request->require);
        $intern->save();

        $intern->majors()->sync($major->major_id);
        $intern->levels()->sync($level->level_id);
        $intern->departments()->syncWithoutDetaching($departmentIds);
        $intern->educations()->syncWithoutDetaching($educationIds);

        return response()->json([
            'message' => 'Data berhasil diperbarui.',
            'intern' => $intern,
        ]);
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'intern_id' => 'required',
            ]);
            $intern = Intern::find($request->intern_id);
            $intern->status = 'Deleted';
            $intern->save();

            return response()->json([
                'success' => true,
                'message' => 'Intern status updated successfully',
                'intern' => $intern,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    public function start(Request $request)
    {
        try {
            $request->validate([
                'intern_id' => 'required',
            ]);
            $intern = Intern::find($request->intern_id);
            $intern->status = 'Deleted';
            $intern->save();

            return response()->json([
                'success' => true,
                'message' => 'Intern status updated successfully',
                'intern' => $intern,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    public function stop(Request $request)
    {
        try {
            $request->validate([
                'intern_id' => 'required',
            ]);
            $intern = Intern::find($request->intern_id);
            $intern->status = 'Deleted';
            $intern->save();

            return response()->json([
                'success' => true,
                'message' => 'Intern status updated successfully',
                'intern' => $intern,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
