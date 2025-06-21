from datetime import timedelta
from fastapi import APIRouter, Depends, HTTPException, status
from fastapi.security import OAuth2PasswordRequestForm
from sqlalchemy.orm import Session
import crud
import schemas
import auth
from database import get_db

router = APIRouter(prefix="/auth", tags=["Authentication"])

@router.post("/register", response_model=schemas.CustomerResponse)
def register_customer(customer: schemas.CustomerCreate, db: Session = Depends(get_db)):
    """Register a new customer"""
    # Check if customer already exists
    db_customer = crud.get_customer_by_email(db, email=customer.email)
    if db_customer:
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail="Email already registered"
        )
    
    # Create new customer
    return crud.create_customer(db=db, customer=customer)

@router.post("/login", response_model=schemas.Token)
def login_customer(login_data: schemas.LoginRequest, db: Session = Depends(get_db)):
    """Login customer and return access token"""
    customer = auth.authenticate_customer(db, login_data.email, login_data.password)
    if not customer:
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Incorrect email or password",
            headers={"WWW-Authenticate": "Bearer"},
        )
    
    access_token_expires = timedelta(minutes=auth.ACCESS_TOKEN_EXPIRE_MINUTES)
    access_token = auth.create_access_token(
        data={"sub": customer.email}, expires_delta=access_token_expires
    )
    
    return {"access_token": access_token, "token_type": "bearer"}

@router.get("/me", response_model=schemas.CustomerResponse)
def get_current_customer_info(current_customer: schemas.CustomerResponse = Depends(auth.get_current_customer)):
    """Get current customer information"""
    return current_customer 