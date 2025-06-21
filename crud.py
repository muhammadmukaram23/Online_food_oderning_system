from sqlalchemy.orm import Session
from sqlalchemy import and_, or_
from typing import List, Optional
from datetime import datetime, date, timedelta
import models
import schemas
from passlib.context import CryptContext
import uuid

pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")

def get_password_hash(password: str) -> str:
    return pwd_context.hash(password)

def verify_password(plain_password: str, hashed_password: str) -> bool:
    return pwd_context.verify(plain_password, hashed_password)

# Location CRUD
def create_location(db: Session, location: schemas.LocationCreate):
    db_location = models.Location(**location.model_dump())
    db.add(db_location)
    db.commit()
    db.refresh(db_location)
    return db_location

def get_location(db: Session, location_id: int):
    return db.query(models.Location).filter(models.Location.location_id == location_id).first()

def get_locations(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Location).offset(skip).limit(limit).all()

def update_location(db: Session, location_id: int, location: schemas.LocationUpdate):
    db_location = db.query(models.Location).filter(models.Location.location_id == location_id).first()
    if db_location:
        for key, value in location.model_dump(exclude_unset=True).items():
            setattr(db_location, key, value)
        db.commit()
        db.refresh(db_location)
    return db_location

def delete_location(db: Session, location_id: int):
    db_location = db.query(models.Location).filter(models.Location.location_id == location_id).first()
    if db_location:
        db.delete(db_location)
        db.commit()
    return db_location

# Category CRUD
def create_category(db: Session, category: schemas.CategoryCreate):
    db_category = models.Category(**category.model_dump())
    db.add(db_category)
    db.commit()
    db.refresh(db_category)
    return db_category

def get_category(db: Session, category_id: int):
    return db.query(models.Category).filter(models.Category.category_id == category_id).first()

def get_categories(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Category).filter(models.Category.is_active == True).offset(skip).limit(limit).all()

def update_category(db: Session, category_id: int, category: schemas.CategoryUpdate):
    db_category = db.query(models.Category).filter(models.Category.category_id == category_id).first()
    if db_category:
        for key, value in category.model_dump(exclude_unset=True).items():
            setattr(db_category, key, value)
        db.commit()
        db.refresh(db_category)
    return db_category

def delete_category(db: Session, category_id: int):
    db_category = db.query(models.Category).filter(models.Category.category_id == category_id).first()
    if db_category:
        db.delete(db_category)
        db.commit()
    return db_category

# Menu Item CRUD
def create_menu_item(db: Session, menu_item: schemas.MenuItemCreate):
    db_menu_item = models.MenuItem(**menu_item.model_dump())
    db.add(db_menu_item)
    db.commit()
    db.refresh(db_menu_item)
    return db_menu_item

def get_menu_item(db: Session, item_id: int):
    return db.query(models.MenuItem).filter(models.MenuItem.item_id == item_id).first()

def get_menu_items(db: Session, skip: int = 0, limit: int = 100, category_id: Optional[int] = None):
    query = db.query(models.MenuItem).filter(models.MenuItem.is_available == True)
    if category_id:
        query = query.filter(models.MenuItem.category_id == category_id)
    return query.offset(skip).limit(limit).all()

def get_featured_menu_items(db: Session, limit: int = 10):
    return db.query(models.MenuItem).filter(
        and_(models.MenuItem.is_available == True, models.MenuItem.featured == True)
    ).limit(limit).all()

def update_menu_item(db: Session, item_id: int, menu_item: schemas.MenuItemUpdate):
    db_menu_item = db.query(models.MenuItem).filter(models.MenuItem.item_id == item_id).first()
    if db_menu_item:
        for key, value in menu_item.model_dump(exclude_unset=True).items():
            setattr(db_menu_item, key, value)
        db.commit()
        db.refresh(db_menu_item)
    return db_menu_item

def delete_menu_item(db: Session, item_id: int):
    db_menu_item = db.query(models.MenuItem).filter(models.MenuItem.item_id == item_id).first()
    if db_menu_item:
        db.delete(db_menu_item)
        db.commit()
    return db_menu_item

# Customer CRUD
def create_customer(db: Session, customer: schemas.CustomerCreate):
    hashed_password = get_password_hash(customer.password)
    customer_data = customer.model_dump()
    customer_data.pop("password")
    db_customer = models.Customer(**customer_data, password_hash=hashed_password)
    db.add(db_customer)
    db.commit()
    db.refresh(db_customer)
    return db_customer

def get_customer(db: Session, customer_id: int):
    return db.query(models.Customer).filter(models.Customer.customer_id == customer_id).first()

def get_customer_by_email(db: Session, email: str):
    return db.query(models.Customer).filter(models.Customer.email == email).first()

def get_customers(db: Session, skip: int = 0, limit: int = 100):
    return db.query(models.Customer).filter(models.Customer.is_active == True).offset(skip).limit(limit).all()

def update_customer(db: Session, customer_id: int, customer: schemas.CustomerUpdate):
    db_customer = db.query(models.Customer).filter(models.Customer.customer_id == customer_id).first()
    if db_customer:
        for key, value in customer.model_dump(exclude_unset=True).items():
            setattr(db_customer, key, value)
        db.commit()
        db.refresh(db_customer)
    return db_customer

def authenticate_customer(db: Session, email: str, password: str):
    customer = get_customer_by_email(db, email)
    if not customer:
        return False
    if not verify_password(password, customer.password_hash):
        return False
    return customer

# Order CRUD
def generate_order_number():
    return f"KFC{datetime.now().strftime('%Y%m%d')}{str(uuid.uuid4())[:8].upper()}"

def create_order(db: Session, order: schemas.OrderCreate, customer_id: Optional[int] = None):
    order_data = order.model_dump()
    order_data["order_number"] = generate_order_number()
    order_data["customer_id"] = customer_id
    order_data["subtotal"] = 0.00
    order_data["tax_amount"] = 0.00
    order_data["total_amount"] = 0.00
    
    db_order = models.Order(**order_data)
    db.add(db_order)
    db.commit()
    db.refresh(db_order)
    return db_order

def get_order(db: Session, order_id: int):
    return db.query(models.Order).filter(models.Order.order_id == order_id).first()

def get_orders(db: Session, skip: int = 0, limit: int = 100, customer_id: Optional[int] = None):
    query = db.query(models.Order)
    if customer_id:
        query = query.filter(models.Order.customer_id == customer_id)
    return query.order_by(models.Order.created_at.desc()).offset(skip).limit(limit).all()

def update_order(db: Session, order_id: int, order: schemas.OrderUpdate):
    db_order = db.query(models.Order).filter(models.Order.order_id == order_id).first()
    if db_order:
        for key, value in order.model_dump(exclude_unset=True).items():
            setattr(db_order, key, value)
        db.commit()
        db.refresh(db_order)
    return db_order

def calculate_order_total(db: Session, order_id: int):
    order_items = db.query(models.OrderItem).filter(models.OrderItem.order_id == order_id).all()
    subtotal = sum(float(item.total_price) for item in order_items)
    tax_rate = 0.08  # 8% tax
    tax_amount = subtotal * tax_rate
    total_amount = subtotal + tax_amount
    
    db_order = db.query(models.Order).filter(models.Order.order_id == order_id).first()
    if db_order:
        db_order.subtotal = subtotal
        db_order.tax_amount = tax_amount
        db_order.total_amount = total_amount
        db.commit()
        db.refresh(db_order)
    return db_order

# Order Item CRUD
def add_order_item(db: Session, order_id: int, order_item: schemas.OrderItemCreate):
    menu_item = get_menu_item(db, order_item.item_id)
    if not menu_item:
        return None
    
    unit_price = menu_item.price
    total_price = float(unit_price) * order_item.quantity
    
    db_order_item = models.OrderItem(
        order_id=order_id,
        item_id=order_item.item_id,
        quantity=order_item.quantity,
        unit_price=unit_price,
        total_price=total_price,
        special_instructions=order_item.special_instructions
    )
    
    db.add(db_order_item)
    db.commit()
    db.refresh(db_order_item)
    
    # Recalculate order total
    calculate_order_total(db, order_id)
    
    return db_order_item

def get_order_items(db: Session, order_id: int):
    return db.query(models.OrderItem).filter(models.OrderItem.order_id == order_id).all()

def remove_order_item(db: Session, order_item_id: int):
    db_order_item = db.query(models.OrderItem).filter(models.OrderItem.order_item_id == order_item_id).first()
    if db_order_item:
        order_id = db_order_item.order_id
        db.delete(db_order_item)
        db.commit()
        # Recalculate order total
        calculate_order_total(db, order_id)
    return db_order_item 