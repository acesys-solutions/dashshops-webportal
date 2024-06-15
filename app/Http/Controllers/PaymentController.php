<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Rating;
use App\Models\CouponClicks;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{
    function makeCardDefault($id,Request $request){
        $user = $request->user();
        if($card = PaymentDetail::where(['id'=>$id,'user_id'=>$user->id])->first()){
            PaymentDetail::whereIn('user_id', [$user->id])->update(['is_default' => 0]);
            $card->is_default = 1;
            $card->save();
            return response()->json([
                'status' => true,
                'message' => 'Payment card is now the default'
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Payment card not found'
            ], 404);
        }
    }

    function addPaymentCard(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'last4' => 'required|string',
            'card_type' =>
            'required|string',
            'exp_month' => 'required|string',
            'exp_year' => 'required|string',
            'cvv' => 'required|string|max:3|min:3',
            'is_default' => 'required'
        ]);

        $user = $request->user();
        $isDefualt = 0;
        if ($request->id != 0) {
            $card = PaymentDetail::find($request->id);
        } else {
            $card = new PaymentDetail();
            if(PaymentDetail::where('user_id',$user->id)->count() == 0){
                $isDefualt = 1;
            }
        }

        $card->token = $request->token;
        $card->user_id = $user->id;
        $card->last4 = $request->last4;
        $card->card_type = $request->card_type;
        $card->exp_month = $request->exp_month;
        $card->exp_year = $request->exp_year;
        $card->cvv = $request->cvv;
        $card->fullname = $request->fullname;
        $card->email = $request->email;
        $card->phone = $request->phone;
        $card->is_default = $isDefualt;

        $card->save();

        return response()->json([
            'status' => true,
            'data' => $card,
            'message' => 'Card saved successfully'
        ], 200);
    }
    function listCards(Request $request)
    {
        $user = $request->user();
        $cards = PaymentDetail::where('user_id', $user->id);
        $cards = $cards->orderBy('is_default', 'desc')->get();
        return response()->json([
            'status' => true,
            'data' => $cards
        ], 200);
    }
    function getDefaultCard(Request $request){
        $user = $request->user();
        if($card = PaymentDetail::where(['user_id'=>$user->id, 'is_default'=>1])->first()){
            return response()->json([
                'status' => true,
                'data' => $card
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => "Payment card available"
            ], 201);
        }
    }
    function removeCard($id, Request $request)
    {
        $user = $request->user();

        if ($card = PaymentDetail::where(['user_id' => $user->id, 'id' => $id])->first()) {
            if($card->is_default == 1){
                return response()->json([
                    'status' => false,
                    'message' => 'Cannot delete default card.'
                ], 400);
            }
            $card->delete();
            return response()->json([
                'status' => true,
                'message' => 'Card Deleted'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Card was not found'
            ], 404);
        }
    }
}
