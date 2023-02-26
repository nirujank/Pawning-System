<?php

namespace App\Http\Controllers;

use App\Models\Carratage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CarratageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carrat = Carratage::all();
        return view('carratage.index', compact('carrat'));
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
        $validator = Validator::make($request->all(), [
            'carratage_value' => 'required|integer',
            'value_per_gram' => 'required|regex:/^[0-9]+(\.[0-9]{1,1})?$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $carrat = new Carratage();
            $carrat->carratage_value = $request->carratage_value;
            $carrat->value_per_gram = $request->value_per_gram;
            $carrat->save();
            return response()->json([
                'status' => 200,
                'message' => 'Carratage Added Succesfully',
                'data' => $carrat,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Carratage $carratage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $carrat = Carratage::find($id);
        if ($carrat) {
            return response()->json([
                'status' => 200,
                'message' => 'Carratage Value Edited Succesfully',
                'data' => $carrat,
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
    public function update(Request $request, $id)
    {
        $carratage = Carratage::find($id);
        $validator = Validator::make($request->all(), [
            'carratage_value' => 'required|integer',
            'value_per_gram' => 'required|regex:/^[0-9]+(\.[0-9]{1,1})?$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $carratage->carratage_value = $request->carratage_value;
            $carratage->value_per_gram = $request->value_per_gram;
            $carratage->update();
            return response()->json([
                'status' => 200,
                'message' => 'Carratage Value Updated Succesfully',
                'data' => $carratage,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Carratage::where(['id' => $id])->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Carratage Deleted Succesfully',
        ]);
    }
}
