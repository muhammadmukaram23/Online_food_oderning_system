from pydantic import BaseModel, EmailStr, Field, validator
from typing import Optional, List
from datetime import datetime, date, time
from decimal import Decimal
from enum import Enum

# Enums
class GenderEnum(str, Enum):
    Male = "Male"
    Female = "Female"
    Other = "Other"

class OrderTypeEnum(str, Enum):
    DINE_IN = "Dine-in"
    TAKEOUT = "Takeout"
    DELIVERY = "Delivery"
    DRIVE_THRU = "Drive-thru"

class OrderStatusEnum(str, Enum):
    Pending = "Pending"
    Confirmed = "Confirmed"
    Preparing = "Preparing"
    Ready = "Ready"
    Out_for_Delivery = "Out for Delivery"
    Delivered = "Delivered"
    Cancelled = "Cancelled"

class PaymentStatusEnum(str, Enum):
    Pending = "Pending"
    Paid = "Paid"
    Failed = "Failed"
    Refunded = "Refunded"

# Location Schemas
class LocationBase(BaseModel):
    store_name: str
    address: str
    city: str
    state: str
    zip_code: str
    phone: str
    email: Optional[str] = None
    manager_name: str
    opening_time: Optional[time] = time(6, 0)
    closing_time: Optional[time] = time(23, 0)
    is_active: bool = True

class LocationCreate(LocationBase):
    pass

class LocationUpdate(BaseModel):
    store_name: Optional[str] = None
    address: Optional[str] = None
    city: Optional[str] = None
    state: Optional[str] = None
    zip_code: Optional[str] = None
    phone: Optional[str] = None
    email: Optional[str] = None
    manager_name: Optional[str] = None
    opening_time: Optional[time] = None
    closing_time: Optional[time] = None
    is_active: Optional[bool] = None

class LocationResponse(LocationBase):
    location_id: int
    created_at: datetime
    updated_at: datetime

    model_config = {"from_attributes": True}

# Category Schemas
class CategoryBase(BaseModel):
    category_name: str
    description: Optional[str] = None
    image_url: Optional[str] = None
    sort_order: int = 0
    is_active: bool = True

class CategoryCreate(CategoryBase):
    pass

class CategoryUpdate(BaseModel):
    category_name: Optional[str] = None
    description: Optional[str] = None
    image_url: Optional[str] = None
    sort_order: Optional[int] = None
    is_active: Optional[bool] = None

class CategoryResponse(CategoryBase):
    category_id: int
    created_at: datetime

    model_config = {"from_attributes": True}

# Menu Item Schemas
class MenuItemBase(BaseModel):
    category_id: int
    item_name: str
    description: Optional[str] = None
    price: Decimal
    calories: Optional[int] = None
    preparation_time: int = 10
    image_url: Optional[str] = None
    ingredients: Optional[str] = None
    allergens: Optional[str] = None
    is_vegetarian: bool = False
    is_spicy: bool = False
    is_available: bool = True
    featured: bool = False
    sort_order: int = 0

class MenuItemCreate(MenuItemBase):
    pass

class MenuItemUpdate(BaseModel):
    category_id: Optional[int] = None
    item_name: Optional[str] = None
    description: Optional[str] = None
    price: Optional[Decimal] = None
    calories: Optional[int] = None
    preparation_time: Optional[int] = None
    image_url: Optional[str] = None
    ingredients: Optional[str] = None
    allergens: Optional[str] = None
    is_vegetarian: Optional[bool] = None
    is_spicy: Optional[bool] = None
    is_available: Optional[bool] = None
    featured: Optional[bool] = None
    sort_order: Optional[int] = None

class MenuItemResponse(MenuItemBase):
    item_id: int
    created_at: datetime
    updated_at: datetime

    model_config = {"from_attributes": True}

# Customer Schemas
class CustomerBase(BaseModel):
    first_name: str
    last_name: str
    email: EmailStr
    phone: str
    date_of_birth: Optional[date] = None
    gender: Optional[GenderEnum] = None

class CustomerCreate(CustomerBase):
    password: str

class CustomerUpdate(BaseModel):
    first_name: Optional[str] = None
    last_name: Optional[str] = None
    email: Optional[EmailStr] = None
    phone: Optional[str] = None
    date_of_birth: Optional[date] = None
    gender: Optional[GenderEnum] = None

class CustomerResponse(CustomerBase):
    customer_id: int
    loyalty_points: int
    total_orders: int
    total_spent: Decimal
    is_active: bool
    email_verified: bool
    created_at: datetime
    updated_at: datetime

    model_config = {"from_attributes": True}

# Order Schemas
class OrderBase(BaseModel):
    location_id: int
    order_type: OrderTypeEnum
    special_instructions: Optional[str] = None

class OrderCreate(OrderBase):
    pass

class OrderUpdate(BaseModel):
    order_status: Optional[OrderStatusEnum] = None
    special_instructions: Optional[str] = None
    actual_prep_time: Optional[int] = None

class OrderResponse(BaseModel):
    order_id: int
    customer_id: Optional[int]
    location_id: int
    order_number: str
    order_type: OrderTypeEnum
    order_status: OrderStatusEnum
    subtotal: Decimal
    tax_amount: Decimal
    delivery_fee: Decimal
    discount_amount: Decimal
    total_amount: Decimal
    payment_status: PaymentStatusEnum
    special_instructions: Optional[str]
    estimated_prep_time: Optional[int]
    actual_prep_time: Optional[int]
    created_at: datetime
    updated_at: datetime

    model_config = {"from_attributes": True}

# Order Item Schemas
class OrderItemBase(BaseModel):
    item_id: int
    quantity: int = 1
    special_instructions: Optional[str] = None

class OrderItemCreate(OrderItemBase):
    pass

class OrderItemResponse(BaseModel):
    order_item_id: int
    order_id: int
    item_id: int
    quantity: int
    unit_price: Decimal
    total_price: Decimal
    special_instructions: Optional[str]

    model_config = {"from_attributes": True}

# Authentication Schemas
class Token(BaseModel):
    access_token: str
    token_type: str

class TokenData(BaseModel):
    email: Optional[str] = None

class LoginRequest(BaseModel):
    email: EmailStr
    password: str 