<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Financial;
use App\Models\ProposedFinance;
use Illuminate\Http\Request;

class FinancialDetailController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'has_bank_account' => 'required|boolean',
            'bank_id' => 'nullable|exists:banks,id',
            'branch_name' => 'nullable|string|max:255',
            'branch_code' => 'nullable|string|max:255',
            'income_expenditure_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'prop_finan_id' => 'nullable|exists:proposed_finances,id',
        ]);

        // Handle file upload
        if ($request->hasFile('income_expenditure_file')) {
            $validated['income_expenditure_file'] = $request->file('income_expenditure_file')->store('uploads', 'public');
        }

        $financialDetail = Financial::create($validated);

        return response()->json(['success' => true, 'data' => $financialDetail]);
    }

    public function index()
    {
        $financialDetails = Financial::with(['bank', 'proposedFinance'])->get();

        return response()->json(['success' => true, 'data' => $financialDetails]);
    }

    public function update(Request $request, $id)
    {
        $financialDetail = Financial::findOrFail($id);

        $validated = $request->validate([
            'has_bank_account' => 'required|boolean',
            'bank_id' => 'nullable|exists:banks,id',
            'branch_name' => 'nullable|string|max:255',
            'branch_code' => 'nullable|string|max:255',
            'income_expenditure_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'prop_finan_id' => 'nullable|exists:proposed_finances,id',
        ]);

        if ($request->hasFile('income_expenditure_file')) {
            $validated['income_expenditure_file'] = $request->file('income_expenditure_file')->store('uploads', 'public');
        }

        $financialDetail->update($validated);

        return response()->json(['success' => true, 'data' => $financialDetail]);
    }

    public function destroy($id)
    {
        $financialDetail = Financial::findOrFail($id);
        $financialDetail->delete();

        return response()->json(['success' => true, 'message' => 'Financial detail deleted successfully.']);
    }

    public function getbank()
    {
        $banks = Bank::all();

        return response()->json(['success' => true, 'data' => $banks]);
    }

    public function ProposedFinanceget()
    {
        $proposedFinances = ProposedFinance::all();

        return response()->json(['success' => true, 'data' => $proposedFinances]);
    }
}
