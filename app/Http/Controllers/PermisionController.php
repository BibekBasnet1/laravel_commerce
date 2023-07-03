<?php

namespace App\Http\Controllers;

use App\Models\Permisson;
use Illuminate\Http\Request;

class PermisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permisson::get();
        return view('permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'string|required',
        ]);

        $permission = Permisson::create([
            'name' => $validation['name'],
        ]);
        // $permission->save();
        // after it has been successfully saved redirect to the home page 
        return redirect()->route('permission.index')->with('success','added permission');

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
        // basically it will help to get the permission id first
        // $permission = Permisson::where('id',$id)->first();
        $permission = Permisson::with('roles')->get();
        // it will help to return the view for editing files as well as for accessing the permisison
        // key and values
        // dd($permission);
        return view('permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // to update the following data 
        $validation = $request->validate([
            'name' => 'string|required',
        ]);

        // searching the data
        $permission = Permisson::findOrFail($id);
        // to validate the name we are trying to store
        $permission->name = $validation['name'];
        // to save the data
        $permission->save();
        return redirect()->route('permissions.index')->with('succes','saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permision = Permisson::where('id',$id)->first();
        $permision->delete();
        return redirect()->back()->with('success','deleted successfuylly');        
    }
}
