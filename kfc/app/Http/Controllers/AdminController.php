<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Check if user is authenticated, redirect to login if not
     */
    private function checkAuthentication()
    {
        if (!$this->apiService->isAuthenticated()) {
            return redirect()->route('login')->with('error', 'Please login to access admin panel');
        }
        return null;
    }

    public function dashboard()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $stats = $this->apiService->getStats();
        $statsData = $stats->successful() ? $stats->json() : [
            'locations' => 0,
            'categories' => 0,
            'menu_items' => 0,
            'customers' => 0,
            'orders' => 0
        ];

        return view('admin.dashboard', compact('statsData'));
    }

    // ==================== LOCATIONS ====================
    public function locations()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $response = $this->apiService->getLocations();
        $locations = $response->successful() ? $response->json() : [];

        return view('admin.locations.index', compact('locations'));
    }

    public function createLocation()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        return view('admin.locations.create');
    }

    public function storeLocation(Request $request)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'opening_hours' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Map form fields to API fields
        $data = [
            'store_name' => $request->store_name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'phone' => $request->phone,
            'opening_hours' => $request->opening_hours,
        ];

        $response = $this->apiService->createLocation($data);

        if ($response->successful()) {
            return redirect()->route('admin.locations')->with('success', 'Location created successfully!');
        }

        return back()->withErrors(['error' => 'Failed to create location'])->withInput();
    }

    public function editLocation($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $response = $this->apiService->getLocation($id);
        
        if (!$response->successful()) {
            return redirect()->route('admin.locations')->with('error', 'Location not found');
        }

        $location = $response->json();
        return view('admin.locations.edit', compact('location'));
    }

    public function updateLocation(Request $request, $id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'opening_hours' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Map form fields to API fields
        $data = [
            'store_name' => $request->store_name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'phone' => $request->phone,
            'opening_hours' => $request->opening_hours,
        ];

        $response = $this->apiService->updateLocation($id, $data);

        if ($response->successful()) {
            return redirect()->route('admin.locations')->with('success', 'Location updated successfully!');
        }

        return back()->withErrors(['error' => 'Failed to update location'])->withInput();
    }

    public function deleteLocation($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $response = $this->apiService->deleteLocation($id);

        if ($response->successful()) {
            return redirect()->route('admin.locations')->with('success', 'Location deleted successfully!');
        }

        return redirect()->route('admin.locations')->with('error', 'Failed to delete location');
    }

    // ==================== CATEGORIES ====================
    public function categories()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $response = $this->apiService->getCategories();
        $categories = $response->successful() ? $response->json() : [];

        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Map form fields to API fields
        $data = [
            'category_name' => $request->category_name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ? (int)$request->sort_order : 0,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/categories', $imageName);
            $data['image_url'] = '/storage/categories/' . $imageName;
        }

        $response = $this->apiService->createCategory($data);

        if ($response->successful()) {
            return redirect()->route('admin.categories')->with('success', 'Category created successfully!');
        }

        return back()->withErrors(['error' => 'Failed to create category'])->withInput();
    }

    public function editCategory($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $response = $this->apiService->getCategory($id);
        
        if (!$response->successful()) {
            return redirect()->route('admin.categories')->with('error', 'Category not found');
        }

        $category = $response->json();
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Map form fields to API fields
        $data = [
            'category_name' => $request->category_name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ? (int)$request->sort_order : 0,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/categories', $imageName);
            $data['image_url'] = '/storage/categories/' . $imageName;
        }

        $response = $this->apiService->updateCategory($id, $data);

        if ($response->successful()) {
            return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
        }

        return back()->withErrors(['error' => 'Failed to update category'])->withInput();
    }

    public function deleteCategory($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $response = $this->apiService->deleteCategory($id);

        if ($response->successful()) {
            return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
        }

        return redirect()->route('admin.categories')->with('error', 'Failed to delete category');
    }

    // ==================== MENU ITEMS ====================
    public function menuItems(Request $request)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $categoryId = $request->get('category_id');
        
        $itemsResponse = $this->apiService->getMenuItems(0, 100, $categoryId);
        $menuItems = $itemsResponse->successful() ? $itemsResponse->json() : [];

        $categoriesResponse = $this->apiService->getCategories();
        $categories = $categoriesResponse->successful() ? $categoriesResponse->json() : [];

        return view('admin.menu-items.index', compact('menuItems', 'categories', 'categoryId'));
    }

    public function createMenuItem()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $response = $this->apiService->getCategories();
        $categories = $response->successful() ? $response->json() : [];

        return view('admin.menu-items.create', compact('categories'));
    }

    public function storeMenuItem(Request $request)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        \Log::info('Store MenuItem called', [
            'has_file' => $request->hasFile('image'),
            'all_data' => $request->all()
        ]);
        
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed', ['errors' => $validator->errors()]);
            return back()->withErrors($validator)->withInput();
        }

        // Map form fields to API fields
        $data = [
            'item_name' => $request->item_name,
            'description' => $request->description,
            'price' => (float)$request->price,
            'category_id' => (int)$request->category_id,
            'is_available' => $request->has('is_available'),
            'featured' => $request->has('is_featured'),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $storedPath = $image->storeAs('public/menu-items', $imageName);
            $data['image_url'] = '/storage/menu-items/' . $imageName;
            
            \Log::info('Menu Item Image uploaded successfully', [
                'original_name' => $image->getClientOriginalName(),
                'stored_name' => $imageName,
                'stored_path' => $storedPath,
                'image_url' => $data['image_url'],
                'file_size' => $image->getSize()
            ]);
        } else {
            \Log::info('No image file uploaded for menu item');
        }

        $response = $this->apiService->createMenuItem($data);

        if ($response->successful()) {
            return redirect()->route('admin.menu-items')->with('success', 'Menu item created successfully!');
        }

        return back()->withErrors(['error' => 'Failed to create menu item'])->withInput();
    }

    public function editMenuItem($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $itemResponse = $this->apiService->getMenuItem($id);
        
        if (!$itemResponse->successful()) {
            return redirect()->route('admin.menu-items')->with('error', 'Menu item not found');
        }

        $menuItem = $itemResponse->json();
        
        $categoriesResponse = $this->apiService->getCategories();
        $categories = $categoriesResponse->successful() ? $categoriesResponse->json() : [];

        return view('admin.menu-items.edit', compact('menuItem', 'categories'));
    }

    public function updateMenuItem(Request $request, $id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Map form fields to API fields
        $data = [
            'item_name' => $request->item_name,
            'description' => $request->description,
            'price' => (float)$request->price,
            'category_id' => (int)$request->category_id,
            'is_available' => $request->has('is_available'),
            'featured' => $request->has('is_featured'),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/menu-items', $imageName);
            $data['image_url'] = '/storage/menu-items/' . $imageName;
        }

        $response = $this->apiService->updateMenuItem($id, $data);

        if ($response->successful()) {
            return redirect()->route('admin.menu-items')->with('success', 'Menu item updated successfully!');
        }

        return back()->withErrors(['error' => 'Failed to update menu item'])->withInput();
    }

    public function deleteMenuItem($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $response = $this->apiService->deleteMenuItem($id);

        if ($response->successful()) {
            return redirect()->route('admin.menu-items')->with('success', 'Menu item deleted successfully!');
        }

        return redirect()->route('admin.menu-items')->with('error', 'Failed to delete menu item');
    }

    // ==================== ORDERS ====================
    public function orders()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $response = $this->apiService->getAllOrders();
        $orders = $response->successful() ? $response->json() : [];

        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        $orderResponse = $this->apiService->getOrder($id);
        
        if (!$orderResponse->successful()) {
            return redirect()->route('admin.orders')->with('error', 'Order not found');
        }

        $order = $orderResponse->json();
        
        $itemsResponse = $this->apiService->getOrderItems($id);
        $orderItems = $itemsResponse->successful() ? $itemsResponse->json() : [];

        return view('admin.orders.show', compact('order', 'orderItems'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $response = $this->apiService->updateOrder($id, ['status' => $request->status]);

        if ($response->successful()) {
            return back()->with('success', 'Order status updated successfully!');
        }

        return back()->with('error', 'Failed to update order status');
    }
} 