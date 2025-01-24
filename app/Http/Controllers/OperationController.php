<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    
    public function index()
    {
        $operations = Operation::with('areaOfOperation')->get();
        return response()->json(['success' => true, 'data' => $operations]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_of_operation_id' => 'required|exists:area_of_operations,id',
            'future_plan_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'plan_operation_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'progress_report_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'first_meeting_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'last_meeting_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle file uploads
        $files = ['future_plan_file', 'plan_operation_file', 'progress_report_file', 'first_meeting_file', 'last_meeting_file'];
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $validated[$file] = $request->file($file)->store('uploads', 'public');
            }
        }

        $operation = Operation::create($validated);
        return response()->json(['success' => true, 'data' => $operation]);
    }

    public function update(Request $request, $id)
    {
        $operation = Operation::findOrFail($id);

        $validated = $request->validate([
            'area_of_operation_id' => 'required|exists:area_of_operations,id',
            'future_plan_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'plan_operation_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'progress_report_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'first_meeting_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'last_meeting_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle file uploads
        $files = ['future_plan_file', 'plan_operation_file', 'progress_report_file', 'first_meeting_file', 'last_meeting_file'];
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $validated[$file] = $request->file($file)->store('uploads', 'public');
            }
        }

        $operation->update($validated);
        return response()->json(['success' => true, 'data' => $operation]);
    }

    public function destroy($id)
    {
        $operation = Operation::findOrFail($id);
        $operation->delete();

        return response()->json(['success' => true, 'message' => 'Operation deleted successfully.']);
    }
}

