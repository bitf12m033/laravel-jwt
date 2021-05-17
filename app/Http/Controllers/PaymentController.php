<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

        $payment = Payment::create([
            'card_number' => $request->get('card_number'),
            'card_holder' => $request->get('card_holder'),
            'expiry' => $request->get('expiry'),
            'cvc' => $request->get('cvc'),
            'amount' => $request->get('amount'),
            'user_id' => $request->get('user_id'),
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
