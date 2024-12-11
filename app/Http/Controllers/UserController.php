<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\Operator;
use App\Models\NotificationRecipient;

class UserController extends Controller
{

    public function index()
    {
        // Fetch all users, or you can paginate if needed
        $users = User::all(); // Or use pagination: User::paginate(10);

        return view('admin.user-list', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate the form data

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3',  // Add 'confirmed' for password confirmation
            'role' => 'required|string|in:admin,operator,client',
        ]);
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            // Add other necessary fields if needed
        ]);

        if ($request->role === 'client') {
            Client::create([
                'user_id' => $user->id,  // Reference to the User table
                // Add other Client-specific data here
            ]);
        } elseif ($request->role === 'operator') {
            Operator::create([
                'user_id' => $user->id,  // Reference to the User table
                // Add other Operator-specific data here
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User created successfully!');
    }

    // Show the form to edit a user
    public function edit($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Return the view with the user data
        return view('admin.users.edit', compact('user'));
    }

    // Update the user's information
    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:admin,operator,client',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Redirect with success message
        return back()->with('success', 'User updated successfully!');
    }

    // Delete a user
    public function destroy($id)
    {
        // Find the user and delete it
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect with success message
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
