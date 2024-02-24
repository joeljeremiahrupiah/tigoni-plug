<?php

namespace App\Http\Controllers;

use App\Models\PackagePayment;
use App\Models\PaymentUser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class AuthenticateController extends Controller
{
    protected $pesapalToken;

    public function home()
    {
        return view('admin.admin_master');
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'fullname' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        $admin = User::create([
            'name' => $request->fullname,
            'email' => $request->email,
            'username' => \Str::uuid(), // Generate a unique identifier using UUID
            'password' => Hash::make($request->password),
            'user_type' => 'admin', // Set user_type to 'admin'
        ]);

        // Generate a personal access token
        $token = $admin->createToken('Admin Token')->plainTextToken;

        return response()->json(['token' => $token, 'user_type' => $admin->user_type, 'user' => $admin, 'message' => 'Admin registered successfully', 'status' => 200], 200);
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $admin = Auth::user();
            // Generate a personal access token
            $token = $admin->createToken('Admin Token')->plainTextToken;

            return response()->json(['token' => $token, 'user_type' => $admin->user_type, 'user' => $admin, 'message' => 'Admin logged in successfully', 'status' => 200], 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect']
        ]);
    }


    public function registerVendor(Request $request)
    {
        $request->validate([
            'fullname' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        $admin = User::create([
            'name' => $request->fullname,
            'email' => $request->email,
            'username' => \Str::uuid(), // Generate a unique identifier using UUID
            'password' => Hash::make($request->password),
            'user_type' => 'vendor', // Set user_type to 'admin'
            'paid' => 'no'
        ]);

        // Generate a personal access token
        $token = $admin->createToken('Vendor Token')->plainTextToken;

        return response()->json(['token' => $token, 'user_type' => $admin->user_type, 'user' => $admin, 'message' => 'Vendor registered successfully', 'status' => 200], 200);
    }

    public function loginVendor(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $admin = Auth::user();
            // Generate a personal access token
            $token = $admin->createToken('Vendor Token')->plainTextToken;

            return response()->json(['token' => $token, 'user_type' => $admin->user_type, 'user' => $admin, 'message' => 'Vendor logged in successfully', 'status' => 200], 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect']
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    }

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

    public function getOrderResponse($payment_ref, $amount, $callbackUrl, $cancellationUrl, $request)
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
                    'first_name' => $request->fullname,
                    'last_name' => $request->fullname,
                    'email_address' => $request->email,
                    'phone_number' => str_replace(' ',  '', str_replace('+254', '0', $request->phoneOne)),
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

        $payment = PaymentUser::where('order_tracking_id', $orderTrackingId)->first();
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

    public function createUserDetails(Request $request)
    {

        $authuser = User::findOrFail($request->userid);

        $authuser->name = $request->fullname;
        $authuser->company_type = $request->company_type;
        $authuser->email = $request->email;
        $authuser->logo = $request->logo;
        $authuser->phoneOne = $request->phoneOne;
        $authuser->phoneTwo = $request->phoneTwo;
        $authuser->save();

        $packagepayment = PackagePayment::where('package_name', $authuser->company_type)->first();
        $amount = $packagepayment->amount;

        $payment_ref = uniqid();

        $cancellationUrl = env('APP_URL') . "/admin/vendor-login?status=cancelled";

        $callbackUrl = "/admin/purchase-subscription-callback";

        $orderResponse = $this->getOrderResponse($payment_ref, $amount, $callbackUrl, $cancellationUrl, $request);
        $orderTrackingId = $orderResponse['order_tracking_id'] ?? '';

        if ($orderTrackingId) {
            $paymentuser = PaymentUser::create([
                'user_id' => $request->userid,
                'order_tracking_id' => $orderTrackingId
            ]);

            return response()->json($orderResponse);
        }

        return response(['user' => $authuser, 'status' => 200], 200);
    }

    public function purchaseSubscriptionCallback(Request $request)
    {
        $response = $this->getTransactionStatus($request);
        $status = $response['status'];
        $payment = $response['payment'];


        if ($status == 'success') {
            $user = User::findOrFail($payment->user_id);
            $user->paid = 'yes';
            $user->save();
        }

        return redirect("/api/admin/vendor-login?status=$status");
    }
}
