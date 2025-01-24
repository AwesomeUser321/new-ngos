<?php

namespace App\Http\Controllers;

use App\Models\AimObjective;
use App\Models\BasicInformation;
use App\Models\City;
use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function basicget()
{
    // Fetch all aims along with basic information
    $aims = AimObjective::with('basicInformation')->get()->map(function ($aim) {
        return [
            'id' => $aim->id,
            'title' => $aim->title,
            'description' => $aim->description,
            'basic_information' => $aim->basicInformation->map(function ($info) {
                return [
                    'id' => $info->id,
                    'name' => $info->name,
                    'contact' => $info->contact,
                    'address' => $info->address,
                    'constitution_file' => $info->constitution_file,
                    'actions' => [
                        'view' => route('basic-information.view', $info->id),
                        'edit' => route('basic-information.edit', $info->id),
                    ],
                ];
            }),
        ];
    });

    // Return the data as JSON
    return response()->json([
        'message' => 'Aim Objectives retrieved successfully with related data',
        'data' => $aims,
    ], 200);
}
public function update(Request $request, $id)
{
    // Validate incoming request
    $data = $request->validate([
        'name' => 'string',
        'contact' => 'string',
        'address' => 'string',
        'constitution_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'aims' => 'array', // Expects an array of aim IDs
    ]);

    // Find the record by ID
    $basicInfo = BasicInformation::findOrFail($id);

    // Log the current state of data
    Log::info('Current data in database:', $basicInfo->toArray());

    // Check and log the incoming data
    Log::info('Incoming data:', $data);

    // Flag to track changes
    $updated = false;

    // Check if constitution file is provided
    if ($request->hasFile('constitution_file')) {
        $newFilePath = $request->file('constitution_file')->store('constitutions', 'public');
        // Check if file path has changed
        if ($basicInfo->constitution_file !== $newFilePath) {
            $data['constitution_file'] = $newFilePath;
            $updated = true; // Mark as updated if the file has changed
        }
    } else {
        unset($data['constitution_file']);  // Don't include file if not provided
    }

    // Compare each field and check if there's any change
    foreach ($data as $key => $value) {
        if ($basicInfo->{$key} !== $value) {
            Log::info("Field '{$key}' is changed. Old: {$basicInfo->{$key}} New: {$value}");
            $updated = true; // Mark as updated if any field is different
            break;
        }
    }

    // If no change, return early
    if (!$updated) {
        Log::info('No changes detected in the update.');
        return response()->json([
            'message' => 'No changes were made to the data.',
            'data' => $basicInfo,
        ], 200);
    }

    // Update the record
    $basicInfo->update($data);

    // Sync the aims if they are provided
    if (isset($data['aims']) && !empty($data['aims'])) {
        $basicInfo->aims()->sync($data['aims']);
    }

    // Return success response
    return response()->json([
        'message' => 'Basic Information updated successfully',
        'data' => $basicInfo->load('aims'), // Load the related aims after syncing
    ], 200);
}







    

//     public function store_member(Request $request)
// {
//     // Step 1: Validate incoming data
//        $validatedData = $request->validate([
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
        'name' => 'nullable|string|max:255',
        'father_name' => 'nullable|string|max:255',
        'gender' => 'nullable|in:male,female,other',
        'date_of_birth' => 'nullable|date',
        'qualification' => 'nullable|string|max:255',
        'designation' => 'nullable|string|max:255',
        'occupation' => 'nullable|string|max:255',
        'email' => 'nullable|email|unique:details,email',
        'contact' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'cnic' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // Allow images and PDFs
        'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'city_id' => 'nullable|exists:cities,city_id',
        'status_id' => 'nullable|exists:statuses,id', // Validate status_id
        'member_type_ids' => 'nullable|array', // Accept an array of member types
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
        'father_name' => $validatedData['father_name'] ?? null,
        'gender' => $validatedData['gender'] ?? null,
        'date_of_birth' => $validatedData['date_of_birth'] ?? null,
        'qualification' => $validatedData['qualification'] ?? null,
        'designation' => $validatedData['designation'] ?? null,
        'occupation' => $validatedData['occupation'] ?? null,
        'email' => $validatedData['email'] ?? null,
        'contact' => $validatedData['contact'] ?? null,
        'address' => $validatedData['address'],
        'cnic' => $validatedData['cnic'] ?? null,
        'cv' => $validatedData['cv'] ?? null,
        'city_id' => $validatedData['city_id'] ?? null, // Set null if missing      
        'status_id' => $validatedData['status_id'] ?? null, // Set null if missing
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


public function showMembers(Request $request)
{
    // Fetch all members with their related status and city data
    $members = Detail::with(['status', 'city'])
        ->get()
        ->map(function ($member, $index) {
            return [
                'sr' => $index + 1,
                'name' => $member->name,
                'date_of_birth' => $member->date_of_birth,
                'gender' => $member->gender,
                'email' => $member->email,
                'contact' => $member->contact,
                'address' => $member->address,
                'status' => $member->status ? $member->status->name : 'Pending', // Default to 'Pending' if null
                'actions' => [
                    'view' => route('members.view', $member->id),
                    'edit' => route('members.edit', $member->id),
                ],
            ];
        });

    // Return the data as a JSON response
    return response()->json([
        'success' => true,
        'message' => 'Members retrieved successfully.',
        'data' => $members,
    ], 200);
}

}
