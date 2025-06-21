<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function showLogin()
    {
        if ($this->apiService->isAuthenticated()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.login');
    }

    public function showRegister()
    {
        if ($this->apiService->isAuthenticated()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $response = $this->apiService->login([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        }

        // Handle API error response
        $errorMessage = $this->extractErrorMessage($response);
        
        return back()->withErrors(['email' => $errorMessage])->withInput();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $response = $this->apiService->register([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
        ]);

        if ($response->successful()) {
            // Auto login after registration
            $loginResponse = $this->apiService->login([
                'email' => $request->email,
                'password' => $request->password
            ]);

            if ($loginResponse->successful()) {
                return redirect()->route('admin.dashboard')->with('success', 'Registration successful!');
            }
            
            return redirect()->route('login')->with('success', 'Registration successful! Please login.');
        }

        // Handle API error response
        $errorMessage = $this->extractErrorMessage($response);
        
        return back()->withErrors(['email' => $errorMessage])->withInput();
    }

    public function logout()
    {
        $this->apiService->logout();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }

    /**
     * Extract error message from API response
     */
    private function extractErrorMessage($response)
    {
        try {
            $error = $response->json();
            
            // Log the error for debugging
            Log::error('API Error Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'json' => $error
            ]);
            
            // Handle different error response formats
            if (is_array($error)) {
                if (isset($error['detail'])) {
                    return is_string($error['detail']) ? $error['detail'] : 'API Error occurred';
                }
                if (isset($error['message'])) {
                    return is_string($error['message']) ? $error['message'] : 'API Error occurred';
                }
                // If it's an array but no specific error field, return generic message
                return 'An error occurred. Please try again.';
            }
            
            // If it's a string, return it directly
            if (is_string($error)) {
                return $error;
            }
            
            // Fallback for any other case
            return 'An unexpected error occurred. Please try again.';
            
        } catch (\Exception $e) {
            Log::error('Error extracting error message', [
                'exception' => $e->getMessage(),
                'response_body' => $response->body()
            ]);
            
            return 'An error occurred. Please try again.';
        }
    }
} 