<?php

namespace App\Http\Controllers;

use App\Models\AimObjective;
use App\Models\BasicInformation;
use App\Models\City;
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

  

//     public function store_member(Request $request)
// {
//     // Step 1: Validate incoming data
//     $validatedData = $request->validate([
//         'name' => 'required|string|max:255',
//         'father_name' => 'required|string|max:255',
//         'gender' => 'required|in:male,female,other',
//         'date_of_birth' => 'required|date',
//         'qualification' => 'required|string|max:255',
//         'designation' => 'nullable|string|max:255',
//         'occupation' => 'nullable|string|max:255',
//         'email' => 'required|email|unique:details,email',
//         'contact' => 'required|string|max:20',
//         'address' => 'nullable|string',
//         'cnic' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // Allow images and PDFs
//         'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
//         'city_id' => 'required|exists:cities,city_id',
//         'status_id' => 'nullable',
//          'member_type_id' => 'required|exists:membership_types,id', // Added validation for member type
//     ]);

//     // Step 2: Handle file uploads
//     if ($request->hasFile('cv')) {
//         $cvFile = $request->file('cv');
//         $cvFilePath = $cvFile->store('uploads/cv', 'public'); // Save file in 'storage/app/public/uploads/cv'
//         $validatedData['cv'] = $cvFilePath; // Save file path to the database
//     }

//     if ($request->hasFile('cnic')) {
//         $cnicFile = $request->file('cnic');
//         $cnicFilePath = $cnicFile->store('uploads/cnic', 'public'); // Save file in 'storage/app/public/uploads/cnic'
//         $validatedData['cnic'] = $cnicFilePath; // Save file path to the database
//     }

//     // Step 3: Insert data into the database
//     $detail = Detail::create($validatedData);

//        // Step 4: Create the Member record
//        $member = $detail->members()->create([
//         'member_type_id' => $request->member_type_id, // Associate member type
//     ]);

    

//     return response()->json([
//         'success' => true,
//         'message' => 'Record created successfully.',
//         'data' => [
//             'detail' => $detail,
//             'member' => $member,
//         ],
//     ], 201);
// }


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
        'status_id' => 'nullable|exists:statuses,id', // Validate status_id
        'member_type_ids' => 'required|array', // Accept an array of member types
        'member_type_ids.*' => 'exists:membership_types,id', // Validate each type
    ]);

    // Debugging Step: Check input data
     //dd($validatedData);

    // Step 2: Handle file uploads
    if ($request->hasFile('cv')) {
        $validatedData['cv'] = $request->file('cv')->store('uploads/cv', 'public');
    }

    if ($request->hasFile('cnic')) {
        $validatedData['cnic'] = $request->file('cnic')->store('uploads/cnic', 'public');
    }

    // Step 3: Insert data into the details table
    $detail = Detail::create([
        'name' => $validatedData['name'],
        'father_name' => $validatedData['father_name'],
        'gender' => $validatedData['gender'],
        'date_of_birth' => $validatedData['date_of_birth'],
        'qualification' => $validatedData['qualification'],
        'designation' => $validatedData['designation'],
        'occupation' => $validatedData['occupation'],
        'email' => $validatedData['email'],
        'contact' => $validatedData['contact'],
        'address' => $validatedData['address'],
        'cnic' => $validatedData['cnic'] ?? null,
        'cv' => $validatedData['cv'] ?? null,
        'city_id' => $validatedData['city_id'],
        'status_id' => $validatedData['status_id'], // Set null if missing
    ]);

    // Step 4: Assign multiple members to this detail
    foreach ($validatedData['member_type_ids'] as $memberTypeId) {
        $detail->members()->create([
            'member_type_id' => $memberTypeId,
        ]);
    }

    // Step 5: Return a custom JSON response
    return response()->json([
        'success' => true,
        'message' => 'Record created successfully with multiple members.',
        'data' => [
            'detail' => $detail,
            'members' => $detail->members,
        ],
    ], 201);
}


public function getCities()
{
    // Fetch all cities
    $cities = City::all();

    // Return cities as JSON response
    return response()->json([
        'success' => true,
        'message' => 'Cities retrieved successfully.',
        'data' => $cities,
    ], 200);
}


}
