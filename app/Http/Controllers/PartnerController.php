<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        // $customer = new Customer();
        // $customer->first_name = $first_name;
        // $customer->last_name = $last_name;
        // $customer->email = $email;
        // $customer->pet_points = $pet_points;
        // $customer->uuid = $uuid;
        // $customer->save();
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


        // If all requests succeed, send a success response
        return response()->json([
            'success' => true,
            'message' => 'Uploaded successfully',
        ], 200);
    }

    public function checkCustomerPetPoints($id, $amount)
    {
        $customer = Customer::where('id', $id)->first();
        if ($customer) {
            $pet_point = $customer['pet_point'];
            if ($pet_point >= $amount) {
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
                    'token'=>$accessToken,
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
        $customer->pet_points = $pet_points;
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

    public function editCustomer(Request $request,$id){
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $pet_points = $request->pet_points;
        $uuid = $request->uuid;
        $customer = Customer::where('id',$id)->first();
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
        }else{
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
                'error'=>$response
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save user pet points.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
