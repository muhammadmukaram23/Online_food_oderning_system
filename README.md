# KFC Restaurant Management API

A comprehensive FastAPI application for managing KFC restaurant operations including menu management, order processing, customer management, and location administration.

## Features

- **Authentication**: JWT-based customer authentication
- **Menu Management**: Categories and menu items with full CRUD operations
- **Order Management**: Complete order processing system with items
- **Location Management**: Restaurant branch management
- **Customer Management**: Customer registration and profile management
- **Database Integration**: MySQL database with SQLAlchemy ORM

## Technology Stack

- **FastAPI**: Modern, fast web framework for building APIs
- **SQLAlchemy**: SQL toolkit and ORM
- **MySQL**: Database system
- **Pydantic**: Data validation using Python type annotations
- **JWT**: JSON Web Tokens for authentication
- **Uvicorn**: ASGI server

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd kfc-restaurant-api
   ```

2. **Create virtual environment**
   ```bash
   python -m venv venv
   source venv/bin/activate  # On Windows: venv\Scripts\activate
   ```

3. **Install dependencies**
   ```bash
   pip install -r requirements.txt
   ```

4. **Set up MySQL database**
   - Install MySQL server
   - Create database: `CREATE DATABASE kfc_restaurant;`
   - Run the provided `database.sql` script to create tables and sample data

5. **Configure environment variables**
   Create a `.env` file in the root directory:
   ```env
   MYSQL_USER=root
   MYSQL_PASSWORD=your_password_here
   MYSQL_HOST=localhost
   MYSQL_PORT=3306
   MYSQL_DATABASE=kfc_restaurant
   SECRET_KEY=your-secret-key-here
   ```

6. **Run the application**
   ```bash
   python main.py
   ```
   Or using uvicorn directly:
   ```bash
   uvicorn main:app --reload --host 0.0.0.0 --port 8000
   ```
create the .env file 
 MYSQL_USER=root
   MYSQL_PASSWORD=
   MYSQL_HOST=localhost
   MYSQL_PORT=3306
   MYSQL_DATABASE=kfc_restaurant
   SECRET_KEY="23345fffrr47klopsss"
## API Documentation

Once the application is running, you can access:

- **Interactive API Docs (Swagger UI)**: http://localhost:8000/docs
- **Alternative API Docs (ReDoc)**: http://localhost:8000/redoc
- **API Root**: http://localhost:8000/

## API Endpoints

### Authentication
- `POST /auth/register` - Register new customer
- `POST /auth/login` - Customer login
- `GET /auth/me` - Get current customer info

### Locations
- `GET /locations` - Get all locations
- `POST /locations` - Create new location
- `GET /locations/{id}` - Get specific location
- `PUT /locations/{id}` - Update location
- `DELETE /locations/{id}` - Delete location

### Menu
- `GET /menu/categories` - Get all categories
- `POST /menu/categories` - Create new category
- `GET /menu/items` - Get all menu items
- `POST /menu/items` - Create new menu item
- `GET /menu/items/featured` - Get featured items

### Orders
- `POST /orders` - Create new order
- `GET /orders` - Get customer orders
- `POST /orders/{id}/items` - Add item to order
- `GET /orders/{id}/items` - Get order items

### Utility
- `GET /health` - Health check
- `GET /stats` - Get basic statistics

## Database Schema

The application uses the provided `database.sql` schema which includes:

- **locations**: Restaurant branches
- **categories**: Menu categories
- **menu_items**: Food items with details
- **customers**: Customer information
- **orders**: Order management
- **order_items**: Items within orders
- **payments**: Payment processing
- **reviews**: Customer reviews
- **inventory**: Stock management
- **loyalty_transactions**: Loyalty points system

## Usage Examples

### Register a Customer
```bash
curl -X POST "http://localhost:8000/auth/register" \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@example.com",
    "phone": "1234567890",
    "password": "securepassword"
  }'
```

### Login
```bash
curl -X POST "http://localhost:8000/auth/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "securepassword"
  }'
```

### Get Menu Items
```bash
curl -X GET "http://localhost:8000/menu/items"
```

### Create Order (requires authentication)
```bash
curl -X POST "http://localhost:8000/orders" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "location_id": 1,
    "order_type": "Dine-in"
  }'
```

## Development

### Project Structure
```
├── main.py              # FastAPI application entry point
├── database.py          # Database configuration
├── models.py            # SQLAlchemy models
├── schemas.py           # Pydantic schemas
├── crud.py              # Database operations
├── auth.py              # Authentication utilities
├── routes/              # API route modules
│   ├── __init__.py
│   ├── auth.py          # Authentication routes
│   ├── locations.py     # Location management
│   ├── menu.py          # Menu management
│   └── orders.py        # Order management
├── requirements.txt     # Python dependencies
├── database.sql         # Database schema
└── README.md           # This file
```

### Adding New Features

1. **Add Models**: Define new SQLAlchemy models in `models.py`
2. **Add Schemas**: Create Pydantic schemas in `schemas.py`
3. **Add CRUD**: Implement database operations in `crud.py`
4. **Add Routes**: Create new route files in `routes/` directory
5. **Update Main**: Include new routers in `main.py`

## Security Considerations

- Change the `SECRET_KEY` in production
- Use environment variables for sensitive data
- Implement proper input validation
- Add rate limiting for production use
- Use HTTPS in production
- Implement proper error handling

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## License

This project is licensed under the MIT License. 