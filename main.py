from fastapi import FastAPI, Depends
from fastapi.middleware.cors import CORSMiddleware
from sqlalchemy.orm import Session
import models
from database import engine, get_db
from routes import auth, locations, menu, orders

# Create database tables
models.Base.metadata.create_all(bind=engine)

# Initialize FastAPI app
app = FastAPI(
    title="KFC Restaurant Management API",
    description="A comprehensive API for managing KFC restaurant operations including menu, orders, customers, and locations",
    version="1.0.0",
    docs_url="/docs",
    redoc_url="/redoc"
)

# Add CORS middleware
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # In production, specify actual origins
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Include routers
app.include_router(auth.router)
app.include_router(locations.router)
app.include_router(menu.router)
app.include_router(orders.router)

@app.get("/")
def read_root():
    """Root endpoint with API information"""
    return {
        "message": "Welcome to KFC Restaurant Management API",
        "version": "1.0.0",
        "documentation": "/docs",
        "endpoints": {
            "authentication": "/auth",
            "locations": "/locations",
            "menu": "/menu",
            "orders": "/orders"
        }
    }

@app.get("/health")
def health_check(db: Session = Depends(get_db)):
    """Health check endpoint"""
    try:
        # Test database connection
        db.execute("SELECT 1")
        return {"status": "healthy", "database": "connected"}
    except Exception as e:
        return {"status": "unhealthy", "database": "disconnected", "error": str(e)}

@app.get("/stats")
def get_stats(db: Session = Depends(get_db)):
    """Get basic statistics"""
    try:
        locations_count = db.query(models.Location).count()
        categories_count = db.query(models.Category).count()
        menu_items_count = db.query(models.MenuItem).count()
        customers_count = db.query(models.Customer).count()
        orders_count = db.query(models.Order).count()
        
        return {
            "locations": locations_count,
            "categories": categories_count,
            "menu_items": menu_items_count,
            "customers": customers_count,
            "orders": orders_count
        }
    except Exception as e:
        return {"error": str(e)}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000) 