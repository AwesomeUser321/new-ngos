<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function showExecutiveBody()
    {
        // Fetch general body members using the 'members' table
        $generalBodyMembers = Member::with(['detail.status', 'detail.city'])
            ->where('member_type_id', 3) // Assuming '2' is the ID for 'General Body' in the membership_types table
            ->get()
            ->map(function ($member, $index) {
                $detail = $member->detail; // Fetch related details
                return [
                    'sr' => $index + 1,
                    'name' => $detail->name,
                    'father_name' => $detail->father_name,
                    'qualification' => $detail->qualification,
                    'cnic' => $detail->cnic,
                    'contact' => $detail->contact,
                    'designation' => $detail->designation,
                    'address' => $detail->address,
                    'upload_cv' => $detail->cv ? 'File' : 'No File',
                    'status' => $detail->status ? $detail->status->title : 'Pending',
                    'actions' => [
                        'view' => route('members.view', $member->id),
                        'edit' => route('members.edit', $member->id),
                    ],
                ];
            });
    
        // Return as JSON response
        return response()->json([
            'success' => true,
            'message' => 'Excutive body retrieved successfully.',
            'data' => $generalBodyMembers,
        ], 200);
    }


    public function showGeneralBody()
    {
        // Fetch general body members using the 'members' table
        $generalBodyMembers = Member::with(['detail.status', 'detail.city'])
            ->where('member_type_id', 2) // Assuming '2' is the ID for 'General Body' in the membership_types table
            ->get()
            ->map(function ($member, $index) {
                $detail = $member->detail; // Fetch related details
                return [
                    'sr' => $index + 1,
                    'name' => $detail->name,
                    'father_name' => $detail->father_name,
                    'qualification' => $detail->qualification,
                    'cnic' => $detail->cnic,
                    'contact' => $detail->contact,
                    'designation' => $detail->designation,
                    'address' => $detail->address,
                    // 'upload_cv' => $detail->cv ? 'File' : 'No File',
                    'status' => $detail->status ? $detail->status->title : 'Pending',
                    'actions' => [
                        'view' => route('members.view', $member->id),
                        'edit' => route('members.edit', $member->id),
                    ],
                ];
            });
    
        // Return as JSON response
        return response()->json([
            'success' => true,
            'message' => 'General body retrieved successfully.',
            'data' => $generalBodyMembers,
        ], 200);
    }
    
    

}
