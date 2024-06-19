<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleOrder;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SaleOrderResource;
use App\Models\Cart;
use App\Models\Driver;
use App\Models\ProductVariant;
use App\Models\Tracking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    //create sales from cart items
    function create(Request $request)
    {
        $user = $request->user();
        /*
        'order_number',
        'user_id',
        'is_store_pickup',
        'driver_id',
        'status',
        'service_charge',
        'total_discount',
        'total_cost',
        'delivery_fee',
        'proposed_route',
        */
        $request->validate([
            'is_store_pickup' => 'required|boolean',
            'driver_id' => 'sometimes|string',
            'service_charge' => 'required|numeric',
            'total_cost' => 'required|numeric',
        ]);

        $sale_order = SaleOrder::create([
            'order_number' => time(),
            'user_id' => $user->id,
            'is_store_pickup' => $request->is_store_pickup,
            'driver_id' => $request->driver_id,
            'driver_location' => $request->driver_location,
            'status' => "Pending",
            'service_charge' => $request->service_charge,
            'total_discount' => $request->total_discount ?? 0,
            'total_distance' => $request->total_distance ?? "0 miles",
            'total_cost' => $request->total_cost,
            'total_time' => $request->total_time,
            'total_duration' => $request->total_duration,
            'delivery_fee' => $request->delivery_fee ?? 0,
            'proposed_route' => $request->proposed_route,
            'address' => $user->business_address,
            'city' => $user->city,
            'state' => $user->state,
        ]);


        $products = DB::table('cart')
            ->join('product_variation', 'product_variation.id', '=', 'cart.product_variation_id')
            ->join('products', 'products.id', '=', 'product_variation.product_id')
            ->join('retailers', 'retailers.id', '=', 'products.store_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select(DB::raw("cart.quantity, " . $this->getSelectDBRawCartDisplay()))
            ->where('cart.user_id', '=', $user->id)
            ->where('products.status', '=', 1)
            ->where('product_variation.status', '=', 1);
        $products = $products->groupBy("cart.id")
            ->get();
        $sale_records = [];
        $count = 0;
        foreach ($products as $product) {
            $count++;
            $ext = pathinfo(
                public_path($product->image),
                PATHINFO_EXTENSION
            );
            $filename = time() . '_' . $count . '.' . $ext;
            File::copy(public_path('images/' . $product->image), public_path('images/sales/' . $filename));
            array_push($sale_records, [
                'user_id' => $user->id,
                'product_variation_id' => $product->product_variation_id,
                'product_id' => $product->id,
                'retailer_id' => $product->store_id,
                'business_name' => $product->business_name,
                'product_name' => $product->product_name,
                'product_image' => 'sales/' . $filename,
                'quantity' => $product->quantity,
                'unit_cost' => $product->product_is_on_sale == 1 ? $product->sale_price : $product->price,
                'variation_name' => $product->variant_type_values,
                'status' => 'Pending',
            ]);
            $pv = ProductVariant::where('id', $product->product_variation_id)->first();
            Log::info("pv_id: " . $product->product_variation_id . " init quant:  " . $pv->quantity);
            $pv->quantity = $pv->quantity - $product->quantity;
            Log::info("final quant: " . $pv->quantity);
            $pv->save();
        }
        $sale_order->sales()->createMany(
            $sale_records
        );
        Cart::whereIn('user_id', [$user->id])->delete();
        $notif = new \App\Http\Controllers\NotificationsController();
        $content = "Your order with order number " . $sale_order->order_number . " has been created successful.";
        if (filter_var($request->is_store_pickup, FILTER_VALIDATE_BOOLEAN)) {
            $content = $content . " Please store to pickup your items";
        } else {
            $driver = Driver::with("user")->where("id", $request->driver_id)->first();
            $driver->available = false;
            $driver->save();
            $content = $content . " Drivery should be made by " . $driver->user->firstname . " " . $driver->user->lastname . ". You can reach him on " . $driver->user->phone_number . " concerning your delivery";
        }
        Log::info($notif->setNotification(new \App\Models\Notification([
            "user_id" => $user->id,
            "title" => "Order #" . $sale_order->order_number . " Created",
            "content" => $content,
            "type" => "Sale Order",
            "source_id" => $sale_order->id,
            "has_read" => false,
            "trash" => false
        ])));
        if (!filter_var($request->is_store_pickup, FILTER_VALIDATE_BOOLEAN)) {
            Log::info($notif->setDriverNotification(new \App\Models\DriverNotification([
                "driver_id" => $driver->id,
                "title" => "You have a pending delivery #" . $sale_order->order_number,
                "content" => $user->firstname . " " . $user->lastname . " has just selected you to help pickup and deliver #" . $sale_order->order_number . ". You can reach the customer via " . $user->phone_number . ".",
                "type" => "Sale Order",
                "source_id" => $sale_order->id,
                "has_read" => false,
                "trash" => false
            ])));
        }
        return response()->json([
            "status" => true,
            "data" => $sale_order
        ], 201);
    }
    function getSaleOrder(Request $request, $id)
    {
        $user = $request->user();

        if ($sale_order = SaleOrder::with('driver')->with('sales')->with('sales.retailer')->with('sales.retailer.user')->where("id", $id)->first()) {
            return response()->json([
                'status' => true,
                'data' => $sale_order,
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Sale Order not found'
        ], 404);
    }
    function cancelPendingSaleOrder(Request $request)
    {
        $user = $request->user();
        $sale_order_id = $request->id;
        if ($sale_order = SaleOrder::with('sales')->with('driver')->where(['user_id' => $user->id, 'id' => $sale_order_id, "status" => "pending"])->first()) {
            foreach ($sale_order->sales as $sale) {
                Cart::create([
                    "user_id" => $user->id,
                    "product_variation_id" => $sale->product_variation_id,
                    "quantity" => $sale->quantity,
                ]);
            }
            Sale::whereIn('order_id', [$sale_order_id])->delete();
            $notif = new \App\Http\Controllers\NotificationsController();
            $notif->setDriverNotification(new \App\Models\DriverNotification([
                "user_id" => $sale_order->driver->user_id,
                "title" => "Order #" . $sale_order->order_number . ". has been cancelled by custom",
                "content" => "Your pending request for delivery, #" . $sale->order_number . " was just cancelled by the buyer.",
                "type" => "Cancelled Sale Order",
                "source_id" => $sale_order->id,
                "has_read" => false,
                "trash" => false
            ]));
            Driver::find($sale_order->driver_id)->update(['available' => true]);
            $sale_order->delete();

            return response()->json([
                'status' => true,
                'message' => "Order has been cancelled and your items returned to your shopping cart",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Sorry, this order cannot be cancelled at this time. Please contact admin@thedashshop.com if you still want to can thiis order",
            ], 404);
        }
    }
    function getUserPendingDeliverySaleOrder(Request $request)
    {
        $user = $request->user();

        $sale_orders = SaleOrder::with('sales')
            ->with('sales.retailer')
            ->where("sale_orders.user_id", $user->id)
            ->where('sale_orders.status', "<>", "Delivered")
            ->where('sale_orders.status', "<>", "Cancelled")
            ->where('sale_orders.is_store_pickup', false)
            ->where('sale_orders.status', "<>", "Cancelled By Retailer")
            ->where('sale_orders.status', "<>", "Rejected By Driver")
            ->get();
        return response()->json([
            'status' => true,
            'data' => $sale_orders,
        ]);
    }
    function getUserPendingSaleOrder(Request $request)
    {
        $user = $request->user();

        $sale_orders = SaleOrder::with('sales')
            ->with('sales.retailer')
            ->where("sale_orders.user_id", $user->id)
            ->where('sale_orders.status', "<>", "Delivered")
            ->where('sale_orders.status', "<>", "Cancelled")
            ->where('sale_orders.status', "<>", "Rejected By Driver")
            ->where('sale_orders.status', "<>", "Cancelled By Retailer")
            ->get();
        return response()->json([
            'status' => true,
            'data' => $sale_orders,
        ]);
    }
    function getDriverTracking(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'order_id' => 'required|numeric',
        ]);
        $order_id = $request->order_id;

        if ($tracking = Tracking::join('deliveries', 'deliveries.id', '=', 'tracking.delivery_id')
            ->join('sale_orders', 'sale_orders.id', '=', 'deliveries.sales_id')
            ->select('tracking.*')->where('deliveries.sales_id', $order_id)
            ->where('sale_orders.user_id', $user->id)
            ->first()
        ) {
            return response()->json([
                'status' => true,
                'data' => $tracking,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Delivery Tracking not available",
            ]);
        }
    }
    function getUserDeliveredSaleOrder(Request $request)
    {
        $user = $request->user();

        $sale_orders = SaleOrder::with('sales')
            ->with('sales.retailer')
            ->where("sale_orders.user_id", $user->id)
            ->where('sale_orders.status', "=", "Delivered")
            ->get();
        return response()->json([
            'status' => true,
            'data' => $sale_orders,
        ]);
    }
    function getRetailerPendingSaleOrder(Request $request)
    {
        $user = $request->user();

        $sale_orders = Sale::with('sale_order')->where("retailer_id", $user->retailer_id)
            ->where('status', "<>", "Delivered")
            ->where('status', "<>", "Cancelled")
            ->get();
        return response()->json([
            'status' => true,
            'data' => $sale_orders,
        ]);
    }
    function getRetailerSaleOrders(Request $request)
    {
        $user = $request->user();

        $sale_orders = Sale::with('sale_order')->with('sale_order.user')->with('sale_order.driver')->with('sale_order.driver.user')->where("sales.retailer_id", $user->retailer_id)
            ->orderBy('sales.created_at', 'desc')
            ->get();
        return response()->json([
            'status' => true,
            'data' => $sale_orders,
        ]);
    }
    function getUserSaleOrders(Request $request)
    {
        $user = $request->user();

        $sale_orders = SaleOrder::with('sales')->with('driver')->with('driver.user')
            ->with('sales.retailer')->with('sales.retailer.user')
            ->where("sale_orders.user_id", $user->id)
            ->orderBy('sale_orders.created_at', 'desc')
            ->get();
        return response()->json([
            'status' => true,
            'data' => $sale_orders,
        ]);
    }
    function getDriverCurrentSchedule2(Request $request)
    {
        $user = User::find(29);
        if ($driver = Driver::where('user_id', $user->id)->first()) {
            if ($sale_order = SaleOrder::with('user')->with('sales')->with('sales.retailer')
            ->with('sales.retailer.user')->where(["sale_orders.driver_id" => $driver->id])
                ->where("sale_orders.status", "<>", "cancelled")
                ->where("sale_orders.status", "<>", "delivered")
                ->where("sale_orders.status", "<>", "cancelled by retailer")
                ->where("sale_orders.status", "<>",  "Rejected By Driver")
                ->where("sale_orders.status", "<>", "pending")
                ->first()
            ) {
                return response()->json([
                    'status' => true,
                    'data' => $sale_order,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "No pending sale order",
                ], 204);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Driver not found",
            ], 404);
        }
    }
    function getDriverCurrentSchedule(Request $request)
    {
        $user = $request->user();
        if ($driver = Driver::where('user_id', $user->id)->first()) {
            if ($sale_order = SaleOrder::with('user')->with('sales')->with('sales.retailer')
                ->with('sales.retailer.user')->where(["sale_orders.driver_id" => $driver->id])
                ->where("sale_orders.status", "<>", "cancelled")
                ->where("sale_orders.status", "<>", "delivered")
                ->where("sale_orders.status", "<>", "cancelled by retailer")
                ->where("sale_orders.status", "<>",  "Rejected By Driver")
                ->where("sale_orders.status", "<>", "pending")
                ->first()
            ) {
                return response()->json([
                    'status' => true,
                    'data' => $sale_order,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "No pending sale order",
                ], 204);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Driver not found",
            ], 404);
        }
    }

    function validatePickupCode(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'qr_code' => 'required|string',
        ]);
        $notif = new \App\Http\Controllers\NotificationsController();
        //validate driver
        try {
            $code = $this->decryptIt($request->qr_code);
            $codes = explode("|", $code);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "QR Code is not supported",
            ], 400);
        }

        //confirm driver exists
        if ($driver = Driver::where("user_id", $user->id)->first()) {
            if ($codes[0] == "pickup_code") {
                $sale_id = (int)$codes[1];
                $driver_id = (int)$codes[2];
                if ($driver->id != $driver_id) {
                    return response()->json([
                        'status' => false,
                        'message' => "Could not validate driver",
                    ], 400);
                }
                if ($sale = Sale::with('retailer')->with('retailer.user')->join("sale_orders", "sale_orders.id", "=", "sales.order_id")
                    ->select("sales.*")
                    ->where("sales.id", $sale_id)->where("sale_orders.driver_id", $driver_id)
                    ->where("sales.status", "pending")->first()
                ) {
                    $sale->status = "Picked Up";
                    $sale->save();



                    $sale_order = SaleOrder::with('sales')->where("id", $sale->order_id)->first();
                    $pickup_count = Sale::where('order_id', $sale->order_id)->where('status', "Picked Up")->get()->count();
                    if ($pickup_count == count($sale_order->sales)) {
                        $sale_order->status = "Enroute To Customer";
                        $sale_order->save();
                        $notif->setNotification(new \App\Models\Notification([
                            "user_id" => $sale_order->user_id,
                            "title" => "Order #" . $sale_order->order_number . ". Driver is now enroute to you",
                            "content" => "Your package, " . $sale->product_name . ", has just been picked up from " . $sale->business_name . " by the driver and is on its way to you. You can track the move from the order page",
                            "type" => "Sale Order",
                            "source_id" => $sale_order->id,
                            "has_read" => false,
                            "trash" => false
                        ]));
                    } else {
                        $notif->setNotification(new \App\Models\Notification([
                            "user_id" => $sale_order->user_id,
                            "title" => "Order #" . $sale_order->order_number . " Item Pickup Confirmed",
                            "content" => "Your package, " . $sale->product_name . ", has just been picked up from " . $sale->business_name . " by the driver. You can track the movement from the order page",
                            "type" => "Sale Order",
                            "source_id" => $sale_order->id,
                            "has_read" => false,
                            "trash" => false
                        ]));
                    }
                    $this->updateDeliveryPickup($sale_order->id);
                    $this->updateSaleDeliveryStatus($sale->id, "Package Pickup", $sale->product_name . "was picked up by the driver");


                    $notif->setNotification(new \App\Models\Notification([
                        "user_id" => $sale->retailer->user->id,
                        "title" => "Order #" . $sale_order->order_number . " Item Pickup Confirmed",
                        "content" => "The package, " . $sale->product_name . ", has just been picked up from your store by the delivery driver. You can track the movement from the order page",
                        "type" => "Retailer Sale",
                        "source_id" => $sale_order->id,
                        "has_read" => false,
                        "trash" => false
                    ]));

                    return response()->json([
                        'status' => true,
                        "message" => "Pickup Confirmed",
                        "data" => $sale

                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "Pickup code could not be validated or item has already been scanned",
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "No a valid pickup code",
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Driver not found",
            ], 404);
        }
    }
    function generatePickupQRCode(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'sale_id' => 'required|numeric',
        ]);
        //validate retailer
        if ($sale = Sale::with("sale_order")->with('retailer')->with('retailer.user')
            ->leftJoin('retailers', 'retailers.id', '=', 'sales.retailer_id')
            ->leftJoin('users', 'users.retailer_id', '=', 'retailers.id')
            ->where('sales.id', $request->sale_id)->where("users.id", $user->id)->first()
        ) {
            $code = "pickup_code|" . $request->sale_id . "|" . $sale->sale_order->driver_id;
            return response()->json([
                'status' => true,
                'data' => $this->encryptIt($code),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Could not generate QRcode for this order",
            ], 404);
        }
    }

    function generateRetailerCustomerQRCode(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'sale_id' => 'required|numeric',
        ]);
        //validate retailer
        if ($sale = Sale::with("sale_order")->with('retailer')->with('retailer.user')
            ->leftJoin('retailers', 'retailers.id', '=', 'sales.retailer_id')
            ->leftJoin('users', 'users.retailer_id', '=', 'retailers.id')
            ->where('sales.id', $request->sale_id)->where("users.id", $user->id)->first()
        ) {
            $code = "retailer_pickup_code|" . $request->sale_id . "|" . $sale->sale_order->user_id;
            return response()->json([
                'status' => true,
                'data' => $this->encryptIt($code),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Could not generate QRcode for this order",
            ], 404);
        }
    }
    function validateRetailerCustomerPickupCode(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'qr_code' => 'required|string',
        ]);
        $notif = new \App\Http\Controllers\NotificationsController();
        //validate driver
        try {
            $code = $this->decryptIt($request->qr_code);
            $codes = explode("|", $code);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "QR Code is not supported",
            ], 400);
        }

        //confirm driver exists
        if ($codes[0] == "retailer_pickup_code") {
            $sale_id = (int)$codes[1];
            $user_id = (int)$codes[2];
            if ($user->id != $user_id) {
                return response()->json([
                    'status' => false,
                    'message' => "Could not validate customer",
                ], 400);
            }
            if ($sale = Sale::with('retailer')->with('retailer.user')->join("sale_orders", "sale_orders.id", "=", "sales.order_id")
                ->select("sales.*")
                ->where("sales.id", $sale_id)->where("sale_orders.user_id", $user->id)
                ->where("sales.status", "pending")->first()
            ) {
                $sale->status = "Delivered";
                $sale->save();



                $sale_order = SaleOrder::with('sales')->where("id", $sale->order_id)->first();
                $delivery_count = Sale::where('order_id', $sale->order_id)->where('status', "Delivered")->get()->count();

                $this->updateDeliveryPickup($sale_order->id);

                if ($delivery_count == count($sale_order->sales)) {
                    $sale_order->status = "Delivered";
                    $sale_order->save();
                    $this->updateDeliveryDropoff($sale_order->id);
                }
                $notif->setNotification(new \App\Models\Notification([
                    "user_id" => $sale_order->user_id,
                    "title" => "Order #" . $sale_order->order_number . ". Picked up by you",
                    "content" => "Your package, " . $sale->product_name . ", has just been picked up from " . $sale->business_name . " by you. Thank you for using Dash Shop",
                    "type" => "Sale Order",
                    "source_id" => $sale_order->id,
                    "has_read" => false,
                    "trash" => false
                ]));
                $this->updateSaleDeliveryStatus($sale->id, "Package Pickup By Customer", $sale->product_name . "was picked up from the retailer by the customer");


                $notif->setNotification(new \App\Models\Notification([
                    "user_id" => $sale->retailer->user->id,
                    "title" => "Order #" . $sale_order->order_number . " Item Pickup Confirmed",
                    "content" => "The package, " . $sale->product_name . ", has just been picked up from your store by the delivery driver. You can track the movement from the order page",
                    "type" => "Retailer Sale Pickup",
                    "source_id" => $sale_order->id,
                    "has_read" => false,
                    "trash" => false
                ]));

                return response()->json([
                    'status' => true,
                    "message" => "Pickup/Delivery Confirmed",
                    "data" => $sale

                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Pickup code could not be validated or item has already been scanned",
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Not a valid pickup code",
            ], 400);
        }
    }

    function validateDriverDeliveryCode(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'qr_code' => 'required|string',
        ]);
        $notif = new \App\Http\Controllers\NotificationsController();

        try {
            $code = $this->decryptIt($request->qr_code);
            //echo $code;die();
            $codes = explode("|", $code);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "QR Code is not supported",
            ], 400);
        }

        if ($codes[0] == "delivery_code") {
            $sale_id = (int)$codes[1];
            $driver_id = (int)$codes[2];

            if ($sale = Sale::with("retailer")->with("retailer.user")->join("sale_orders", "sale_orders.id", "=", "sales.order_id")
                ->join("users", "users.id", "=", "sale_orders.user_id")
                ->select('sales.*')->where("sale_orders.driver_id", $driver_id)
                ->where("sale_orders.user_id", $user->id)->where('sales.id', $sale_id)
                ->where('sales.status', 'picked up')
                ->first()
            ) {
                $driver = Driver::where('id', $driver_id)->first();
                if ($sale_order = SaleOrder::with("sales")->where("id", $sale->order_id)->first()) {
                    $sale->status = "Delivered";
                    $sale->save();
                    $picked_count = Sale::where(["order_id" => $sale_order->id, "status" => "picked up"])->get()->count();
                    if ($picked_count == 0) {
                        $sale_order->status = "Delivered";
                        $sale_order->save();
                        $this->updateDeliveryDropoff($sale_order->id);
                    }

                    $notif->setNotification(new \App\Models\Notification([
                        "user_id" => $sale_order->user_id,
                        "title" => "Order #" . $sale_order->order_number . ". has been delivered",
                        "content" => "Your package, " . $sale->product_name . ", has just been delivered to you from" . $sale->business_name . " by the driver. Thank you for using Dash Shop",
                        "type" => "Sale Order",
                        "source_id" => $sale_order->id,
                        "has_read" => false,
                        "trash" => false
                    ]));

                    $notif->setNotification(new \App\Models\Notification([
                        "user_id" => $sale->retailer->user->id,
                        "title" => "Order #" . $sale_order->order_number . ". has been delivered",
                        "content" => "Package, " . $sale->product_name . ", has just been delivered to the customer by the driver. Thank you for using Dash Shop",
                        "type" => "Retail Delivery",
                        "source_id" => $sale_order->id,
                        "has_read" => false,
                        "trash" => false
                    ]));

                    $notif->setDriverNotification(new \App\Models\DriverNotification([
                        "user_id" => $driver->user_id,
                        "title" => "Order #" . $sale_order->order_number . ". has been delivered",
                        "content" => "Package" . $sale->product_name . " from " . $sale->business_name . " has just been confirmed delivered by you. Thank you for using Dash Shop",
                        "type" => "Sale Order Delivered",
                        "source_id" => $sale_order->id,
                        "has_read" => false,
                        "trash" => false
                    ]));

                    $this->updateSaleDeliveryStatus($sale_id, "Delivered", "Package " . $sale->product_name . " was delivered to the customer");
                    return response()->json([
                        'status' => true,
                        'message' => "Delivery Confirm",
                        "data" => $sale
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "Could not validate order or item has already been delivery",
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Could not validate delivery code",
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Invalid delivery code",
            ], 400);
        }
    }

    function generateDriverDeliveryQRCode(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'sale_id' => 'required|numeric',
        ]);
        //validate driver
        if ($driver = Driver::where('user_id', $user->id)->first()) {
            if ($sale = Sale::with("sale_order")->with('sale_order.user')
                ->leftJoin('sale_orders', 'sale_orders.id', '=', 'sales.order_id')
                ->select("sales.*")
                ->where(['sale_orders.driver_id' => $driver->id, "sales.id" => $request->sale_id, "sales.status" => "picked up"])->first()
            ) {
                $code = "delivery_code|" . $request->sale_id . "|" . $driver->id;
                return response()->json([
                    'status' => true,
                    'data' => $this->encryptIt($code),
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Could not generate QRcode for this item delivery",
                ], 404);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Driver not found",
            ], 404);
        }
    }
}
