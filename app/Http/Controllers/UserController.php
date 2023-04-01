<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\AssignOp\Concat;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'role' => 'required',
            'dessignation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->dessignation = $request->dessignation;
            $user->status = "Active";
            $user->password = bcrypt('password');
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => 'User Added Succesfully',
                'data' => $user,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'status' => 200,
                'message' => 'User Edited Succesfully',
                'data' => $user,
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
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->dessignation = $request->dessignation;
            $user->status = $request->status;
            $user->update();
            return response()->json([
                'status' => 200,
                'message' => 'User Updated Succesfully',
                'data' => $user,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where(['id' => $id])->delete();
        return response()->json([
            'status' => 200,
            'message' => 'User Deleted Succesfully',
        ]);
    }

    public function profile(){
       $user= Auth::user();
       return $user;
    }
}
