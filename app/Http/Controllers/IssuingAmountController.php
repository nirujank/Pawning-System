<?php

namespace App\Http\Controllers;

use App\Models\IssuingAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IssuingAmountController extends Controller
{
    public function index()
    {
        $issuing = IssuingAmount::all();
        return view('issue.index', compact('issuing'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'max_issue_amount' => 'required|regex:/^[0-9]+(\.[0-9]{1,3})?$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $issue = new IssuingAmount();
            $issue->max_issue_amount = $request->max_issue_amount;
            $issue->save();
            return response()->json([
                'status' => 200,
                'message' => 'Issuing Amount Updated Succesfully',
                'data' => $issue,
            ]);
        }
    }
}
