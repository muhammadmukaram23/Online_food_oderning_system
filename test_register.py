import requests
import json

# Test customer registration
def test_register():
    url = "http://localhost:8000/auth/register"
    
    customer_data = {
        "first_name": "John",
        "last_name": "Doe", 
        "email": "john.doe.test@example.com",
        "phone": "1234567890",
        "password": "securepassword123",
        "gender": "Male"  # This should now work with the fixed enum
    }
    
    try:
        response = requests.post(url, json=customer_data)
        print(f"Status Code: {response.status_code}")
        print(f"Response: {response.json()}")
        
        if response.status_code == 200:
            print("✅ Registration successful!")
            return True
        else:
            print("❌ Registration failed!")
            return False
            
    except requests.exceptions.ConnectionError:
        print("❌ Could not connect to server. Make sure it's running on http://localhost:8000")
        return False
    except Exception as e:
        print(f"❌ Error: {e}")
        return False

if __name__ == "__main__":
    print("🧪 Testing Customer Registration...")
    test_register() 