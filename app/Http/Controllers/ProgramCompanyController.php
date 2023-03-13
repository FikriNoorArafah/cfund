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
        $company = Auth::guard('company')->user();
        $interns = $this->getInterns($company->company_id);


        return response()->json([
            'company' => $company,
            'interns' => $interns,
        ]);
    }

    private function getInterns($companyId)
    {
        if (!$companyId) {
            return collect();
        }

        return Intern::where('company_id', $companyId)
            ->with(['companies', 'majors', 'educations', 'interests'])
            ->get();
    }

    public function insert(Request $request)
    {
        $companies = Auth::guard('company')->user();
        $request->validate([
            'interest' => 'required|string|max:255',
            'description' => 'nullable|string',
            'skill' => 'nullable|string',
            'require' => 'nullable|string',
            'education' => 'nullable|array',
            'major' => 'nullable|array'
        ]);

        $interest = Interest::firstOrCreate(['name' => $request->interest]);
        $majorIds = [];
        $educationIds = [];

        foreach ($request->major as $majorName) {
            $major = Major::firstOrCreate(['name' => $majorName]);
            $majorIds[] = $major->id;
        }

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

        $intern->interests()->sync($interest->id);
        $intern->educations()->syncWithoutDetaching($educationIds);
        $intern->majors()->syncWithoutDetaching($majorIds);

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
