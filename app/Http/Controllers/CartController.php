<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Rating;
use App\Models\CouponClicks;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;


class CartController extends Controller
{

    function delete(Request $request, $id)
    {
        $user = $request->user();
        if (Cart::where(["product_variation_id" => $id, "user_id" => $user->id])->exists()) {
            $cart = Cart::where(["product_variation_id" => $id, "user_id" => $user->id])->first();
            $cart->delete();
            return response()->json(
                [
                    'status' => true,
                    'message' => "Item removed from cart"
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => true,
                    'message' => "Cart item not found"
                ],
                404
            );
        }
    }
    function deleteUserCart(Request $request)
    {
        $user = $request->user();
        Cart::whereIn("user_id", [$user->id])->delete();

        return response()->json(
            [
                'status' => true,
                'message' => "User Cart Removed"
            ],
            200
        );
    }

    function syncFromApp(Request $request)
    {
        $user = $request->user();
        $products = json_decode($request->products_variant_ids, true);
        foreach ($products as $product) {
            if ($pv = ProductVariant::find($product["product_variation_id"])) {
                if (Cart::where(["product_variation_id" => $product["product_variation_id"], "user_id" => $user->id])->exists()) {
                    $cart = Cart::where(["product_variation_id" => $product["product_variation_id"], "user_id" => $user->id])->first();
                    if ((int)$product["quantity"] != 0) {

                        if ((int)$product["quantity"] < $pv->quantity) {
                            $cart->quantity =  (int)$product["quantity"];
                            $cart->save();
                        } else {
                            if ($pv->quantity == 0) {
                                $cart->delete();
                            } else {
                                $cart->quantity =  $pv->quantity;
                                $cart->save();
                            }
                        }
                    }
                } else {
                    if ((int)$product["quantity"] < $pv->quantity) {
                        Cart::create([
                            "user_id" => $user->id,
                            "product_variation_id" => $product["product_variation_id"],
                            "quantity" => (int)$product["quantity"],
                        ]);
                    }else if($pv->quantity > 0){
                        Cart::create([
                            "user_id" => $user->id,
                            "product_variation_id" => $product["product_variation_id"],
                            "quantity" => $pv->quantity,
                        ]);
                    }
                }
            }
        }
        return response()->json(
            [
                'status' => true,
                'message' => "Items Synced to Cart Successfully"
            ],
            200
        );
    }

    function getProductDetails(Request $request)
    {
        $products_variant_ids = json_decode($request->products_variant_ids, true);
        //$products_variant_ids = json_decode("[1,2,4]", true);
        $products = $this->getProductDetail($products_variant_ids);
        return response()->json(
            [
                'status' => true,
                "data" => $products
            ],
            200
        );
    }


    function update(Request $request, $id)
    {
        $user = $request->user();
        if (Cart::where(["product_variation_id" => $id, "user_id" => $user->id])->exists()) {
            $cart = Cart::where(["product_variation_id" => $id, "user_id" => $user->id])->first();
            if ($pv = ProductVariant::find($id)) {
                if ((int)$request->quantity < $pv->quantity) {
                    $cart->quantity = $request->quantity;
                    $cart->update();
                    return response()->json(
                        [
                            'status' => true,
                            'message' => "Cart Item Updated"
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => "Quantity exceeds retailer's inventory"
                        ],
                        400
                    );
                }
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => "Product is no longer available"
                    ],
                    404
                );
            }
        } else {
            return response()->json(
                [
                    'status' => true,
                    'message' => "Cart item not found"
                ],
                404
            );
        }
    }

    function getUserCart(Request $request)
    {
        $user = $request->user();
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
            ->orderBy("products.product_name")
            ->get();

        return response()->json([
            "data" => $products
        ], 200);
    }

    function add(Request $request)
    {
        $user = $request->user();
        $products = json_decode($request->products_variant_ids, true);

        foreach ($products as $product) {
            if (Cart::where(["product_variation_id" => $product["product_variation_id"], "user_id" => $user->id])->exists()) {
                $cart = Cart::where(["product_variation_id" => $product["product_variation_id"], "user_id" => $user->id])->first();
                $cart->quantity = $cart->quantity + (int)$product["quantity"];
                $cart->save();
            } else {
                Cart::create([
                    "user_id" => $user->id,
                    "product_variation_id" => $product["product_variation_id"],
                    "quantity" => (int)$product["quantity"],
                ]);
            }
        }
        return response()->json(
            [
                'status' => true,
                'message' => "Items Added to Cart Successfully"
            ],
            200
        );
    }
}
