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
        'cnic' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // Allow images and PDFs
        'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'city_id' => 'required|exists:cities,city_id',
        'status_id' => 'nullable',
         'member_type_id' => 'required|exists:membership_types,id', // Added validation for member type
    ]);

    // Step 2: Handle file uploads
    if ($request->hasFile('cv')) {
        $cvFile = $request->file('cv');
        $cvFilePath = $cvFile->store('uploads/cv', 'public'); // Save file in 'storage/app/public/uploads/cv'
        $validatedData['cv'] = $cvFilePath; // Save file path to the database
    }

    if ($request->hasFile('cnic')) {
        $cnicFile = $request->file('cnic');
        $cnicFilePath = $cnicFile->store('uploads/cnic', 'public'); // Save file in 'storage/app/public/uploads/cnic'
        $validatedData['cnic'] = $cnicFilePath; // Save file path to the database
    }

    // Step 3: Insert data into the database
    $detail = Detail::create($validatedData);

       // Step 4: Create the Member record
       $member = $detail->members()->create([
        'member_type_id' => $request->member_type_id, // Associate member type
    ]);

    // Step 5: Return a custom JSON response
    // return response()->json([
    //     'success' => true,
    //     'message' => 'Record created successfully.',
    //     'data' => $detail
    // ], 201);

    return response()->json([
        'success' => true,
        'message' => 'Record created successfully.',
        'data' => [
            'detail' => $detail,
            'member' => $member,
        ],
    ], 201);
}

}
