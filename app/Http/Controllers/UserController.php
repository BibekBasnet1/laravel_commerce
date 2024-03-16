<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // to get all the user 
    public function getUser()
    {
        // to get the user 
        $users = User::with('products','roles')->get();
        // dd($users);
        // to implement logic and return the view where we have grabbed all the user from the database
        return view('users.index',compact('users'));
    }

    // function to get edit the user
    public function editUser($id)
    {
        // select * from user where id = parameter id 
        $user = User::where('id',$id)->first();
        return view('users.edit',compact('user'));
    }

    public function updateUser(Request $request,$id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);
         // Find the user by ID
         $user = User::findOrFail($id);

         // Update the user data
         $user->name = $validatedData['name'];
         $user->email = $validatedData['email'];
         $user->save();
 
         // Redirect back or to a different page
         return redirect()->back()->with('success', 'User updated successfully');
    }

    // to delete the user 
    public function deleteUser($id)
    {
        // basically it will get the id for the person 
        $currentUser = User::findOrFail($id);
        if($currentUser){
            $currentUser->delete();
        }
        return redirect()->back()->with('success','User deleted successfully');
    }

    // to add the user in redirect into new form
    public function addUser()
    {
        $roles = Roles::get();
        // take the roll id of the current logged in user
        $userId = Auth::id() ;
        // dd($userId);
        return view('users.create',compact('roles','userId'));
    }

    public function createUser(Request $request)
    {
     
        // $validatedData = $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|string|min:6',
            
        // ]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
           
        ]);
 
        if ($validator->fails()) {
            // dd($validator->getMessageBag());
            return back()->withErrors($validator)->withInput();
        }
        
        // dd($validatedData); 
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        // $user->Nickname = "example";
        $user->save();

        $roleId = $request->role;
        $user->roles()->attach($roleId); // Assign the selected role to the user

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    // it will get the userProducts with the referenced id we search for 
    public function getUserProduct($id)
    {
        // 
        $users = User::with('products')->find($id);
        
        return response()->json($users);
    }

}
