<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductAddtoCartStat;
use App\Models\ProductClick;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductClicksController extends Controller
{
    //
    public function getAll()
    {
        $clicks = ProductClick::all();
        return response()->json([
            "data" => $clicks,
            "message" => "Fetch Successful"
        ]);
    }

    public function create(Request $request)
    {
        $click = new ProductClick;
        $click->product_id = $request->product_id;
        $click->clicks = $request->clicks;
        $click->state = $request->state;
        $click->city = $request->city;
        $click->save();

        return response()->json([
            "message" => "Click Added",
            "data" => $click
        ], 201);
    }

    public function getByRetailer($retailer_id)
    {
        $coupons = DB::table('product_clicks')
            ->join('products', 'products.id', '=', 'product_clicks.product_id')
            ->join('product_variation', 'product_variation.product_id', '=', 'product_clicks.product_id')
            ->join('retailers', 'retailers.id', '=', 'products.store_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select(DB::raw('product_clicks.id as analytics_id,(select created_at from product_clicks where product_id = products.id order by created_at desc limit 1) as last_date, (select count(*) from product_clicks where product_id = products.id) as click_count,'. $this->getSelectDBRawProducts2()))
            ->where('retailers.id', '=', $retailer_id)
            ->orderBy('click_count', 'desc')
            ->get();

        $allMd5s = array_map(function ($v) {

            return $v->id;
        }, $coupons->toArray());

        //will optimise this later

        $uniqueMd5s = array_unique($allMd5s);

        $result = [];
        foreach (array_intersect_key($coupons->toArray(), $uniqueMd5s) as $v) {
            array_push($result, $v);
            //$result[] = $v;
        }
        return response()->json(["data" => $result]);
    }

    public function show($id): JsonResponse
    {
        $click = ProductClick::find($id);
        if (!empty($click)) {
            return response()->json($click);
        } else {
            return response()->json([
                "message" => "Click Record not Found"
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        if (ProductClick::where('id', $id)->exists()) {
            $click = ProductClick::findorfail($id);
            $click->clicks = is_null($request->clicks) ? $click->clicks : $request->clicks;
        }
    }

    public function destroy($id): JsonResponse
    {
        if (ProductClick::where('id', $id)->exists()) {
            $click = ProductClick::find($id);
            $click->delete();


            return response()->json([
                "message" => "Click Record Deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Click Record Not Found"
            ], 404);
        }
    }

    public function getAllAddtoCartStats()
    {
        $clicks = ProductAddtoCartStat::all();
        return response()->json([
            "data" => $clicks,
            "message" => "Fetch Successful"
        ]);
    }

    public function createAddtoCartStats(Request $request)
    {
        $click = new ProductAddtoCartStat;
        $click->product_id = $request->product_id;
        $click->clicks = $request->clicks;
        $click->state = $request->state;
        $click->city = $request->city;
        $click->save();

        return response()->json([
            "message" => "Stats Added",
            "data" => $click
        ], 201);
    }

    public function getByRetailerAddtoCartStats($retailer_id)
    {
        $coupons = DB::table('product_addtocarts')
        ->join('products', 'products.id', '=', 'product_addtocarts.product_id')
        ->join('retailers', 'retailers.id', '=', 'products.store_id')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->select(DB::raw('product_addtocarts.id as analytics_id,(select created_at from product_addtocarts where product_id = products.id order by created_at desc limit 1) as last_date, (select count(*) from product_addtocarts where product_id = products.id) as click_count, products.*, retailers.business_name, retailers.banner_image, retailers.business_address, retailers.city, retailers.state, retailers.phone_number, retailers.email,retailers.business_description, categories.name as category_name'))
        ->where('retailers.id', '=', $retailer_id)
            ->orderBy('product_addtocarts.created_at', 'desc')
            ->get();

        $allMd5s = array_map(function ($v) {

            return $v->id;
        }, $coupons->toArray());

        //will optimise this later

        $uniqueMd5s = array_unique($allMd5s);

        $result = [];
        foreach (array_intersect_key($coupons->toArray(), $uniqueMd5s) as $v) {
            array_push($result, $v);
            //$result[] = $v;
        }
        return response()->json(["data" => $result]);
    }

    public function showAddtoCartStats($id): JsonResponse
    {
        $click = ProductAddtoCartStat::find($id);
        if (!empty($click)) {
            return response()->json($click);
        } else {
            return response()->json([
                "message" => "Click Record not Found"
            ], 404);
        }
    }
    public function updateAddtoCartStats(Request $request, $id)
    {
        if (ProductAddtoCartStat::where('id', $id)->exists()) {
            $click = ProductAddtoCartStat::findorfail($id);
            $click->clicks = is_null($request->clicks) ? $click->clicks : $request->clicks;
        }
    }

    public function destroyAddtoCartStats($id): JsonResponse
    {
        if (ProductAddtoCartStat::where('id', $id)->exists()) {
            $click = ProductAddtoCartStat::find($id);
            $click->delete();


            return response()->json([
                "message" => "Stats Record Deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Stats Record Not Found"
            ], 404);
        }
    }
}
