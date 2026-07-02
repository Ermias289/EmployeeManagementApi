<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;        

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth('api')->user();

        // IMPORTANT: force load Spatie relations
        $user->load('roles', 'permissions');

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }

    public function me(){
        return response()->json(auth('api')->user());
    }

    public function logout(){
        auth('api')->logout();
        return response()->json(['message' => 'User logged out successfully']);
    }

    public function destroy()
    {
        $user = auth('api')->user();

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

    public function destroyUserAdmin($id)
    {
        $user = User::findorFail($id);

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

    public function refreshToken(){
        return response()->json(
            [
                'token' => auth('api')->refresh(),
            ]
        );
    }

    public function assignRole(Request $request, User $user){
        $request -> validate([
            'role' => 'required|exist:role,name'
        ]);

        $user->syncRoles([$request -> role]);

        return response()->json([
            'message' => 'Role assigned successfully'
        ]);
    }
}
