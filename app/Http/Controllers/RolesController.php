<?php

namespace App\Http\Controllers;

use App\Models\Permisson;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userRoles = Roles::get();
        // dd($userRoles->toArray());
        return view('roles.index',compact('userRoles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permisson::with('roles')->get();
        // dd($permissions->toArray());
        return view('roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */

     public function getRollId($id)
     {
         $roles = Roles::findOrFail($id); // Retrieve the Roles model based on the provided id
         $rollId = $roles->roll_id; // Access the roll_id attribute
 
         return $rollId;
     }

    // public function store(Request $request)
    // {
    //       //it is used to store the data
    //       $validatedData = $request->validate([
    //         'name' => 'required|string',
        
    //         // 'price' => 'required|numeric',
    //     ]);
    
    //     $permissions = $request->input('permissions', null);
    // // dd($permissions);
    //     dd($permission);
    //     // creating a new data using the validated data
    //     $rolls = Roles::create([
    //     'name' => $validatedData['name'],
    //     ]);

    //     return redirect()->route('roles.index')->with('Success','roles created successfully!');
    // }

    // storing the permission as well as the user
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            // Add any other validation rules you need
        ]);


        $role = Roles::create([
            'name' => $validatedData['name'],
        ]);
        
        // Get the selected permissions from the checkboxes
        $permissions = $request->input('permissions', []);

        $role->permissions()->attach($permissions);
        
        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
    */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // to return the new file to edit where form will be displayed
        $roles = Roles::where('id',$id)->first();
        // $currentRoles = $roles->permissons()->get();
        $permissions = Permisson::with("roles")->get();
        // dd($permissions->toArray());
        return view('roles.edit',compact('roles','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $roles = Roles::where('id',$id)->first();

        $validation = $request->validate([
            'name' => 'string|required',
        ]);

        $roles = Roles::findOrFail($id);
        // $product = Product::findOrFail($id);
        $roles->name = $validation['name'];
        // save the name that has been updated
        $roles->save();
        // Get the selected permissions from the checkboxes
        $permissions = $request->input('permissions', []);
        
        $roles->permissions()->sync($permissions);
        
        
        return redirect()->back()->with('success','successfully updated ');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
           // to get the $product based on the id
           $product = Roles::findOrFail($id);
           $product->delete();
           return redirect()->back()->with("success","Roles delete successfully");
    }
    
}
