<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::all();
        return view('report.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $report = Report::find($id);
        if ($report) {
            return response()->json([
                'status' => 200,
                'message' => 'Report Edited Succesfully',
                'data' => $report,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Error',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $report = Report::find($id);
            $report->first_reminder_desc = $request->first_reminder_desc;
            $report->second_reminder_desc = $request->second_reminder_desc;
            $report->third_reminder_desc = $request->third_reminder_desc;
            $report->update();
            return response()->json([
                'status' => 200,
                'message' => 'Report Updated Succesfully',
                'data' => $report,
            ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }

    public function reminder($id)
    {
        $invoice = Invoice::find($id);
    }
}
