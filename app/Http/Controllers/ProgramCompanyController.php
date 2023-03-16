<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Interest;
use App\Models\Intern;
use App\Models\Major;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramCompanyController extends Controller
{
    public function index()
    {
        $companies = Auth::guard('company')->user();
        $interns = Intern::with(['companies', 'majors', 'educations', 'interests', 'levels', 'departments'])
            ->where('interns.company_id', $companies->company_id)
            ->get();

        $data = [];
        foreach ($interns as $program) {
            $data[] = [
                'title' => $program->majors->pluck('name')->first(),
                'url' => $program->companies->url_icon,
                'company' => $program->companies->name,
                'region' => $program->companies->region,
                'city' => $program->companies->city,
                'kategori' => $program->interests->pluck('name')->first(),
                'education' => $program->educations->pluck('name'),
                'department' => $program->departments->pluck('name')->first(),
                'level' => $program->levels->pluck('name')->first(),
            ];
        }
        return response()->json([
            'company' => [
                'name' => $companies->name,
                'url_icon' => $companies->url_icon,
                'region' => $companies->region,
                'city' => $companies->city,
            ],
            'program' => $data,
        ]);
    }

    public function insert(Request $request)
    {
        $companies = Auth::guard('company')->user();
        $request->validate([
            'interest' => 'required',
            'description' => 'nullable',
            'skill' => 'nullable',
            'level' => 'nullable',
            'education' => 'nullable|array',
            'major' => 'nullable'
        ]);

        $interest = Interest::firstOrCreate(['name' => $request->interest]);
        $level = Interest::firstOrCreate(['name' => $request->level]);
        $major = Interest::firstOrCreate(['name' => $request->major]);
        $educationIds = [];

        foreach ($request->education as $educationName) {
            $education = Education::where('name', $educationName)->first();
            if ($education) {
                $educationIds[] = $education->id;
            }
        }

        $intern = new Intern;
        $intern->description = $request->description;
        $intern->company_id = $companies->company_id;
        $intern->status = 'recruiting';
        $intern->skill = $request->skill;
        $intern->require = $request->require;
        $intern->save();

        $intern->interests()->sync($interest->interest_id);
        $intern->majors()->sync($major->major_id);
        $intern->levels()->sync($level->level_id);
        $intern->educations()->syncWithoutDetaching($educationIds);


        return response()->json([
            'message' => 'Data berhasil ditambahkan.',
            'intern' => $intern,
        ]);
    }



    public function updateStatus(Request $request)
    {
        $request->validate([
            'intern_id' => 'required|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $internId = $request->intern_id;
        $status = $request->status;

        $intern = Intern::find($internId);
        if (!$intern) {
            return response()->json([
                'success' => false,
                'message' => 'Intern not found',
            ]);
        }

        $intern->status = $status;
        $intern->save();

        return response()->json([
            'success' => true,
            'message' => 'Intern status updated successfully',
            'intern' => $intern,
        ]);
    }
}
