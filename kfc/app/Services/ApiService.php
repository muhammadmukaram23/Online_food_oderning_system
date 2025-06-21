<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ApiService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.api_base_url', 'http://localhost:8000');
    }

    // Authentication Methods
    public function register($userData)
    {
        try {
            $response = Http::timeout(10)->post($this->baseUrl . '/auth/register', $userData);
            
            // Log the response for debugging
            Log::info('Register API Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return $response;
        } catch (\Exception $e) {
            Log::error('API Register Error: ' . $e->getMessage());
            return $this->mockResponse(false, ['detail' => 'Connection error: Unable to connect to API server']);
        }
    }

    public function login($credentials)
    {
        try {
            $response = Http::timeout(10)->post($this->baseUrl . '/auth/login', $credentials);
            
            // Log the response for debugging
            Log::info('Login API Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['access_token'])) {
                    Session::put('api_token', $data['access_token']);
                    Session::put('token_type', $data['token_type'] ?? 'bearer');
                }
            }
            
            return $response;
        } catch (\Exception $e) {
            Log::error('API Login Error: ' . $e->getMessage());
            return $this->mockResponse(false, ['detail' => 'Connection error: Unable to connect to API server']);
        }
    }

    public function logout()
    {
        Session::forget(['api_token', 'token_type']);
    }

    public function getCurrentCustomer()
    {
        return $this->makeAuthenticatedRequest('GET', '/auth/me');
    }

    // Location Methods
    public function getLocations($skip = 0, $limit = 100)
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/locations', [
                'skip' => $skip,
                'limit' => $limit
            ]);
        } catch (\Exception $e) {
            Log::error('API Get Locations Error: ' . $e->getMessage());
            return $this->mockResponse(true, []);
        }
    }

    public function getLocation($locationId)
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/locations/' . $locationId);
        } catch (\Exception $e) {
            Log::error('API Get Location Error: ' . $e->getMessage());
            return $this->mockResponse(false, ['detail' => 'Connection error']);
        }
    }

    public function createLocation($locationData)
    {
        return $this->makeAuthenticatedRequest('POST', '/locations', $locationData);
    }

    public function updateLocation($locationId, $locationData)
    {
        return $this->makeAuthenticatedRequest('PUT', '/locations/' . $locationId, $locationData);
    }

    public function deleteLocation($locationId)
    {
        return $this->makeAuthenticatedRequest('DELETE', '/locations/' . $locationId);
    }

    // Menu Category Methods
    public function getCategories($skip = 0, $limit = 100)
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/menu/categories', [
                'skip' => $skip,
                'limit' => $limit
            ]);
        } catch (\Exception $e) {
            Log::error('API Get Categories Error: ' . $e->getMessage());
            return $this->mockResponse(true, []);
        }
    }

    public function getCategory($categoryId)
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/menu/categories/' . $categoryId);
        } catch (\Exception $e) {
            Log::error('API Get Category Error: ' . $e->getMessage());
            return $this->mockResponse(false, ['detail' => 'Connection error']);
        }
    }

    public function createCategory($categoryData)
    {
        return $this->makeAuthenticatedRequest('POST', '/menu/categories', $categoryData);
    }

    public function updateCategory($categoryId, $categoryData)
    {
        return $this->makeAuthenticatedRequest('PUT', '/menu/categories/' . $categoryId, $categoryData);
    }

    public function deleteCategory($categoryId)
    {
        return $this->makeAuthenticatedRequest('DELETE', '/menu/categories/' . $categoryId);
    }

    // Menu Item Methods
    public function getMenuItems($skip = 0, $limit = 100, $categoryId = null)
    {
        try {
            $params = ['skip' => $skip, 'limit' => $limit];
            if ($categoryId) {
                $params['category_id'] = $categoryId;
            }
            
            return Http::timeout(10)->get($this->baseUrl . '/menu/items', $params);
        } catch (\Exception $e) {
            Log::error('API Get Menu Items Error: ' . $e->getMessage());
            return $this->mockResponse(true, []);
        }
    }

    public function getFeaturedItems($limit = 10)
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/menu/items/featured', ['limit' => $limit]);
        } catch (\Exception $e) {
            Log::error('API Get Featured Items Error: ' . $e->getMessage());
            return $this->mockResponse(true, []);
        }
    }

    public function getMenuItem($itemId)
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/menu/items/' . $itemId);
        } catch (\Exception $e) {
            Log::error('API Get Menu Item Error: ' . $e->getMessage());
            return $this->mockResponse(false, ['detail' => 'Connection error']);
        }
    }

    public function createMenuItem($itemData)
    {
        return $this->makeAuthenticatedRequest('POST', '/menu/items', $itemData);
    }

    public function updateMenuItem($itemId, $itemData)
    {
        return $this->makeAuthenticatedRequest('PUT', '/menu/items/' . $itemId, $itemData);
    }

    public function deleteMenuItem($itemId)
    {
        return $this->makeAuthenticatedRequest('DELETE', '/menu/items/' . $itemId);
    }

    // Order Methods
    public function createOrder($orderData)
    {
        return $this->makeAuthenticatedRequest('POST', '/orders', $orderData);
    }

    public function getCustomerOrders($skip = 0, $limit = 100)
    {
        return $this->makeAuthenticatedRequest('GET', '/orders', [
            'skip' => $skip,
            'limit' => $limit
        ]);
    }

    public function getAllOrders($skip = 0, $limit = 100)
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/orders/all', [
                'skip' => $skip,
                'limit' => $limit
            ]);
        } catch (\Exception $e) {
            Log::error('API Get All Orders Error: ' . $e->getMessage());
            return $this->mockResponse(true, []);
        }
    }

    public function getOrder($orderId)
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/orders/' . $orderId);
        } catch (\Exception $e) {
            Log::error('API Get Order Error: ' . $e->getMessage());
            return $this->mockResponse(false, ['detail' => 'Connection error']);
        }
    }

    public function updateOrder($orderId, $orderData)
    {
        return $this->makeAuthenticatedRequest('PUT', '/orders/' . $orderId, $orderData);
    }

    public function addOrderItem($orderId, $itemData)
    {
        return $this->makeAuthenticatedRequest('POST', '/orders/' . $orderId . '/items', $itemData);
    }

    public function getOrderItems($orderId)
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/orders/' . $orderId . '/items');
        } catch (\Exception $e) {
            Log::error('API Get Order Items Error: ' . $e->getMessage());
            return $this->mockResponse(true, []);
        }
    }

    public function removeOrderItem($orderItemId)
    {
        return $this->makeAuthenticatedRequest('DELETE', '/orders/items/' . $orderItemId);
    }

    public function calculateOrderTotal($orderId)
    {
        return $this->makeAuthenticatedRequest('POST', '/orders/' . $orderId . '/calculate-total');
    }

    // Statistics
    public function getStats()
    {
        try {
            return Http::timeout(10)->get($this->baseUrl . '/stats');
        } catch (\Exception $e) {
            Log::error('API Get Stats Error: ' . $e->getMessage());
            return $this->mockResponse(true, [
                'locations' => 0,
                'categories' => 0,
                'menu_items' => 0,
                'customers' => 0,
                'orders' => 0
            ]);
        }
    }

    public function healthCheck()
    {
        try {
            return Http::timeout(5)->get($this->baseUrl . '/health');
        } catch (\Exception $e) {
            Log::error('API Health Check Error: ' . $e->getMessage());
            return $this->mockResponse(false, ['status' => 'unhealthy', 'error' => $e->getMessage()]);
        }
    }

    // Helper method for authenticated requests
    private function makeAuthenticatedRequest($method, $endpoint, $data = [])
    {
        try {
            $token = Session::get('api_token');
            
            if (!$token) {
                return $this->mockResponse(false, ['detail' => 'No authentication token found']);
            }

            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];

            switch (strtoupper($method)) {
                case 'GET':
                    return Http::timeout(10)->withHeaders($headers)->get($this->baseUrl . $endpoint, $data);
                case 'POST':
                    return Http::timeout(10)->withHeaders($headers)->post($this->baseUrl . $endpoint, $data);
                case 'PUT':
                    return Http::timeout(10)->withHeaders($headers)->put($this->baseUrl . $endpoint, $data);
                case 'DELETE':
                    return Http::timeout(10)->withHeaders($headers)->delete($this->baseUrl . $endpoint);
                default:
                    throw new \Exception('Unsupported HTTP method');
            }
        } catch (\Exception $e) {
            Log::error('API Authenticated Request Error: ' . $e->getMessage());
            return $this->mockResponse(false, ['detail' => 'Connection error']);
        }
    }

    // Helper method to create mock responses when API is down
    private function mockResponse($success, $data)
    {
        return new class($success, $data) {
            private $success;
            private $data;
            
            public function __construct($success, $data)
            {
                $this->success = $success;
                $this->data = $data;
            }
            
            public function successful()
            {
                return $this->success;
            }
            
            public function json()
            {
                // Ensure we always return an array for consistent error handling
                if (is_string($this->data)) {
                    return ['detail' => $this->data];
                }
                return $this->data;
            }
            
            public function status()
            {
                return $this->success ? 200 : 500;
            }
        };
    }

    public function isAuthenticated()
    {
        return Session::has('api_token');
    }

    public function getToken()
    {
        return Session::get('api_token');
    }
} 