from sqlalchemy import Column, Integer, String, Text, DECIMAL, Boolean, DateTime, Date, Time, ForeignKey, Enum
from sqlalchemy.sql import func
from sqlalchemy.orm import relationship
from database import Base
import enum

# Enums
class GenderEnum(str, enum.Enum):
    Male = "Male"
    Female = "Female"
    Other = "Other"

class AddressTypeEnum(str, enum.Enum):
    Home = "Home"
    Work = "Work"
    Other = "Other"

class EmployeeRoleEnum(str, enum.Enum):
    MANAGER = "Manager"
    CASHIER = "Cashier"
    COOK = "Cook"
    DELIVERY = "Delivery"
    CLEANER = "Cleaner"

class OrderTypeEnum(str, enum.Enum):
    DINE_IN = "Dine-in"
    TAKEOUT = "Takeout"
    DELIVERY = "Delivery"
    DRIVE_THRU = "Drive-thru"

class OrderStatusEnum(str, enum.Enum):
    Pending = "Pending"
    Confirmed = "Confirmed"
    Preparing = "Preparing"
    Ready = "Ready"
    Out_for_Delivery = "Out for Delivery"
    Delivered = "Delivered"
    Cancelled = "Cancelled"

class PaymentStatusEnum(str, enum.Enum):
    Pending = "Pending"
    Paid = "Paid"
    Failed = "Failed"
    Refunded = "Refunded"

class PaymentMethodEnum(str, enum.Enum):
    CASH = "Cash"
    CREDIT_CARD = "Credit Card"
    DEBIT_CARD = "Debit Card"
    DIGITAL_WALLET = "Digital Wallet"
    GIFT_CARD = "Gift Card"

class PaymentStatusPaymentEnum(str, enum.Enum):
    Pending = "Pending"
    Completed = "Completed"
    Failed = "Failed"
    Refunded = "Refunded"

class DiscountTypeEnum(str, enum.Enum):
    PERCENTAGE = "Percentage"
    FIXED_AMOUNT = "Fixed Amount"
    BUY_ONE_GET_ONE = "Buy One Get One"

class TransactionTypeEnum(str, enum.Enum):
    EARNED = "Earned"
    REDEEMED = "Redeemed"
    EXPIRED = "Expired"
    BONUS = "Bonus"

# Models
class Location(Base):
    __tablename__ = "locations"
    
    location_id = Column(Integer, primary_key=True, index=True)
    store_name = Column(String(100), nullable=False)
    address = Column(String(255), nullable=False)
    city = Column(String(50), nullable=False)
    state = Column(String(50), nullable=False)
    zip_code = Column(String(10), nullable=False)
    phone = Column(String(15), nullable=False)
    email = Column(String(100))
    manager_name = Column(String(100), nullable=False)
    opening_time = Column(Time, default="06:00:00")
    closing_time = Column(Time, default="23:00:00")
    is_active = Column(Boolean, default=True)
    created_at = Column(DateTime, default=func.now())
    updated_at = Column(DateTime, default=func.now(), onupdate=func.now())
    
    # Relationships
    employees = relationship("Employee", back_populates="location")
    orders = relationship("Order", back_populates="location")
    inventory = relationship("Inventory", back_populates="location")
    reviews = relationship("Review", back_populates="location")

class Category(Base):
    __tablename__ = "categories"
    
    category_id = Column(Integer, primary_key=True, index=True)
    category_name = Column(String(50), nullable=False, unique=True)
    description = Column(Text)
    image_url = Column(String(255))
    sort_order = Column(Integer, default=0)
    is_active = Column(Boolean, default=True)
    created_at = Column(DateTime, default=func.now())
    
    # Relationships
    menu_items = relationship("MenuItem", back_populates="category")

class MenuItem(Base):
    __tablename__ = "menu_items"
    
    item_id = Column(Integer, primary_key=True, index=True)
    category_id = Column(Integer, ForeignKey("categories.category_id"), nullable=False)
    item_name = Column(String(100), nullable=False)
    description = Column(Text)
    price = Column(DECIMAL(8, 2), nullable=False)
    calories = Column(Integer)
    preparation_time = Column(Integer, default=10)
    image_url = Column(String(255))
    ingredients = Column(Text)
    allergens = Column(String(255))
    is_vegetarian = Column(Boolean, default=False)
    is_spicy = Column(Boolean, default=False)
    is_available = Column(Boolean, default=True)
    featured = Column(Boolean, default=False)
    sort_order = Column(Integer, default=0)
    created_at = Column(DateTime, default=func.now())
    updated_at = Column(DateTime, default=func.now(), onupdate=func.now())
    
    # Relationships
    category = relationship("Category", back_populates="menu_items")
    variations = relationship("ItemVariation", back_populates="menu_item")
    order_items = relationship("OrderItem", back_populates="menu_item")

class ItemVariation(Base):
    __tablename__ = "item_variations"
    
    variation_id = Column(Integer, primary_key=True, index=True)
    item_id = Column(Integer, ForeignKey("menu_items.item_id"), nullable=False)
    variation_name = Column(String(50), nullable=False)
    price_modifier = Column(DECIMAL(8, 2), default=0.00)
    is_default = Column(Boolean, default=False)
    is_available = Column(Boolean, default=True)
    
    # Relationships
    menu_item = relationship("MenuItem", back_populates="variations")
    order_items = relationship("OrderItem", back_populates="variation")

class Customer(Base):
    __tablename__ = "customers"
    
    customer_id = Column(Integer, primary_key=True, index=True)
    first_name = Column(String(50), nullable=False)
    last_name = Column(String(50), nullable=False)
    email = Column(String(100), unique=True, nullable=False, index=True)
    phone = Column(String(15), nullable=False, index=True)
    password_hash = Column(String(255), nullable=False)
    date_of_birth = Column(Date)
    gender = Column(Enum(GenderEnum))
    loyalty_points = Column(Integer, default=0)
    total_orders = Column(Integer, default=0)
    total_spent = Column(DECIMAL(10, 2), default=0.00)
    is_active = Column(Boolean, default=True)
    email_verified = Column(Boolean, default=False)
    created_at = Column(DateTime, default=func.now())
    updated_at = Column(DateTime, default=func.now(), onupdate=func.now())
    
    # Relationships
    addresses = relationship("CustomerAddress", back_populates="customer")
    orders = relationship("Order", back_populates="customer")
    reviews = relationship("Review", back_populates="customer")
    loyalty_transactions = relationship("LoyaltyTransaction", back_populates="customer")

class CustomerAddress(Base):
    __tablename__ = "customer_addresses"
    
    address_id = Column(Integer, primary_key=True, index=True)
    customer_id = Column(Integer, ForeignKey("customers.customer_id"), nullable=False)
    address_type = Column(Enum(AddressTypeEnum), default=AddressTypeEnum.Home)
    address_line1 = Column(String(255), nullable=False)
    address_line2 = Column(String(255))
    city = Column(String(50), nullable=False)
    state = Column(String(50), nullable=False)
    zip_code = Column(String(10), nullable=False)
    is_default = Column(Boolean, default=False)
    is_active = Column(Boolean, default=True)
    created_at = Column(DateTime, default=func.now())
    
    # Relationships
    customer = relationship("Customer", back_populates="addresses")
    orders = relationship("Order", back_populates="delivery_address")

class Employee(Base):
    __tablename__ = "employees"
    
    employee_id = Column(Integer, primary_key=True, index=True)
    location_id = Column(Integer, ForeignKey("locations.location_id"), nullable=False)
    first_name = Column(String(50), nullable=False)
    last_name = Column(String(50), nullable=False)
    email = Column(String(100), unique=True, nullable=False)
    phone = Column(String(15), nullable=False)
    role = Column(Enum(EmployeeRoleEnum), nullable=False)
    salary = Column(DECIMAL(10, 2))
    hire_date = Column(Date, nullable=False)
    is_active = Column(Boolean, default=True)
    created_at = Column(DateTime, default=func.now())
    
    # Relationships
    location = relationship("Location", back_populates="employees")
    assigned_orders = relationship("Order", back_populates="assigned_employee")

class Order(Base):
    __tablename__ = "orders"
    
    order_id = Column(Integer, primary_key=True, index=True)
    customer_id = Column(Integer, ForeignKey("customers.customer_id"))
    location_id = Column(Integer, ForeignKey("locations.location_id"), nullable=False)
    order_number = Column(String(20), unique=True, nullable=False)
    order_type = Column(Enum(OrderTypeEnum), nullable=False)
    order_status = Column(Enum(OrderStatusEnum), default=OrderStatusEnum.Pending)
    subtotal = Column(DECIMAL(10, 2), nullable=False)
    tax_amount = Column(DECIMAL(8, 2), nullable=False)
    delivery_fee = Column(DECIMAL(6, 2), default=0.00)
    discount_amount = Column(DECIMAL(8, 2), default=0.00)
    total_amount = Column(DECIMAL(10, 2), nullable=False)
    payment_status = Column(Enum(PaymentStatusEnum), default=PaymentStatusEnum.Pending)
    special_instructions = Column(Text)
    estimated_prep_time = Column(Integer)
    actual_prep_time = Column(Integer)
    delivery_address_id = Column(Integer, ForeignKey("customer_addresses.address_id"))
    assigned_employee_id = Column(Integer, ForeignKey("employees.employee_id"))
    created_at = Column(DateTime, default=func.now())
    updated_at = Column(DateTime, default=func.now(), onupdate=func.now())
    
    # Relationships
    customer = relationship("Customer", back_populates="orders")
    location = relationship("Location", back_populates="orders")
    delivery_address = relationship("CustomerAddress", back_populates="orders")
    assigned_employee = relationship("Employee", back_populates="assigned_orders")
    order_items = relationship("OrderItem", back_populates="order")
    payments = relationship("Payment", back_populates="order")
    reviews = relationship("Review", back_populates="order")
    loyalty_transactions = relationship("LoyaltyTransaction", back_populates="order")

class OrderItem(Base):
    __tablename__ = "order_items"
    
    order_item_id = Column(Integer, primary_key=True, index=True)
    order_id = Column(Integer, ForeignKey("orders.order_id"), nullable=False)
    item_id = Column(Integer, ForeignKey("menu_items.item_id"), nullable=False)
    variation_id = Column(Integer, ForeignKey("item_variations.variation_id"))
    quantity = Column(Integer, nullable=False, default=1)
    unit_price = Column(DECIMAL(8, 2), nullable=False)
    total_price = Column(DECIMAL(10, 2), nullable=False)
    special_instructions = Column(Text)
    
    # Relationships
    order = relationship("Order", back_populates="order_items")
    menu_item = relationship("MenuItem", back_populates="order_items")
    variation = relationship("ItemVariation", back_populates="order_items")

class Payment(Base):
    __tablename__ = "payments"
    
    payment_id = Column(Integer, primary_key=True, index=True)
    order_id = Column(Integer, ForeignKey("orders.order_id"), nullable=False)
    payment_method = Column(Enum(PaymentMethodEnum), nullable=False)
    amount = Column(DECIMAL(10, 2), nullable=False)
    payment_status = Column(Enum(PaymentStatusPaymentEnum), default=PaymentStatusPaymentEnum.Pending)
    transaction_id = Column(String(100))
    payment_gateway = Column(String(50))
    processed_at = Column(DateTime)
    created_at = Column(DateTime, default=func.now())
    
    # Relationships
    order = relationship("Order", back_populates="payments")

class Promotion(Base):
    __tablename__ = "promotions"
    
    promotion_id = Column(Integer, primary_key=True, index=True)
    promotion_name = Column(String(100), nullable=False)
    promotion_code = Column(String(20), unique=True)
    description = Column(Text)
    discount_type = Column(Enum(DiscountTypeEnum), nullable=False)
    discount_value = Column(DECIMAL(8, 2), nullable=False)
    min_order_amount = Column(DECIMAL(8, 2), default=0.00)
    max_discount_amount = Column(DECIMAL(8, 2))
    usage_limit = Column(Integer)
    usage_count = Column(Integer, default=0)
    start_date = Column(Date, nullable=False)
    end_date = Column(Date, nullable=False)
    is_active = Column(Boolean, default=True)
    created_at = Column(DateTime, default=func.now())

class Review(Base):
    __tablename__ = "reviews"
    
    review_id = Column(Integer, primary_key=True, index=True)
    customer_id = Column(Integer, ForeignKey("customers.customer_id"), nullable=False)
    order_id = Column(Integer, ForeignKey("orders.order_id"))
    location_id = Column(Integer, ForeignKey("locations.location_id"), nullable=False)
    rating = Column(Integer, nullable=False)
    review_text = Column(Text)
    is_approved = Column(Boolean, default=False)
    created_at = Column(DateTime, default=func.now())
    
    # Relationships
    customer = relationship("Customer", back_populates="reviews")
    order = relationship("Order", back_populates="reviews")
    location = relationship("Location", back_populates="reviews")

class Inventory(Base):
    __tablename__ = "inventory"
    
    inventory_id = Column(Integer, primary_key=True, index=True)
    location_id = Column(Integer, ForeignKey("locations.location_id"), nullable=False)
    item_name = Column(String(100), nullable=False)
    current_stock = Column(Integer, nullable=False, default=0)
    min_stock_level = Column(Integer, default=10)
    max_stock_level = Column(Integer, default=100)
    unit = Column(String(20), default="pieces")
    cost_per_unit = Column(DECIMAL(8, 2))
    supplier = Column(String(100))
    last_restocked = Column(Date)
    expiry_date = Column(Date)
    created_at = Column(DateTime, default=func.now())
    updated_at = Column(DateTime, default=func.now(), onupdate=func.now())
    
    # Relationships
    location = relationship("Location", back_populates="inventory")

class LoyaltyTransaction(Base):
    __tablename__ = "loyalty_transactions"
    
    transaction_id = Column(Integer, primary_key=True, index=True)
    customer_id = Column(Integer, ForeignKey("customers.customer_id"), nullable=False)
    order_id = Column(Integer, ForeignKey("orders.order_id"))
    transaction_type = Column(Enum(TransactionTypeEnum), nullable=False)
    points = Column(Integer, nullable=False)
    description = Column(String(255))
    created_at = Column(DateTime, default=func.now())
    
    # Relationships
    customer = relationship("Customer", back_populates="loyalty_transactions")
    order = relationship("Order", back_populates="loyalty_transactions") 