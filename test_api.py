import requests
import json

# Base URL for the API
BASE_URL = "http://localhost:8000"

def test_health_check():
    """Test the health check endpoint"""
    response = requests.get(f"{BASE_URL}/health")
    print("Health Check:", response.json())
    return response.status_code == 200

def test_root_endpoint():
    """Test the root endpoint"""
    response = requests.get(f"{BASE_URL}/")
    print("Root Endpoint:", response.json())
    return response.status_code == 200

def test_register_customer():
    """Test customer registration"""
    customer_data = {
        "first_name": "John",
        "last_name": "Doe",
        "email": "john.doe@example.com",
        "phone": "1234567890",
        "password": "securepassword123"
    }
    
    response = requests.post(f"{BASE_URL}/auth/register", json=customer_data)
    print("Customer Registration:", response.status_code)
    if response.status_code == 200:
        print("Customer created:", response.json())
    else:
        print("Registration error:", response.text)
    return response.status_code == 200

def test_login_customer():
    """Test customer login"""
    login_data = {
        "email": "john.doe@example.com",
        "password": "securepassword123"
    }
    
    response = requests.post(f"{BASE_URL}/auth/login", json=login_data)
    print("Customer Login:", response.status_code)
    if response.status_code == 200:
        token_data = response.json()
        print("Login successful, token received")
        return token_data["access_token"]
    else:
        print("Login error:", response.text)
    return None

def test_create_location():
    """Test creating a location"""
    location_data = {
        "store_name": "KFC Downtown",
        "address": "123 Main Street",
        "city": "New York",
        "state": "NY",
        "zip_code": "10001",
        "phone": "555-0123",
        "email": "downtown@kfc.com",
        "manager_name": "Alice Johnson"
    }
    
    response = requests.post(f"{BASE_URL}/locations", json=location_data)
    print("Location Creation:", response.status_code)
    if response.status_code == 200:
        print("Location created:", response.json())
        return response.json()["location_id"]
    else:
        print("Location creation error:", response.text)
    return None

def test_create_category():
    """Test creating a menu category"""
    category_data = {
        "category_name": "Chicken",
        "description": "Delicious chicken items",
        "sort_order": 1
    }
    
    response = requests.post(f"{BASE_URL}/menu/categories", json=category_data)
    print("Category Creation:", response.status_code)
    if response.status_code == 200:
        print("Category created:", response.json())
        return response.json()["category_id"]
    else:
        print("Category creation error:", response.text)
    return None

def test_create_menu_item(category_id):
    """Test creating a menu item"""
    menu_item_data = {
        "category_id": category_id,
        "item_name": "Original Recipe Chicken",
        "description": "Our famous original recipe chicken",
        "price": 12.99,
        "calories": 320,
        "preparation_time": 15,
        "is_available": True,
        "featured": True
    }
    
    response = requests.post(f"{BASE_URL}/menu/items", json=menu_item_data)
    print("Menu Item Creation:", response.status_code)
    if response.status_code == 200:
        print("Menu item created:", response.json())
        return response.json()["item_id"]
    else:
        print("Menu item creation error:", response.text)
    return None

def test_get_menu_items():
    """Test getting menu items"""
    response = requests.get(f"{BASE_URL}/menu/items")
    print("Get Menu Items:", response.status_code)
    if response.status_code == 200:
        items = response.json()
        print(f"Found {len(items)} menu items")
        return items
    else:
        print("Get menu items error:", response.text)
    return []

def test_create_order(token, location_id):
    """Test creating an order"""
    headers = {"Authorization": f"Bearer {token}"}
    order_data = {
        "location_id": location_id,
        "order_type": "Dine-in"
    }
    
    response = requests.post(f"{BASE_URL}/orders", json=order_data, headers=headers)
    print("Order Creation:", response.status_code)
    if response.status_code == 200:
        print("Order created:", response.json())
        return response.json()["order_id"]
    else:
        print("Order creation error:", response.text)
    return None

def test_add_order_item(order_id, item_id):
    """Test adding an item to an order"""
    order_item_data = {
        "item_id": item_id,
        "quantity": 2,
        "special_instructions": "Extra crispy please"
    }
    
    response = requests.post(f"{BASE_URL}/orders/{order_id}/items", json=order_item_data)
    print("Add Order Item:", response.status_code)
    if response.status_code == 200:
        print("Order item added:", response.json())
        return True
    else:
        print("Add order item error:", response.text)
    return False

def run_all_tests():
    """Run all API tests"""
    print("=== KFC Restaurant API Tests ===\n")
    
    # Test basic endpoints
    print("1. Testing basic endpoints...")
    test_root_endpoint()
    test_health_check()
    print()
    
    # Test authentication
    print("2. Testing authentication...")
    test_register_customer()
    token = test_login_customer()
    print()
    
    # Test location management
    print("3. Testing location management...")
    location_id = test_create_location()
    print()
    
    # Test menu management
    print("4. Testing menu management...")
    category_id = test_create_category()
    item_id = None
    if category_id:
        item_id = test_create_menu_item(category_id)
    test_get_menu_items()
    print()
    
    # Test order management
    if token and location_id and item_id:
        print("5. Testing order management...")
        order_id = test_create_order(token, location_id)
        if order_id:
            test_add_order_item(order_id, item_id)
        print()
    
    print("=== Tests Complete ===")

if __name__ == "__main__":
    try:
        run_all_tests()
    except requests.exceptions.ConnectionError:
        print("Error: Could not connect to the API server.")
        print("Make sure the server is running on http://localhost:8000")
    except Exception as e:
        print(f"Error running tests: {e}") 