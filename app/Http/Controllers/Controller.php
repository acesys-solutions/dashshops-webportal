<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\CouponClicks;
use App\Models\CouponDownloads;
use App\Models\Delivery;
use App\Models\CouponRedeemed;
use App\Models\DriversPayout;
use App\Models\RetailersPayout;
use App\Models\Sale;
use App\Models\SaleDeliveryStatus;
use App\Models\SaleOrder;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function getTotalDownloads()
    {
        if (\Auth::user()->admin == 1) {
            return CouponDownloads::sum('Downloads');
        } else {
            return CouponDownloads::leftJoin('coupons', 'coupons_download.coupon_id', '=', 'coupons.id')->leftJoin('retailers', 'coupons.retailer_id', '=', 'retailers.id')->where('retailers.created_by', \Auth::user()->id)->sum('Downloads');
        }
    }
    function getTotalClicks()
    {
        if (\Auth::user()->admin == 1) {
            return CouponClicks::sum('clicks');
        } else {
            return CouponClicks::leftJoin('coupons', 'coupons_clicks.coupon_id', '=', 'coupons.id')->leftJoin('retailers', 'coupons.retailer_id', '=', 'retailers.id')->where('retailers.created_by', \Auth::user()->id)->sum('clicks');
        }
    }
    function getTotalRedemptions()
    {
        if (\Auth::user()->admin == 1) {
            return CouponRedeemed::count();
        } else {
            return CouponRedeemed::leftJoin('coupons', 'coupon_redemption.coupon_id', '=', 'coupons.id')->leftJoin('retailers', 'coupons.retailer_id', '=', 'retailers.id')->where('retailers.created_by', \Auth::user()->id)->count();
        }
    }
    function getSelectDBRawProducts()
    {
        $str = 'products.*, 
        (select min(product_variation.price) where product_variation.product_id = products.id) as min_price,
        (select max(product_variation.price) where product_variation.product_id = products.id) as max_price, 
        (select count(id) from product_variation where product_id=products.id) as total_variants,
        (select sum(quantity) from product_variation where product_id=products.id) as total_quantity,
        (select min(product_variation.sale_price) where product_variation.product_id = products.id) as min_sale_price,
        (select max(product_variation.sale_price) where product_variation.product_id = products.id) as max_sale_price, 
        (select max(product_variation.on_sale) where product_variation.product_id = products.id and product_variation.status = 1) as product_is_on_sale, 
        (select id from product_favorites where product_favorites.product_variation_id=product_variation.id and product_favorites.user_id=" . $userid . " limit 0,1) as favorite, 
        retailers.business_name,retailers.banner_image,retailers.business_address, retailers.city, retailers.state, retailers.phone_number, retailers.email,retailers.business_description,
        retailers.longitude,retailers.latitude, retailers.from_mobile, retailers.from_mobile, categories.name as category_name';
        return DB::raw($str);
    }

    function getSelectDBRawCartDisplay()
    {
        $str = 'products.*,product_variation.id as product_variation_id, product_variation.price,product_variation.sale_price,product_variation.on_sale,product_variation.quantity as product_quantity,product_variation.low_stock_value, product_variation.status,product_variation.variant_type_values,
        (select min(product_variation.price) where product_variation.product_id = products.id) as min_price,
        (select max(product_variation.price) where product_variation.product_id = products.id) as max_price, 
        (select min(product_variation.sale_price) where product_variation.product_id = products.id) as min_sale_price,
        (select max(product_variation.sale_price) where product_variation.product_id = products.id) as max_sale_price, 
        (select max(product_variation.on_sale) where product_variation.product_id = products.id and product_variation.status = 1) as product_is_on_sale, 
        (select id from product_favorites where product_favorites.product_variation_id=product_variation.id and product_favorites.user_id=" . $userid . " limit 0,1) as favorite, 
        retailers.business_name,retailers.banner_image,retailers.business_address, retailers.city, retailers.state, retailers.phone_number, retailers.email,retailers.business_description,
        retailers.longitude,retailers.latitude, retailers.from_mobile, retailers.from_mobile, categories.name as category_name';
        return $str;
    }

    function uniqueArray($array, $property)
    {
        $tempArray = array_unique(array_column($array, $property));
        $onePropertyUniqueArrayOfObjects = array_values(array_intersect_key($array, $tempArray));
        return $onePropertyUniqueArrayOfObjects;
    }


    function getSelectDBRawCart()
    {
        $str = 'cart.*,
        products.product_name, products.id as product_id, products.image,product_variation.status,
        product_variation.quantity as stock_value, product_variation.low_stock_value, product_variation.sale_price,product_variation.price,
        product_variation.variant_types,product_variation.variant_type_values,product_variation.on_sale,
        retailers.business_name,retailers.banner_image,retailers.business_address, retailers.city, retailers.state, retailers.phone_number, retailers.email,retailers.business_description,
        retailers.longitude,retailers.latitude, retailers.from_mobile, retailers.from_mobile, categories.name as category_name';
        return DB::raw($str);
    }
    function strright($str)
    {
        $strpos = strpos($str, "|");

        if ($strpos === false) {
            return $str;
        } else {
            return substr($str, $strpos + 1);
        }
    }
    function getCurrentDirection($previousCoordinates, $currentCoordinates)
    {
        $diffLat = $currentCoordinates["lat"] - $previousCoordinates["lat"];
        $diffLng = $currentCoordinates["lng"] - $previousCoordinates["lng"];
        $anticlockwiseAngleFromEast = $this->convertToDegrees(
            atan2($diffLat, $diffLng)
        );
        $clockwiseAngleFromNorth = 90 - $anticlockwiseAngleFromEast;
        return $clockwiseAngleFromNorth;
        // helper function

    }
    function convertToDegrees($radian)
    {
        return ($radian * 180) / pi();
    }
    function getProductDetail($productVariationIds)
    {
        $products = DB::table('product_variation')
            ->join('products', 'products.id', '=', 'product_variation.product_id')
            ->join('retailers', 'retailers.id', '=', 'products.store_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select(DB::raw($this->getSelectDBRawCartDisplay()))
            ->where('products.status', '=', 1)
            ->where('product_variation.status', '=', 1);

        $products = $products->whereNested(function ($q) use ($productVariationIds) {
            foreach ($productVariationIds as $id) {
                $q = $q->orWhere("product_variation.id", $id);
            }
        });
        $products = $products->groupBy(
            "product_variation.id"
        );
        $products = $products->orderBy("products.product_name");
        $products = $products->get();

        return $products;
    }
    public function encryptIt($q, $cryptKey = 'rTYpoeiJJHGwyQdsjfsdkjfshdjPoueTGEHkdha')
    {

        // Remove the base64 encoding from our key
        //$encryption_key = base64_decode($key);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($q, 'aes-256-cbc', $cryptKey, 0, $iv);
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
    }

    public function decryptIt($q, $cryptKey = 'rTYpoeiJJHGwyQdsjfsdkjfshdjPoueTGEHkdha')
    {

        // Remove the base64 encoding from our key
        //$encryption_key = base64_decode($key);
        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = explode('::', base64_decode($q), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $cryptKey, 0, $iv);
    }
    function updateDeliveryPickup($order_id)
    {
        if ($delivery = Delivery::where("sales_id", $order_id)->first()) {
            // check if delivery has been picked up
            if (!$delivery->picked_at) {
                $delivery->status = 'Picked';
                $delivery->picked_at = now();
                $delivery->save();
            }
        }
    }
    function updateDeliveryDropoff($order_id)
    {
        if ($delivery = Delivery::where("sales_id", $order_id)->first()) {
            $delivery->status = 'Delivered';
            $delivery->delivered_at = now();
            $delivery->save();
            if ($sales = Sale::where('order_id', "$order_id")->where('status', 'delivered')->get()) {
                foreach ($sales as $sale) {
                    RetailersPayout::create([
                        'sale_id' => $sale->id,
                        'retailer_id' => $sale->retailer_id,
                        'amount' => $sale->quantity * $sale->unit_cost,
                        'status' => "Pending"
                    ]);
                }
            }
            if ($sale_order = SaleOrder::find($order_id)) {
                DriversPayout::create([
                    'sale_id' => $order_id,
                    'driver_id' => $sale_order->driver_id,
                    'amount' => $sale_order->delivery_fee,
                    'status' => "Pending",
                ]);
            }
        }
    }
    function updateSaleDeliveryStatus($sale_id, $status, $message = "")
    {
        SaleDeliveryStatus::create([
            'sale_id' => $sale_id,
            'status' => $status,
            'message' => $message
        ]);
    }
}
