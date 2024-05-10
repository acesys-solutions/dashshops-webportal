<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\DriverSetting;
use App\Models\CouponClicks;
use App\Models\CouponDownloads;
use App\Models\CouponRedeemed;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;



class DriverSettingsController extends Controller
{
    public function getDriverSetting()
    {
        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $app_setting = DriverSetting::where('user_id', Auth::id())->first();
            if (!$app_setting) {
                $app_setting = new DriverSetting();
                $app_setting->user_id = Auth::id();
                $app_setting->save();
            }
            return response()->json([
                "message" => "Driver Settings successfully Retrieved",
                "data" => $app_setting
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }
    public function saveSettings(Request $request)
    {
        if ($driver = Driver::where('user_id', Auth::id())->first()) {
            $app_setting = DriverSetting::where('user_id', Auth::id())->first();
            if (!$app_setting) {
                $app_setting = new DriverSetting();
                $app_setting->user_id = Auth::id();
            }
            $app_setting->push_notification = is_null($request->push_notification) ? $app_setting->push_notification : $request->push_notification;
            $app_setting->disable_caching = is_null($request->disable_caching) ? $app_setting->disable_caching : $request->disable_caching;
            $app_setting->location = is_null($request->location) ? $app_setting->location : $request->location;
            $app_setting->save();
            return response()->json([
                "message" => "Driver Settings successfully Saved",
                "data" => $app_setting
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Driver not found'
        ], 404);
    }
}
