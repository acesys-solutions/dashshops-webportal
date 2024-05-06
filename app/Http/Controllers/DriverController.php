<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClosestDriverResource;
use App\Http\Resources\DeliveryResource;
use App\Http\Resources\DriverResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\TrackingResource;
use App\Http\Resources\UserResource;
use App\Models\Delivery;
use App\Models\Driver;
use App\Models\RejectedDelivery;
use App\Models\Tracking;
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
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'phone_number' => 'required|phone|unique:users,phone_number',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'user_type' => 'Driver',
        ]);

        $driver = Driver::create([
            'user_id' => $user->id,
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
            'token' => $this->strright($token),
            'data' => [
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
            'phone_number' => 'required|phone',
            'password' => 'required|string',
        ]);

        // authenticate driver
        if (Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password])) {
            $token = Auth::user()->createToken('API TOKEN')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Driver logged in successfully',
                'token' => $this->strright($token),
                'data' => [
                    'user' => new UserResource(Auth::user()),
                    'driver' => new DriverResource(Driver::where('user_id', Auth::id())->first()),
                ],
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid login details'
        ], 401);
    }

    /**
     * Get driver's profile.
     */
    public function profile()
    {
        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            return response()->json([
                'status' => true,
                'data' => new DriverResource($driver),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }

    /**
     * Updated current driver's location.
     */
    public function updateCurrentLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'zip' => 'sometimes|string',
        ]);

        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $driver->current_location = [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'city' => $request->city ?? $driver->current_location['city'] ?? null,
                'state' => $request->state ?? $driver->current_location['state'] ?? null,
                'zip' => $request->zip ?? $driver->current_location['zip'] ?? null,
            ];

            $driver->save();

            return response()->json([
                'status' => true,
                'message' => 'Current location updated successfully',
                'data' => new DriverResource($driver),
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
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

    /**
     * Set driver's availability status.
     */
    public function setAvailability(Request $request)
    {
        $request->validate([
            'available' => 'required|boolean',
        ]);

        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $driver->available = $request->available;
            $driver->save();

            return response()->json([
                'status' => true,
                'message' => 'Availability status updated successfully',
                'data' => new DriverResource($driver),
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }

    /**
     * Get all drivers.
     */
    public function allDrivers()
    {
        $drivers = Driver::paginate(10);

        return response()->json([
            'status' => true,
            'data' => DriverResource::collection($drivers),
            'meta' => new PaginationResource($drivers),
        ], 200);
    }

    /**
     * Get driver by ID.
     */
    public function getDriver($id)
    {
        if ($driver = Driver::find($id)) {
            return response()->json([
                'status' => true,
                'data' => new DriverResource($driver),
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }

    /**
     * Get all available drivers.
     */
    public function allAvailableDrivers()
    {
        $drivers = Driver::where('available', true)
            ->where('approval_status', 'Approved')
            ->paginate(10);

        return response()->json([
            'status' => true,
            'data' => DriverResource::collection($drivers),
            'meta' => new PaginationResource($drivers),
        ], 200);
    }

    /**
     * Get closest available drivers.
     */
    public function closestAvailableDrivers(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // get all available drivers
        $drivers = Driver::where('available', true)
            ->whereNotNull('current_location')
            ->where('approval_status', 'Approved')
            ->take(20)
            ->get();

        // calculate distance between driver and user using Haversine formula
        foreach ($drivers as $driver) {
            $theta = $request->longitude - $driver->current_location['longitude'];
            $distance = sin(deg2rad($request->latitude)) * sin(deg2rad($driver->current_location['latitude'])) + cos(deg2rad($request->latitude)) * cos(deg2rad($driver->current_location['latitude'])) * cos(deg2rad($theta));
            $distance = acos($distance);
            $distance = rad2deg($distance);
            $miles = $distance * 60 * 1.1515;
            $driver->distance = $miles;
        }

        // sort drivers by distance
        $drivers = $drivers->sortBy('distance');

        return response()->json([
            'status' => true,
            'data' => ClosestDriverResource::collection($drivers),
        ], 200);
    }

    /**
     * Accept or decline delivery request
     */
    public function deliveryRequest(Request $request)
    {
        $request->validate([
            'accept' => 'required|boolean',
            'sales_id' => 'required|integer|unique:deliveries|exists:sales,id',
            'delivery_fee' => 'required|numeric',
        ]);

        $driver = Driver::where('user_id', Auth::id())
            ->where('available', true)
            ->where('approval_status', 'Approved')
            ->first();

        if ($driver) {
            if ($request->accept) {
                $driver->acceptance_rating = [
                    'total' => $driver->acceptance_rating['total'] + 1,
                    'count' => $driver->acceptance_rating['count'] + 1,
                ];

                Delivery::create([
                    'driver_id' => $driver->id,
                    'sales_id' => $request->sales_id,
                    'delivery_fee' => $request->delivery_fee,
                ]);
            } else {
                $driver->acceptance_rating = [
                    'total' => $driver->acceptance_rating['total'],
                    'count' => $driver->acceptance_rating['count'] + 1,
                ];

                // log rejected delivery
                RejectedDelivery::create([
                    'driver_id' => $driver->id,
                    'sales_id' => $request->sales_id,
                ]);
            }

            $driver->save();

            return response()->json([
                'status' => true,
                'message' => 'Delivery request ' . ($request->accept ? 'accepted' : 'declined') . ' successfully',
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }

    /**
     * Delivery picked up.
     */
    public function pickedUp($id, Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($delivery = Delivery::find($id)) {
            // check if delivery has been picked up
            if ($delivery->picked_at) {
                return response()->json([
                    'status' => false,
                    'message' => 'Delivery has already been picked up'
                ], 400);
            }

            $delivery->picked_at = now();
            $delivery->save();

            // start tracking
            $tracking = Tracking::create([
                'delivery_id' => $delivery->id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'location_log' => [
                    [
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'timestamp' => now(),
                    ],
                ],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Delivery picked up successfully',
                'delivery' => new DeliveryResource($delivery),
                'tracking' => new TrackingResource($tracking),
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Delivery not found'
        ], 404);
    }

    /**
     * Update delivery location.
     */
    public function updateLocation($id, Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($delivery = Delivery::find($id)) {
            // get last tracking
            $tracking = Tracking::where('delivery_id', $delivery->id)->latest()->first();

            // update tracking
            $tracking->location_log = array_merge($tracking->location_log, [
                [
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'timestamp' => now(),
                ],
            ]);
            $tracking->save();

            return response()->json([
                'status' => true,
                'message' => 'Location updated successfully',
                'tracking' => new TrackingResource($tracking),
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Delivery not found'
        ], 404);
    }

    /**
     * Delivery dropped off.
     */
    public function droppedOff($id, Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($delivery = Delivery::find($id)) {
            $delivery->delivered_at = now();
            $delivery->save();

            // update tracking
            $tracking = Tracking::where('delivery_id', $delivery->id)->latest()->first();
            $tracking->location_log = array_merge($tracking->location_log, [
                [
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'timestamp' => now(),
                ],
            ]);
            $tracking->save();

            return response()->json([
                'status' => true,
                'message' => 'Delivery dropped off successfully',
                'delivery' => new DeliveryResource($delivery),
                'tracking' => new TrackingResource($tracking),
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Delivery not found'
        ], 404);
    }
}
