<?php

namespace App\Http\Controllers;

use App\Models\AimObjective;
use App\Models\BasicInformation;
use App\Models\Detail;
use Illuminate\Http\Request;

class BasicInformationController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'contact' => 'required|string',
        'address' => 'required|string',
        'constitution_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'aims' => 'required|array',
        
    ]);

    // dd($data);

    // Upload the constitution file
    if ($request->hasFile('constitution_file')) {
        $data['constitution_file'] = $request->file('constitution_file')->store('constitutions', 'public');
    }

    $basicInfo = BasicInformation::create($data);

    // Attach multiple aims
    $basicInfo->aims()->attach($data['aims']);

    return response()->json([
        'message' => 'Basic Information created successfully',
        'data' => $basicInfo->load('aims'),
    ], 201);
}

public function index()
    {
        // Fetch all aims
        $aims = AimObjective::all();

        // Return the data as JSON
        return response()->json([
            'message' => 'Aim Objectives retrieved successfully',
            'data' => $aims,
        ]);
    }



    public function store_member(Request $request)
{
    // Step 1: Validate incoming data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'father_name' => 'required|string|max:255',
        'gender' => 'required|in:male,female,other',
        'date_of_birth' => 'required|date',
        'qualification' => 'required|string|max:255',
        'designation' => 'nullable|string|max:255',
        'occupation' => 'nullable|string|max:255',
        'email' => 'required|email|unique:details,email',
        'contact' => 'required|string|max:20',
        'address' => 'nullable|string',
        'cnic' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'city_id' => 'required|exists:city_table,city_id',
        'status_id' => 'required|exists:statuses,id',
    ]);

    // Step 2: Insert data into the database
    $detail = Detail::create($validatedData);

    // Step 3: Return a custom JSON response
    return response()->json([
        'success' => true,
        'message' => 'Record created successfully.',
        'data' => $detail
    ], 201);
}

}
