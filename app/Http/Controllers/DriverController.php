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
            $token = Auth::user()->createToken('API TOKEN')->plainTextToken;

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
            'front' => 'sometimes|image|mimes:jpeg,png,jpg,pdf|max:4096', // 4MB
            'back' => 'sometimes|image|mimes:jpeg,png,jpg,pdf|max:4096',
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

    /**
     * Upload driver's car registration details.
     */
    public function uploadCarRegistration(Request $request)
    {
        $request->validate([
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:4096', // 4MB
            'model' => 'sometimes|string',
            'model_type' => 'sometimes|string',
            'year' => 'sometimes|string',
            'color' => 'sometimes|string',
            'registration_number' => 'sometimes|string',
            'date_of_registration' => 'sometimes|date',
            'front' => 'sometimes|image|mimes:jpeg,png,jpg,pdf|max:4096', // 4MB
            'back' => 'sometimes|image|mimes:jpeg,png,jpg,pdf|max:4096',
        ]);

        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $old_images = [
                'image' => $driver->car_reg_details['image'] ?? null,
                'front' => $driver->car_reg_details['front'] ?? null,
                'back' => $driver->car_reg_details['back'] ?? null,
            ];

            $driver->car_reg_details = [
                'image' => $request->hasFile('image') ? $request->file('image')->store('car_registration') : $driver->car_reg_details['image'],
                'model' => $request->model ?? $driver->car_reg_details['model'],
                'model_type' => $request->model_type ?? $driver->car_reg_details['model_type'],
                'year' => $request->year ?? $driver->car_reg_details['year'],
                'color' => $request->color ?? $driver->car_reg_details['color'],
                'registration_number' => $request->registration_number ?? $driver->car_reg_details['registration_number'],
                'date_of_registration' => $request->date_of_registration ? date('Y-m-d', strtotime($request->date_of_registration)) : $driver->car_reg_details['date_of_registration'],
                'front' => $request->hasFile('front') ? $request->file('front')->store('car_registration') : $driver->car_reg_details['front'],
                'back' => $request->hasFile('back') ? $request->file('back')->store('car_registration') : $driver->car_reg_details['back'],
            ];

            $driver->save();

            // delete previous car registration images
            if ($request->hasFile('image') && $old_images['image']) {
                Storage::delete($old_images['image']);
            }

            if ($request->hasFile('front') && $old_images['front']) {
                Storage::delete($old_images['front']);
            }

            if ($request->hasFile('back') && $old_images['back']) {
                Storage::delete($old_images['back']);
            }

            return response()->json([
                'status' => true,
                'message' => 'Car registration details updated successfully',
                'data' => new DriverResource($driver),
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }

    /**
     * Update driver's bank details.
     */
    public function updateBankDetails(Request $request)
    {
        $request->validate([
            'beneficiary_name' => 'required|string',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'swift_code' => 'sometimes|string',
        ]);

        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $driver->bank_details = [
                'beneficiary_name' => $request->beneficiary_name ?? $driver->bank_details['beneficiary_name'],
                'bank_name' => $request->bank_name ?? $driver->bank_details['bank_name'],
                'account_number' => $request->account_number ?? $driver->bank_details['account_number'],
                'swift_code' => $request->swift_code ?? $driver->bank_details['swift_code'],
            ];

            $driver->save();

            return response()->json([
                'status' => true,
                'message' => 'Bank details updated successfully',
                'data' => new DriverResource($driver),
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }

    /**
     * Set driver's hourly delivery rate.
     */
    public function setHourlyRate(Request $request)
    {
        $request->validate([
            'rate' => 'required|numeric',
        ]);

        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $driver->hourly_delivery_rate = (float) $request->rate;
            $driver->save();

            return response()->json([
                'status' => true,
                'message' => 'Hourly delivery rate updated successfully',
                'data' => new DriverResource($driver),
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }
}
