<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class HomeController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        // Get featured items
        $featuredItems = [];
        try {
            $featuredResponse = $this->apiService->getFeaturedItems(6);
            if ($featuredResponse->successful()) {
                $featuredItems = $featuredResponse->json();
            }
        } catch (\Exception $e) {
            \Log::error('Failed to fetch featured items: ' . $e->getMessage());
        }

        // Get categories
        $categories = [];
        try {
            $categoriesResponse = $this->apiService->getCategories(0, 10);
            if ($categoriesResponse->successful()) {
                $categories = $categoriesResponse->json();
            }
        } catch (\Exception $e) {
            \Log::error('Failed to fetch categories: ' . $e->getMessage());
        }

        // Get locations
        $locations = [];
        try {
            $locationsResponse = $this->apiService->getLocations(0, 5);
            if ($locationsResponse->successful()) {
                $locations = $locationsResponse->json();
            }
        } catch (\Exception $e) {
            \Log::error('Failed to fetch locations: ' . $e->getMessage());
        }

        return view('home', compact('featuredItems', 'categories', 'locations'));
    }

    public function menu(Request $request)
    {
        $categoryId = $request->get('category');
        
        // Get menu items
        $menuItems = [];
        try {
            $itemsResponse = $this->apiService->getMenuItems(0, 100, $categoryId);
            if ($itemsResponse->successful()) {
                $menuItems = $itemsResponse->json();
            }
        } catch (\Exception $e) {
            \Log::error('Failed to fetch menu items: ' . $e->getMessage());
        }

        // Get categories for filter
        $categories = [];
        try {
            $categoriesResponse = $this->apiService->getCategories();
            if ($categoriesResponse->successful()) {
                $categories = $categoriesResponse->json();
            }
        } catch (\Exception $e) {
            \Log::error('Failed to fetch categories: ' . $e->getMessage());
        }

        return view('menu', compact('menuItems', 'categories', 'categoryId'));
    }

    public function locations()
    {
        $locations = [];
        try {
            $response = $this->apiService->getLocations();
            if ($response->successful()) {
                $locations = $response->json();
            }
        } catch (\Exception $e) {
            \Log::error('Failed to fetch locations: ' . $e->getMessage());
        }

        return view('locations', compact('locations'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
} 