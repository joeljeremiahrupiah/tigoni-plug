<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProductPaymentController extends Controller
{
    protected $pesapalToken;

    public function setAuthToken()
    {
        $authResponse = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->post(env('PESAPAL_BASE_URL') . "api/Auth/RequestToken", [
                'consumer_key' => env('PESAPAL_CONSUMER_KEY'),
                'consumer_secret' => env('PESAPAL_CONSUMER_SECRET')
            ]);

        $this->pesapalToken = $authResponse['token'];
    }

    public function getOrderResponse($payment_ref, $amount, $callbackUrl, $cancellationUrl, $request, $authuser)
    {
        $this->setAuthToken();

        $orderResponse = Http::withToken($this->pesapalToken)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->post(env('PESAPAL_BASE_URL') . '/api/Transactions/SubmitOrderRequest', [
                'id' => $payment_ref,
                'currency' => 'KES',
                'amount' => $amount,
                'description' => 'Payment to Quanta Insure',
                'callback_url' => env('APP_URL') . $callbackUrl,
                'cancellation_url' => $cancellationUrl,
                'notification_id' => env('PESAPAL_IPN_ID'),
                'billing_address' => [
                    'first_name' => $authuser->fullname,
                    'last_name' => $authuser->fullname,
                    'email_address' => $authuser->email,
                    'phone_number' => str_replace(' ',  '', str_replace('+254', '0', $authuser->phoneOne)),
                    'country_code' => 'KE',
                ]
            ]);

        return json_decode($orderResponse, true);
    }

    public function getTransactionStatus($request)
    {
        $orderTrackingId = $request->OrderTrackingId;

        $this->setAuthToken();

        $callbackResponse = Http::withToken($this->pesapalToken)->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->get(env('PESAPAL_BASE_URL') . 'api/Transactions/GetTransactionStatus', [
                'orderTrackingId' => $orderTrackingId,
            ]);

        $callbackResponse = json_decode($callbackResponse, true);

        $payment = ProductPayment::where('order_tracking_id', $orderTrackingId)->first();
        // $payment->update([
        //     'payment_method' => $callbackResponse['payment_method'],
        //     'transaction_reference' => $callbackResponse['confirmation_code'],
        //     'transaction_status' => $callbackResponse['payment_status_description'],
        //     'payment_date' => $callbackResponse['created_date'],
        // ]);

        $status = $callbackResponse['payment_status_description'] == 'Completed' ? 'success' : 'failed';

        return [
            'status' => $status,
            'payment' => $payment
        ];
    }

    public function payForProduct(Request $request, $id)
    {
        $authuser = User::findOrFail($id);
        $product = Product::findOrFail($request->product_id);

        $amount = $request->amount;

        $payment_ref = uniqid();

        $cancellationUrl = env('APP_URL') . "/admin/products?status=cancelled";

        $callbackUrl = "/admin/purchase-product-callback";

        $orderResponse = $this->getOrderResponse($payment_ref, $amount, $callbackUrl, $cancellationUrl, $request, $authuser);
        $orderTrackingId = $orderResponse['order_tracking_id'] ?? '';
        // dd($orderTrackingId);

        if ($orderTrackingId) {
            $productpayment = ProductPayment::create([
                'product_id' => $request->product_id,
                'order_tracking_id' => $orderTrackingId
            ]);

            return response()->json($orderResponse);
        }

        return response(['status' => 200], 200);
    }

    public function purchaseProductCallback(Request $request)
    {
        $response = $this->getTransactionStatus($request);
        $status = $response['status'];
        $payment = $response['payment'];


        if ($status == 'success') {
            $product = Product::findOrFail($payment->product_id);
            $product->paid = 'yes';
            $product->save();
        }

        return redirect("/api/admin/products?status=$status");
    }
}
