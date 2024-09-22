<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\FlutterwaveSetting;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\PaystackSetting;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function index()
    {
        //check if address is in session

        if(!Session::has('shipping_address')){
            return redirect()->route('checkout');
        }
        return view('frontend.payment');
    }

    /** Flutterwave payment */
    public function initialize(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required']
        ]);

        $flutterwave = FlutterwaveSetting::first();
         //This generates a payment reference
         $reference = Flutterwave::generateReference();

         //Get amount
         $amount = Cart::subtotalFloat() + getShippingFee();

         // Enter the details of the payment
         $data = [
             'payment_options' => 'card,banktransfer,ussd',
             'amount' => $amount * $flutterwave->rate,
             'email' => $request->email,
             'tx_ref' => $reference,
             'currency' => $flutterwave->currency,
             'redirect_url' => route('flutterwave-callback'),
             'customer' => [
                 'email' => $request->email,
                 "phone_number" => $request->phone,
                 "name" => $request->name
             ],
 
             "customizations" => [
                 "title" => 'Orders',
                 "description" => "Payment for orders on ".date('jS F, Y')
             ]
         ];

         
         $payment = Flutterwave::initializePayment($data);
         
         
         if ($payment['status'] !== 'success') {
             return back()->with('error', $payment['message']);
         }
 
         return redirect($payment['data']['link']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {
        
        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {
        
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            $this->createOrder('flutterwave', $transactionID);
            $this->clearSession();

            return redirect()->route('payment')->with('success', 'Order Successful.');

        }
        elseif ($status ==  'cancelled'){
            return redirect()->route('payment')->with('warning', 'Transaction cancelled by user.');
        }
        else{
            return redirect()->route('payment')->with('error', 'Transaction failed. Try again later.');
        }

    }

     /** Paystack payment */
     public function redirectToGateway(Request $request)
     {
        $paystack = PaystackSetting::first();
        $request->validate([
            'paystack_email' => ['required', 'email'],
        ]);
        //This generates a payment reference
        $reference = Paystack::genTranxRef();

        //Get amount
        $amount = Cart::subtotalFloat() + getShippingFee();

        // Enter the details of the payment
        $data = [
            'amount' => $amount * $paystack->rate * 100 ,
            'email' => $request->paystack_email,
            'reference' => $reference,
            'currency' => ($paystack != null) ? $paystack->currency : 'NGN',
            'description' => "Payment for orders on ".date('jS F, Y'),
            'orderID' => rand(10000, 99999)
        ];
 
        try{
            return Paystack::getAuthorizationUrl($data)->redirectNow();
        }catch(\Exception $e) {
            return back()->with('error', 'There is an error in making payment. Please refresh the page and try again.');
        }   
     }
 
    /**
      * Obtain Paystack callback information
      * @return void
    */
    public function handleGatewayCallback()
    {
    $data = Paystack::getPaymentData();
    
    if($data['status'] == true){
        $details = $data['data'];
        //if payment is successful
        if ($details['status'] ==  'success') {
            $transactionID = $details['reference'];
            $this->createOrder('paystack', $transactionID);
            $this->clearSession();
            return redirect()->route('payment')->with('success', 'Order Successful.');
        }
    }
    else{
        return redirect()->route('payment')->with('error', 'Transaction failed. Try again later.');

    }


    }

    /** Create order */
    public function createOrder($paymentMethod, $ref) {
        $settings = GeneralSetting::first();
        $fee = Session::get('shipping_method');
        $total = Cart::subtotalFloat() + $fee['cost'];
        if($paymentMethod == "paystack") {
            $payment = PaystackSetting::first();
        }
        if($paymentMethod == "flutterwave") {
            $payment = FlutterwaveSetting::first();
        }
        $order = Order::create([
            'invoice_id' => rand(1,999999),
            'user_id' => auth()->user()->id,
            'sub_total' => Cart::priceTotalFloat(), 
            'amount' => $total,
            'currency' => $settings->currency, 
            'currency_icon' => $settings->currency_icon,
            'qty' => Cart::content()->count(), 
            'payment_method' => $paymentMethod, 
            'payment_status' => 'completed',
            'coupon' =>  json_encode(Session::get('coupon')),
            'shipping_method' => json_encode(Session::get('shipping_method')), 
            'shipping_address' => json_encode(Session::get('shipping_address')), 
        ]);

        //store order items
        if($order){
            foreach (Cart::content() as  $item) {
                $product = Product::find($item->id);
                $order->items()->create([
                    'product_id' => $item->id, 
                    'vendor_id' => $product->vendor_id, 
                    'product_name' => $item->name,
                    'unit_price' => $item->price, 
                    'quantity' => $item->qty,
                    'variants' => json_encode($item->options->variants), 
                ]);
            }

            //store transaction
            $transaction = $order->transaction()->create([
                'transaction_id' => $ref,
                'payment_method' => $paymentMethod, 
                'amount' => $total,
                'amount_real_currency' => $total * $payment->rate, 
                'amount_real_currency_name' => $payment->currency
            ]);
            

        }
    }

    /**clear sessions */
    public function clearSession()
    {
        Cart::destroy();
        Session::forget('shipping_method');
        Session::forget('shipping_addressx');
        if(Session::has('coupon')){
            $coupon = Coupon::find(Session::get('coupon')['coupon_id']);
            $coupon->total_used += 1;
            $coupon->quantity -= 1;
            $coupon->save();
            Session::forget('coupon');
        }
    }
}
