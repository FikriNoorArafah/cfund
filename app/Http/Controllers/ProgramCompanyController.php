<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramCompanyController extends Controller
{
    public function index()
    {
        $company = Auth::guard('company')->user();
        $interns = $this->getInterns($company->company_id);


        if (request()->ajax()) {
            return response()->json([
                'company' => $company,
                'interns' => $interns,
            ]);
        }

        return view('company.program', compact('company', 'interns'));
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
