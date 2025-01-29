<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerTransactionDetails;
use App\Models\SandBoxUpload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Pest\ArchPresets\Custom;

class PartnerController extends Controller
{
    protected $pet_point_secret_key;
    protected $pet_point_secret_id;
    protected $pet_point_sandbox_url;


    public function __construct()
    {
        $this->pet_point_secret_key = config("app.pet_point_secret_key");
        $this->pet_point_secret_id = config("app.pet_point_secret_id");
        $this->pet_point_sandbox_url = config("app.pet_point_sandbox_url");
    }
    public function createCsrfToken(Request $request)
    {
        $token = csrf_token();
        return $token;
    }

    public function uploadUserPetPoints(Request $request)
    {
        // $token = csrf_token();
        // Extract headers from the request
        $petPointSecretKey = $this->pet_point_secret_key;
        $petPointSecretId = $this->pet_point_secret_id;
        $petPointSandBoxUrl = $this->pet_point_sandbox_url;

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $pet_points = $request->pet_points;
        $uuid = $request->uuid; // Assuming 'data' is sent in the request body
        $data = [
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "pet_points" => $pet_points,
            "uuid" => $uuid
        ];
        $customer= Customer::where('uuid',$uuid)->first();
        if(!$customer){
            return response()->json([
                'success' => false,
                'message' => 'No customer found',
            ], 400);
        }
        if (!$petPointSecretKey || !$petPointSecretId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required headers or data',
            ], 400);
        }

        $headers = [
            'Content-Type' => 'application/json',
            'pet_point_secret_key' => $petPointSecretKey,
            'pet_point_secret_id' => $petPointSecretId,
        ];

        try {
            // Make the POST request using Laravel's HTTP client
            $response = Http::withHeaders($headers)
                ->post("$petPointSandBoxUrl/api/petshop/uploadUserPetPoints", $data);
            // Check for a successful response
            if (!$response->successful()) {
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save user pet points.',
                    'error' => $response->body(),
                ], 500);
            }
        } catch (\Exception $exception) {
            // Handle exceptions (e.g., network issues)
            return response()->json([
                'success' => false,
                'message' => 'Failed to save user pet points.',
                'error' => $exception->getMessage(),
            ], 500);
        }
        $sandbox_upload = new SandBoxUpload();
        $sandbox_upload->first_name = $first_name;
        $sandbox_upload->last_name = $last_name;
        $sandbox_upload->email = $email;
        $sandbox_upload->pet_point = $pet_points;
        $sandbox_upload->uuid = $uuid;
        $sandbox_upload->save();

        // If all requests succeed, send a success response
        return response()->json([
            'success' => true,
            'message' => 'Uploaded successfully',
        ], 200);
    }

    public function checkCustomerPetPoints($id, $amount)
    {
        $customer = Customer::where('uuid', $id)->first();
        if ($customer) {
            $pet_point = $customer['pet_point'];
            if ($pet_point >= floatval($amount)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Able to Proceed',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to Proceed',
                ], 200);
            }
        }
    }

    public function customerUsedPetPoints(Request $request)
    {
        $data = $request->data;
        $customer_transaction_details= new CustomerTransactionDetails();
        $customer_transaction_details->first_name = $data['transaction_data']['first_name'];
        $customer_transaction_details->last_name = $data['transaction_data']['last_name'];
        $customer_transaction_details->email = $data['transaction_data']['email'];
        $customer_transaction_details->pet_point =$data['total_point_used'];
        $customer_transaction_details->uuid =  $data['transaction_data']['uuid'];
        $customer_transaction_details->save();
        $customer= Customer::where('uuid', $data['transaction_data']['uuid'])->first();
        $customer->pet_point=$customer->pet_point-$data['total_point_used'];
        $customer->save();
        return $data;
    }

    public function loginUser(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                $tokenResult = $user->createToken('pet-shop-token')->plainTextToken;
                $accessToken = $tokenResult;
                return response()->json([
                    'success' => true,
                    'token' => $accessToken,
                    'message' => 'Login successfully',
                    'data' => $user
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 200);
        }
    }

    public function getCustomer($id)
    {
        $customer = Customer::where('id', $id)->first();
        if ($customer) {
            return response()->json([
                'success' => true,
                'message' => 'data found',
                'data' => $customer

            ], 200);
        }
    }

    public function getAllCustomer()
    {
        $customer = Customer::get();
        if ($customer) {
            return response()->json([
                'success' => true,
                'message' => 'data found',
                'data' => $customer

            ], 200);
        }
    }

    public function getAllTransaction()
    {
        $customer = CustomerTransactionDetails::get();
        if ($customer) {
            return response()->json([
                'success' => true,
                'message' => 'data found',
                'data' => $customer

            ], 200);
        }
    }


    public function createCustomer(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $pet_points = $request->pet_points;
        $uuid = $request->uuid;
        $customer = new Customer();
        $customer->first_name = $first_name;
        $customer->last_name = $last_name;
        $customer->email = $email;
        $customer->pet_point = $pet_points;
        $customer->uuid = $uuid;
        $customer->save();
        if ($customer) {
            return response()->json([
                'success' => true,
                'message' => 'data found',
                'data' => $customer

            ], 200);
        }
    }

    public function editCustomer(Request $request, $id)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $pet_points = $request->pet_points;
        $uuid = $request->uuid;
        $customer = Customer::where('uuid', $id)->first();
        if ($customer) {
            $customer->first_name = $first_name;
            $customer->last_name = $last_name;
            $customer->email = $email;
            $customer->pet_point = $pet_points;
            $customer->uuid = $uuid;
            $customer->save();
            return response()->json([
                'success' => true,
                'message' => 'Updated Successfully',

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No customer found',

            ], 200);
        }
    }

    public function referralLink(Request $request, $uuid)
    {
        try {
            $petPointSecretKey = $this->pet_point_secret_key;
            $petPointSecretId = $this->pet_point_secret_id;
            $petPointSandBoxUrl = $this->pet_point_sandbox_url;
            $customer=Customer::where('uuid',$uuid)->first();
            $first_name = $customer->first_name;
            $last_name = $customer->last_name;
            $email = $customer->email;
            $pet_points = $customer->pet_point;
            // Get the server's IP address
            $serverIp = request()->ip();
            // Define headers
            $headers = [
                'Content-Type' => 'application/json',
                'pet_point_secret_key' => $petPointSecretKey,
                'pet_point_secret_id' => $petPointSecretId,
            ];

            // Define request payload
            $data = [
                'ip_address' => $serverIp,
                'uuid' => $uuid,
                'first_name'=>$first_name,
                'last_name'=>$last_name,
                'email'=>$email,
                'pet_points'=>$pet_points,

            ];

            // Send POST request
            $response = Http::withHeaders($headers)
                ->post("$petPointSandBoxUrl/api/petshop/referralLink", $data);

            // Check if the request was successful
            if ($response->successful()) {
                return redirect($response->json());
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'error' => $response
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save user pet points.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

   
//web.php
    public function storeToken(Request $request)
    {
        // Storing the token in the session
        session(['auth_token' => $request->auth_token]);

        return response()->json(['message' => 'Token stored successfully']);
    }
    public function logoutSession(Request $request)
    {
        // Storing the token in the session
        Session::forget('auth_token');
        return redirect('/');
    }

    public function transaction()
    {
        // Storing the token in the session
        // Session::forget('auth_token');
        return view('transaction');
    }

    public  function getAllUsers() {
        return view('allUsers');
    }

    public function login(){
        return view('login');
    }

    public function uploadPetPoints(){
        return view('uploadPetPoints');
    }

    public function uploadSandBox(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $pet_points = $request->pet_points;
        $uuid = $request->uuid;
        $sandbox_upload = new SandBoxUpload();
        $sandbox_upload->first_name = $first_name;
        $sandbox_upload->last_name = $last_name;
        $sandbox_upload->email = $email;
        $sandbox_upload->pet_point = $pet_points;
        $sandbox_upload->uuid = $uuid;
        $sandbox_upload->status = "Uploaded";

        $sandbox_upload->save();
        if ($sandbox_upload) {
            return response()->json([
                'success' => true,
                'message' => 'data found',
                'data' => $sandbox_upload

            ], 200);
        }
    }
    public function getUploadSandBox(){
        $sandbox_upload = SandBoxUpload::get(); 
        if ($sandbox_upload) {
            return response()->json([
                'success' => true,
                'message' => 'data found',
                'data' => $sandbox_upload

            ], 200);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'No data found'
            ], 200);
        }
    }
}
