<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClosestDriverResource;
use App\Http\Resources\DeliveryResource;
use App\Http\Resources\DriverResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\RejectedDeliveryResource;
use App\Http\Resources\TrackingResource;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Driver;
use App\Models\DriverToken;
use App\Models\RejectedDelivery;
use App\Models\Retailer;
use App\Models\Sale;
use App\Models\SaleOrder;
use App\Models\State;
use App\Models\Tracking;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
        DriverToken::create([
            'driver_id' => $driver->id,
            'token' => Hash::make(
                $this->strright($token)
            )
        ]);

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
     * Update Driver device token
     */
    public function updateDeviceToken(Request $request)
    {
        $user = $request->user();
        $token = $request->bearerToken();

        Log::info("Bearer: = " . $token);

        if (Driver::where('user_id', $user->id)->exists()) {
            $driver = Driver::where('user_id', $user->id)->first();
            Log::info("Driver exsit");
            $id = 0;
            if (DriverToken::where(["driver_id" => $driver->id])->exists()) {
                Log::info("device token exist for driver");
                foreach (DriverToken::where(["driver_id" => $driver->id])->get() as $stuff) {
                    if (Hash::check($token, $stuff->token)) {
                        $id = $stuff->id;
                        break;
                    }
                }
                if ($id != 0) {
                    $loginToken = DriverToken::find($id);
                    $loginToken->device_token = $request->device_token;
                    $loginToken->device_type = $request->device_type;
                    $loginToken->save();
                    return response()->json([
                        'status' => true,
                        'message' => 'Device Token Updated Successfully',
                        'data' => $loginToken
                    ], 200);
                } else {
                    Log::info("Could not find match");
                    return response()->json([
                        'status' => false,
                        'message' => 'Token does not exist',
                    ], 204);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Token does not exist',
                ], 204);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Driver T does not exist',
        ], 404);
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

            if (!Driver::where('user_id', Auth::id())->exists()) {
                $driver = Driver::create([
                    'user_id' => Auth::id(),
                    'acceptance_rating' => [
                        'total' => 0,
                        'count' => 0
                    ],
                    'hourly_delivery_rate' => 0,
                ]);
            } else {
                $driver = Driver::where('user_id', Auth::id())->first();
            }
            DriverToken::create([
                'driver_id' => $driver->id,
                'token' => Hash::make($this->strright($token))
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Driver logged in successfully',
                'token' => $this->strright($token),
                'data' => [
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
     * Login a driver using email.
     */
    public function loginWithEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // authenticate driver
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = Auth::user()->createToken('API TOKEN')->plainTextToken;

            if (!Driver::where('user_id', Auth::id())->exists()) {
                $driver = Driver::create([
                    'user_id' => Auth::id(),
                    'acceptance_rating' => [
                        'total' => 0,
                        'count' => 0
                    ],
                    'hourly_delivery_rate' => 0,
                ]);
            } else {
                $driver = Driver::where('user_id', Auth::id())->first();
            }
            DriverToken::create([
                'driver_id' => $driver->id,
                'token' => Hash::make($this->strright($token))
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Driver logged in successfully',
                'token' => $this->strright($token),
                'data' => [
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
     * Get driver's profile requested by the driver.
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
     * Get driver's profile as request by another user.
     */
    public function driverProfile($id)
    {
        if ($driver = Driver::where('id', $id)->first()) {
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
            'city' => 'required|string',
            'state' => 'sometimes|string',
            'zip' => 'sometimes|string',
        ]);

        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $bearing = $this->getCurrentDirection(
                ["lat" => $driver->latitude, "lng" => $driver->longitude],
                ["lat" => $request->latitude, "lng" => $request->longitude]
            );
            $driver->current_location = [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'bearing' => $bearing,
                'city' => $request->city ?? $driver->current_location['city'] ?? null,
                'state' => $request->state ?? $driver->current_location['state'] ?? null,
                'zip' => $request->zip ?? $driver->current_location['zip'] ?? null,
            ];

            $driver->save();
            if ($tracking = Tracking::join('deliveries', 'deliveries.id', "=", "tracking.delivery_id")
                ->join('sale_orders', 'sale_orders.id', '=', 'deliveries.sales_id')
                ->select('tracking.*')->where("sale_orders.status", '<>', 'cancelled')
                ->where("sale_orders.status", '<>', 'delivered')
                ->where("sale_orders.driver_id", $driver->id)->first()
            ){
                $tracking->latitude = $request->latitude;
                $tracking->longitude = $request->longitude;
                $tracking->bearing = $request->bearing;
                $tracking->city = $request->city;
                $tracking->zip = $request->zip;
                $tracking->state = $request->state;
                $tracking->location_log = array_merge($tracking->location_log, [
                    [
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'bearing'=>$request->bearing,
                        'timestamp' => now(),
                    ],
                ]);
                $tracking->save();
            }

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
                'front' => $request->hasFile('front') ? $request->file('front')->store('driver_licence') : $old_images['front'],
                'back' => $request->hasFile('back') ? $request->file('back')->store('driver_licence') : $old_images['back'],
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
            'model' => 'required|string',
            'model_type' => 'required|string',
            'year' => 'required|string',
            'color' => 'required|string',
            'registration_number' => 'required|string',
            'date_of_registration' => 'required|date',
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
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $driver->hourly_delivery_rate = (float) $request->rate;
            $driver->start_time = $request->start_time;
            $driver->end_time = $request->end_time;
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
            if ($sale_order = SaleOrder::where("driver_id", $driver->id)->where('status', "Pending")->first()) {
                return response()->json([
                    'status' => false,
                    'message' => 'You cannot set availability status until you accept or reject pending delivery request',
                    'data' => new DriverResource($driver),
                ], 400);
            }
            $driver->available = $request->available;
            $driver->save();

            return response()->json([
                'status' => true,
                'message' => 'Availability status updated successfully',
                'data' => new DriverResource($driver),
            ], 200);
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
     * Get driver detail. (ClosestDriverResource)
     */
    public function getDriverDetailsLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' =>
            'required|numeric',
            'driver_id' => 'required|numeric',
        ]);

        $longitude = $request->longitude;
        $latitude = $request->latitude;

        if ($driver = Driver::with('user')->where('id', $request->driver_id)
            ->whereNotNull('current_location')
            ->where('drivers.approval_status', 'Approved')->first()
        ) {



            // calculate distance between driver and user using Haversine formula
            $theta = $longitude - $driver->current_location['longitude'];
            $distance = sin(deg2rad($latitude)) * sin(deg2rad($driver->current_location['latitude'])) + cos(deg2rad($latitude)) * cos(deg2rad($driver->current_location['latitude'])) * cos(deg2rad($theta));
            $distance = acos($distance);
            $distance = rad2deg($distance);
            $miles = $distance * 60 * 1.1515;
            $driver->distance = $miles;

            return response()->json([
                'status' => true,
                'data' => new ClosestDriverResource($driver),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => "Driver not longer available",
            ], 44);
        }
    }

    /**
     * Get closest available drivers.
     */
    public function closestAvailableDrivers(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        //{city: Las Vegas, latitude: 36.111199, longitude: -115.1401373}

        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $city = $request->city;

        // get all available drivers
        $drivers = Driver::with('user')->where('available', true)
            ->whereNotNull('current_location')
            ->where('drivers.approval_status', 'Approved')
            ->where('current_location->city', $city)
            ->where('start_time', '<=', now()->format('H:i'))
            ->where('end_time', '>=', now()->format('H:i'))
            ->get();

        // calculate distance between driver and user using Haversine formula
        foreach ($drivers as $driver) {
            $theta = $longitude - $driver->current_location['longitude'];
            $distance = sin(deg2rad($latitude)) * sin(deg2rad($driver->current_location['latitude'])) + cos(deg2rad($latitude)) * cos(deg2rad($driver->current_location['latitude'])) * cos(deg2rad($theta));
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

    public function startDelivery(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'order_id' => 'required|numeric'
        ]);
        $user = $request->user();
        $order_id = $request->order_id;

        if ($driver = Driver::where("user_id", $user->id)->first()) {
            if ($sale_order = SaleOrder::where("id", $order_id)->where("status", "=", "pending start")->first()) {
                if ($delivery = Delivery::where("sales_id", $order_id)->first()) {

                    $sale_order->status = "Pending Pickup";
                    $sale_order->save();
                    $driver->available = true;
                    $driver->save();
                    // start tracking
                    $tracking = Tracking::create([
                        'delivery_id' => $delivery->id,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'bearing' => $request->bearing,
                        'zip' => $request->zip,
                        'state' => $request->state,
                        'city' => $request->city,
                        'location_log' => [
                            [
                                'latitude' => $request->latitude,
                                'longitude' => $request->longitude,
                                'bearing' => $request->bearing,
                                'timestamp' => now(),
                            ],
                        ],
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'Delivery picked up successfully',
                        'delivery' => new DeliveryResource($delivery),
                        'tracking' => new TrackingResource($tracking),
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Delivery not found'
                    ], 404);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Order is no longer available'
                ], 400);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }

    /**
     * Accept or decline delivery request
     */
    public function deliveryRequest(Request $request)
    {
        $request->validate([
            'accept' => 'required|boolean',
            'sales_id' => 'required|integer',
            'delivery_fee' => 'required|numeric',
        ]);
        $notif = new \App\Http\Controllers\NotificationsController();

        $driver = Driver::where('user_id', Auth::id())
            ->where('approval_status', 'Approved')
            ->first();

        if ($driver) {
            // check if driver has a pending delivery
            //as soon as a pending delivery shows up the driver's availabilty changes to false
            /*if (Delivery::where('driver_id', $driver->id)->where('status', 'Pending')->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'You have a pending delivery.'
                ], 400);
            }*/
            if ($sale_order = SaleOrder::where("id", $request->sales_id)->where('status', 'Pending')->first()) {
                Delivery::create([
                    'driver_id' => $driver->id,
                    'sales_id' => $request->sales_id,
                    'delivery_fee' => $request->delivery_fee,
                    'status'=> $request->accept?"Pending":"Rejected"
                ]);
                $sale_order->status = "Pending Start";
                $sale_order->save();
            } else {
                //remember to set the driver's availability back to true
                $driver->available = true;
                $driver->save();
                return response()->json([
                    'status' => false,
                    'message' => 'Delivery request has been cancelled'
                ], 400);
            }

            if ($request->accept) {
                $driver->acceptance_rating = [
                    'total' => $driver->acceptance_rating['total'] + 1,
                    'count' => $driver->acceptance_rating['count'] + 1,
                ];

                // make driver unavailable
                $driver->available = false;
                Log::info($notif->setNotification(new \App\Models\Notification([
                    "user_id" => $sale_order->user_id,
                    "title" => "Order #" . $sale_order->order_number . " Delivery Was Accepted",
                    "content" => "Your order delivery request was accepted by the driver. You can open the order to track the status of your delivery. Thanks for using Dash Shops",
                    "type" => "Sale Order",
                    "source_id" => $sale_order->id,
                    "has_read" => false,
                    "trash" => false
                ])));
            } else {
                $driver->acceptance_rating = [
                    'total' => $driver->acceptance_rating['total'],
                    'count' => $driver->acceptance_rating['count'] + 1,
                ];

                //remember to set the driver's availability back to true
                $driver->available = true;
                $sale_order->status = "Rejected by Driver";
                $sale_order->save();




                // log rejected delivery
                RejectedDelivery::create([
                    'driver_id' => $driver->id,
                    'sales_id' => $request->sales_id,
                    'delivery_fee' => $sale_order->delivery_fee
                ]);
                Log::info($notif->setNotification(new \App\Models\Notification([
                    "user_id" => $sale_order->user_id,
                    "title" => "Order #" . $sale_order->order_number . " Delivery Aot Accepted",
                    "content" => "Your order delivery request was not accepted by the driver. Please open the order to selected another driver",
                    "type" => "Sale Order",
                    "source_id" => $sale_order->id,
                    "has_read" => false,
                    "trash" => false
                ])));
                $user_id = $sale_order->user_id;
                $sale_order_id = $sale_order->id;
                if ($sale_order = SaleOrder::with('sales')->with('driver')->find($sale_order_id)) {
                    foreach ($sale_order->sales as $sale) {
                        Cart::create([
                            "user_id" => $user_id,
                            "product_variation_id" => $sale->product_variation_id,
                            "quantity" => $sale->quantity,
                        ]);
                    }
                    Sale::whereIn('order_id', [$sale_order_id])->delete();
                    $sale_order->delete();

                }
            }

            $driver->save();

            return response()->json([
                'status' => true,
                'message' => 'Delivery request ' . ($request->accept ? 'accepted' : 'declined') . ' successfully',
            ], 200);
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

            $delivery->status = 'Picked';
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
            ], 200);
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
            ], 200);
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
            $delivery->status = 'Delivered';
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

            // make driver available
            $driver = Driver::find($delivery->driver_id);
            $driver->available = true;
            $driver->save();

            return response()->json([
                'status' => true,
                'message' => 'Delivery dropped off successfully',
                'delivery' => new DeliveryResource($delivery),
                'tracking' => new TrackingResource($tracking),
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Delivery not found'
        ], 404);
    }
    //get pending driver request
    public function getPendingDeliveryRequest(Request $request)
    {
        $user = $request->user();
        $driver = Driver::where("user_id", $user->id)->first();

        if ($sale_order = SaleOrder::with('user')->with('sales')
            ->with('sales.retailer')->where('driver_id', $driver->id)->where('status', "Pending")->first()
        ) {
            return
                response()->json([
                    'status' => true,
                    'data' => $sale_order
                ], 200);
        } else {
            return
                response()->json([
                    'status' => true,
                    'message' => 'No pending delivery at this time'
                ], 201);
        }
    }
    public function deliveryHistory(Request $request)
    {
        $user = $request->user();
        $status = "all";
        if ($request->has('status'))
            $status = $request->status;
        Log::info($status);
        if ($driver = Driver::where('user_id', $user->id)->first()) {
            if ($status != "rejected") {
                $deliveries = Delivery::with("sale_order")->with('sale_order.user')->with('sale_order.sales')->with('sale_order.sales.retailer')
                    ->where('driver_id', $driver->id);
                if ($status != "all") {
                    $deliveries = $deliveries->where('status', $status);
                }
                $deliveries = $deliveries->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $deliveries = RejectedDelivery::with("sale_order")->with('sale_order.user')->with('sale_order.sales')->with('sale_order.sales.retailer')
                    ->where('driver_id', $driver->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                $deliveries = RejectedDeliveryResource::collection($deliveries);
            }
            return
                response()->json([
                    'status' => true,
                    'data' => $deliveries
                ], 200);
        } else {
            return
                response()->json([
                    'status' => false,
                    'message' => 'Could not find driver'
                ], 404);
        }
    }
    function approveDriver(Request $request){
        if($driver = Driver::find($request->id)){
            $driver->approval_status = "Approved";
            $driver->save();
            $notif = new \App\Http\Controllers\NotificationsController();
            $notif->setDriverNotification(new \App\Models\DriverNotification([
                "driver_id" => $driver->id,
                "title" => "Dash shop Driver Profile has been approved",
                "content" => "Your driver's profile has been approved by Dash shops. Thanks for using Dash Shops",
                "type" => "Driver",
                "source_id" => $driver->id,
                "has_read" => false,
                "trash" => false
            ]));
            return response()->json([
                "status" => true,
                "message" => "Driver profile has been approved"
            ], 200);
        }
    }
    function denyDriver(Request $request)
    {
        if ($driver = Driver::find($request->id)) {
            $driver->approval_status = "Denied";
            $driver->save();
            $notif = new \App\Http\Controllers\NotificationsController();
            $notif->setDriverNotification(new \App\Models\DriverNotification([
                "driver_id" => $driver->id,
                "title" => "Dash shop driver profile approval was denied",
                "content" => "Your driver's profile has been rejected by Dash shops for the following reason: " . $request->reason . ". Kindly review and update the product listing.",
                "type" => "Driver",
                "source_id" => $driver->id,
                "has_read" => false,
                "trash" => false
            ]));
            return response()->json([
                "status" => true,
                "message" => "Driver profile has been rejected"
            ], 200);
        }
    }
    function searchDrivers(Request $request){
        $state = $request->has('state') ? $request->get('state') : "0";
        $page = $request->has('page') ? $request->get('page') : 1;

        $status = $request->has('status') ? $request->get('status') : "all";
        $search = $request->has('search') ? $request->get('search') : "";

        $drivers = Driver::with('user')->join('users','users.id','=','drivers.user_id')->select('drivers.*');
        if($state!="0" && $state != "all"){
            $drivers = $drivers->where('users.state',$state);
        }
        if ($status != "all") {
            $drivers = $drivers->where('drivers.status', $status);
        }
        $drivers = $drivers->get();
        //var_dump()

        return view('pages.drivers-table', compact(['drivers']));

    }
    function showDrivers(Request $request){
        
        $states = State::all();
        $total_downloads = $this->getTotalDownloads(); // CouponDownloads::sum('Downloads');
        $total_clicks = $this->getTotalClicks(); //CouponClicks::sum('clicks');
        $total_redemptions = $this->getTotalRedemptions(); // CouponRedeemed::count();
        return view('pages.drivers', compact(['states', 'total_downloads', 'total_clicks', 'total_redemptions']));
    }
}
