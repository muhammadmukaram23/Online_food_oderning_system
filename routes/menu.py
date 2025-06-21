from typing import List, Optional
from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
import crud
import schemas
from database import get_db

router = APIRouter(prefix="/menu", tags=["Menu"])

# Category routes
@router.post("/categories", response_model=schemas.CategoryResponse)
def create_category(category: schemas.CategoryCreate, db: Session = Depends(get_db)):
    """Create a new menu category"""
    return crud.create_category(db=db, category=category)

@router.get("/categories", response_model=List[schemas.CategoryResponse])
def get_categories(skip: int = 0, limit: int = 100, db: Session = Depends(get_db)):
    """Get all menu categories"""
    return crud.get_categories(db, skip=skip, limit=limit)

@router.get("/categories/{category_id}", response_model=schemas.CategoryResponse)
def get_category(category_id: int, db: Session = Depends(get_db)):
    """Get a specific category by ID"""
    db_category = crud.get_category(db, category_id=category_id)
    if db_category is None:
        raise HTTPException(status_code=404, detail="Category not found")
    return db_category

@router.put("/categories/{category_id}", response_model=schemas.CategoryResponse)
def update_category(category_id: int, category: schemas.CategoryUpdate, db: Session = Depends(get_db)):
    """Update a category"""
    db_category = crud.update_category(db, category_id=category_id, category=category)
    if db_category is None:
        raise HTTPException(status_code=404, detail="Category not found")
    return db_category

@router.delete("/categories/{category_id}")
def delete_category(category_id: int, db: Session = Depends(get_db)):
    """Delete a category"""
    db_category = crud.delete_category(db, category_id=category_id)
    if db_category is None:
        raise HTTPException(status_code=404, detail="Category not found")
    return {"message": "Category deleted successfully"}

# Menu Item routes
@router.post("/items", response_model=schemas.MenuItemResponse)
def create_menu_item(menu_item: schemas.MenuItemCreate, db: Session = Depends(get_db)):
    """Create a new menu item"""
    return crud.create_menu_item(db=db, menu_item=menu_item)

@router.get("/items", response_model=List[schemas.MenuItemResponse])
def get_menu_items(skip: int = 0, limit: int = 100, category_id: Optional[int] = None, db: Session = Depends(get_db)):
    """Get all menu items, optionally filtered by category"""
    return crud.get_menu_items(db, skip=skip, limit=limit, category_id=category_id)

@router.get("/items/featured", response_model=List[schemas.MenuItemResponse])
def get_featured_items(limit: int = 10, db: Session = Depends(get_db)):
    """Get featured menu items"""
    return crud.get_featured_menu_items(db, limit=limit)

@router.get("/items/{item_id}", response_model=schemas.MenuItemResponse)
def get_menu_item(item_id: int, db: Session = Depends(get_db)):
    """Get a specific menu item by ID"""
    db_menu_item = crud.get_menu_item(db, item_id=item_id)
    if db_menu_item is None:
        raise HTTPException(status_code=404, detail="Menu item not found")
    return db_menu_item

@router.put("/items/{item_id}", response_model=schemas.MenuItemResponse)
def update_menu_item(item_id: int, menu_item: schemas.MenuItemUpdate, db: Session = Depends(get_db)):
    """Update a menu item"""
    db_menu_item = crud.update_menu_item(db, item_id=item_id, menu_item=menu_item)
    if db_menu_item is None:
        raise HTTPException(status_code=404, detail="Menu item not found")
    return db_menu_item

@router.delete("/items/{item_id}")
def delete_menu_item(item_id: int, db: Session = Depends(get_db)):
    """Delete a menu item"""
    db_menu_item = crud.delete_menu_item(db, item_id=item_id)
    if db_menu_item is None:
        raise HTTPException(status_code=404, detail="Menu item not found")
    return {"message": "Menu item deleted successfully"} 