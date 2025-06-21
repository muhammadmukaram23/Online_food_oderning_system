from typing import List
from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
import crud
import schemas
from database import get_db

router = APIRouter(prefix="/locations", tags=["Locations"])

@router.post("/", response_model=schemas.LocationResponse)
def create_location(location: schemas.LocationCreate, db: Session = Depends(get_db)):
    """Create a new restaurant location"""
    return crud.create_location(db=db, location=location)

@router.get("/", response_model=List[schemas.LocationResponse])
def get_locations(skip: int = 0, limit: int = 100, db: Session = Depends(get_db)):
    """Get all restaurant locations"""
    return crud.get_locations(db, skip=skip, limit=limit)

@router.get("/{location_id}", response_model=schemas.LocationResponse)
def get_location(location_id: int, db: Session = Depends(get_db)):
    """Get a specific location by ID"""
    db_location = crud.get_location(db, location_id=location_id)
    if db_location is None:
        raise HTTPException(status_code=404, detail="Location not found")
    return db_location

@router.put("/{location_id}", response_model=schemas.LocationResponse)
def update_location(location_id: int, location: schemas.LocationUpdate, db: Session = Depends(get_db)):
    """Update a location"""
    db_location = crud.update_location(db, location_id=location_id, location=location)
    if db_location is None:
        raise HTTPException(status_code=404, detail="Location not found")
    return db_location

@router.delete("/{location_id}")
def delete_location(location_id: int, db: Session = Depends(get_db)):
    """Delete a location"""
    db_location = crud.delete_location(db, location_id=location_id)
    if db_location is None:
        raise HTTPException(status_code=404, detail="Location not found")
    return {"message": "Location deleted successfully"} 