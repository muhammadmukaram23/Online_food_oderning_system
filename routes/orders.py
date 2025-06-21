from typing import List, Optional
from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
import crud
import schemas
import auth
from database import get_db

router = APIRouter(prefix="/orders", tags=["Orders"])

@router.post("/", response_model=schemas.OrderResponse)
def create_order(
    order: schemas.OrderCreate, 
    db: Session = Depends(get_db),
    current_customer: schemas.CustomerResponse = Depends(auth.get_current_customer)
):
    """Create a new order"""
    return crud.create_order(db=db, order=order, customer_id=current_customer.customer_id)

@router.get("/", response_model=List[schemas.OrderResponse])
def get_orders(
    skip: int = 0, 
    limit: int = 100, 
    db: Session = Depends(get_db),
    current_customer: schemas.CustomerResponse = Depends(auth.get_current_customer)
):
    """Get orders for the current customer"""
    return crud.get_orders(db, skip=skip, limit=limit, customer_id=current_customer.customer_id)

@router.get("/all", response_model=List[schemas.OrderResponse])
def get_all_orders(skip: int = 0, limit: int = 100, db: Session = Depends(get_db)):
    """Get all orders (admin endpoint)"""
    return crud.get_orders(db, skip=skip, limit=limit)

@router.get("/{order_id}", response_model=schemas.OrderResponse)
def get_order(order_id: int, db: Session = Depends(get_db)):
    """Get a specific order by ID"""
    db_order = crud.get_order(db, order_id=order_id)
    if db_order is None:
        raise HTTPException(status_code=404, detail="Order not found")
    return db_order

@router.put("/{order_id}", response_model=schemas.OrderResponse)
def update_order(order_id: int, order: schemas.OrderUpdate, db: Session = Depends(get_db)):
    """Update an order"""
    db_order = crud.update_order(db, order_id=order_id, order=order)
    if db_order is None:
        raise HTTPException(status_code=404, detail="Order not found")
    return db_order

@router.post("/{order_id}/items", response_model=schemas.OrderItemResponse)
def add_order_item(
    order_id: int, 
    order_item: schemas.OrderItemCreate, 
    db: Session = Depends(get_db)
):
    """Add an item to an order"""
    db_order_item = crud.add_order_item(db, order_id=order_id, order_item=order_item)
    if db_order_item is None:
        raise HTTPException(status_code=404, detail="Menu item not found")
    return db_order_item

@router.get("/{order_id}/items", response_model=List[schemas.OrderItemResponse])
def get_order_items(order_id: int, db: Session = Depends(get_db)):
    """Get all items in an order"""
    return crud.get_order_items(db, order_id=order_id)

@router.delete("/items/{order_item_id}")
def remove_order_item(order_item_id: int, db: Session = Depends(get_db)):
    """Remove an item from an order"""
    db_order_item = crud.remove_order_item(db, order_item_id=order_item_id)
    if db_order_item is None:
        raise HTTPException(status_code=404, detail="Order item not found")
    return {"message": "Order item removed successfully"}

@router.post("/{order_id}/calculate-total", response_model=schemas.OrderResponse)
def calculate_order_total(order_id: int, db: Session = Depends(get_db)):
    """Calculate and update order total"""
    db_order = crud.calculate_order_total(db, order_id=order_id)
    if db_order is None:
        raise HTTPException(status_code=404, detail="Order not found")
    return db_order 