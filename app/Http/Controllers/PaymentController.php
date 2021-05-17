<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;

use Carbon\Carbon;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|string|max:255',
            'card_holder' => 'required|string',
            'expiry' => 'required|string|after:tomorrow|date_format:m/y',
            'cvc' => 'required|numeric|digits:3',
            'amount' => 'required|integer|numeric|min:0',
            'user_id' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response($validator->errors()->toJson(),422);
        }
        // dd(Carbon::createFromFormat('m/Y', $request->get('expiry'))->format('y'));
        // dd(Carbon::parse($request->get('expiry')));
        // $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new \Stripe\StripeClient("sk_test_51Hj1kEHRx3JYEuNl1pkemrm5zNLA5TzMBj6lIiMzrZSU6bV5XJpXzHDaunnU8hWZoOkA4QHrXPrmXDQvWXCeIziy00vfANyJUM");
        // dd($stripe);
        try
        {
            $token = $stripe->tokens->create([
                'card' => [
                'number' => $request->get('card_number'),
                'exp_month' =>Carbon::createFromFormat('m/Y', $request->get('expiry'))->format('m'),
                'exp_year' => Carbon::createFromFormat('m/Y', $request->get('expiry'))->format('y'),
                'cvc' => $request->get('cvc'),
                ],
            ]);
                // dd($token["id"]);
            if (!isset($token['id'])) {
                return response('Token not created',422);
            }
            $charge = $stripe->charges->create([
                'card' => $token['id'],
                'currency' => 'USD',
                'amount' => $request->get('amount'),
                'description' => 'wallet',
            ]);
            
            $payment = Payment::create([
                'card_number' => $request->get('card_number'),
                'card_holder' => $request->get('card_holder'),
                'expiry' => $request->get('expiry'),
                'cvc' => $request->get('cvc'),
                'amount' => $request->get('amount'),
                'user_id' => $request->get('user_id'),
                'charge_id' => $charge->id,
            ]);
           if($payment)
           {
               $response = array('message'=>'Transaction completed');
           }
           else{
            $response = array('message'=>'Transaction Failed');
           }
           
            return response()->json(compact('payment','response'),201);
        }
        catch (Exception $e) {
        }
        
       
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
