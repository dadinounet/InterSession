<?php
/**
 * Created by PhpStorm.
 * User: apprenant
 * Date: 06/02/18
 * Time: 15:29
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;

class ContributionController extends Controller
{

    /*public function getAllOrders()
    {
        $orders = Order::all();
        return view('admin', compact('orders'));
    }*/


    public function postPayWithStripe(Request $request)
    {
        $input = $request->all();
        $name = $input['name'];
        $email = $input['email'];
        $srtipetoken = $input['stripetoken'];
        $amount = $input['amount'];
        $exp_month = $input['exp_month'];
        $exp_year = $input['exp_year'];
        $cvc = $input['cvc'];
        return $this->chargeCustomer($name, $email, $srtipetoken, $amount, $exp_month, $exp_year, $cvc);
    }



    public function isStripeCustomer()
    {
        $user = Auth::user();
        return $user && \App\User::where('id', $user->id)->whereNotNull('stripe_id')->first();
    }






}