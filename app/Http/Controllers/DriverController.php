<?php

namespace App\Http\Controllers;

use App\Http\Resources\DriverResource;
use App\Http\Resources\UserResource;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    /**
     * Register a new driver.
     */
    public function register(Request $request)
    {
        $rules = [
            'user_id' => 'sometimes|integer',
            'username' => 'required|string|unique:drivers',
        ];

        // validate user details if user_id is not provided
        if (!$request->filled('user_id')) {
            $rules = array_merge($rules, [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string',
                'phone_number' => 'required|string|unique:users',
            ]);
        }

        $request->validate($rules);

        // check if user already exists, else create a new user
        if ($request->filled('user_id')) {
            if (!$user = User::find($request->user_id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }
        } else {
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);
        }

        // check if user has a driver account
        if (Driver::where('user_id', $user->id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'User already has a driver account'
            ], 400);
        }

        $driver = Driver::create([
            'user_id' => $user->id,
            'username' => $request->username,
            'acceptance_rating' => [
                'total' => 0,
                'count' => 0
            ],
            'hourly_delivery_rate' => 0,
        ]);

        $token = $user->createToken('API TOKEN')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Driver registered successfully',
            'data' => [
                'token' => $this->strright($token),
                'user' => new UserResource($user),
                'driver' => new DriverResource($driver),
            ],
        ], 201);
    }

    /**
     * Login a driver.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $driver = Driver::where('username', $request->username)->first();

        // authenticate driver if found and password is correct
        if ($driver && Auth::attempt(['email' => $driver->user->email, 'password' => $request->password])) {
            $token = Auth::user()->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Driver logged in successfully',
                'data' => [
                    'token' => $this->strright($token),
                    'user' => new UserResource(Auth::user()),
                    'driver' => new DriverResource($driver),
                ],
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid login details'
        ], 401);
    }

    /**
     * Upload driver's licence.
     */
    public function uploadDriverLicence(Request $request)
    {
        $request->validate([
            'number' => 'sometimes|string',
            'expiry_date' => 'sometimes|date',
            'country' => 'sometimes|string',
            'front' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:4096', // 4MB
            'back' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:4096',
        ]);

        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $old_images = [
                'front' => $driver->driver_licence['front'] ?? null,
                'back' => $driver->driver_licence['back'] ?? null,
            ];

            $driver->driver_licence = [
                'number' => $request->number ?? $driver->driver_licence['number'],
                'expiry_date' => $request->expiry_date ?? $driver->driver_licence['expiry_date'],
                'country' => $request->country ?? $driver->driver_licence['country'],
                'front' => $request->hasFile('front') ? $request->file('front')->store('driver_licence') : $driver->driver_licence['front'],
                'back' => $request->hasFile('back') ? $request->file('back')->store('driver_licence') : $driver->driver_licence['back'],
            ];

            $driver->save();

            // delete previous driver's licence images
            if ($request->hasFile('front') && $old_images['front']) {
                Storage::delete($old_images['front']);
            }

            if ($request->hasFile('back') && $old_images['back']) {
                Storage::delete($old_images['back']);
            }

            return response()->json([
                'status' => true,
                'message' => 'Driver licence updated successfully',
                'data' => new DriverResource($driver),
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }
}
