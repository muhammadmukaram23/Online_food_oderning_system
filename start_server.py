#!/usr/bin/env python3
"""
KFC Restaurant API Server Startup Script
"""

import os
import sys
import subprocess
from pathlib import Path

def check_requirements():
    """Check if all required packages are installed"""
    try:
        import fastapi
        import uvicorn
        import sqlalchemy
        import pymysql
        import pydantic
        import passlib
        import jose
        print("✅ All required packages are installed")
        return True
    except ImportError as e:
        print(f"❌ Missing package: {e}")
        print("Please run: pip install -r requirements.txt")
        return False

def check_database_config():
    """Check if database configuration exists"""
    env_file = Path(".env")
    if env_file.exists():
        print("✅ Environment file found")
        return True
    else:
        print("⚠️  No .env file found. Creating a template...")
        create_env_template()
        return False

def create_env_template():
    """Create a template .env file"""
    env_content = """# Database Configuration
MYSQL_USER=root
MYSQL_PASSWORD=your_password_here
MYSQL_HOST=localhost
MYSQL_PORT=3306
MYSQL_DATABASE=kfc_restaurant

# JWT Configuration
SECRET_KEY=your-secret-key-here-change-in-production
ALGORITHM=HS256
ACCESS_TOKEN_EXPIRE_MINUTES=30

# Application Configuration
DEBUG=True
HOST=0.0.0.0
PORT=8000
"""
    with open(".env", "w") as f:
        f.write(env_content)
    print("📝 Created .env template file")
    print("Please edit the .env file with your database credentials")

def start_server():
    """Start the FastAPI server"""
    print("🚀 Starting KFC Restaurant API Server...")
    print("📖 API Documentation will be available at: http://localhost:8000/docs")
    print("🔍 Health Check: http://localhost:8000/health")
    print("📊 Stats: http://localhost:8000/stats")
    print("\nPress Ctrl+C to stop the server\n")
    
    try:
        # Use uvicorn to run the server
        os.system("python -m uvicorn main:app --reload --host 0.0.0.0 --port 8000")
    except KeyboardInterrupt:
        print("\n👋 Server stopped")
    except Exception as e:
        print(f"❌ Error starting server: {e}")

def main():
    """Main function"""
    print("🍗 KFC Restaurant Management API")
    print("=" * 40)
    
    # Check requirements
    if not check_requirements():
        sys.exit(1)
    
    # Check database configuration
    if not check_database_config():
        print("\n⚠️  Please configure your database settings in the .env file")
        print("Then run this script again")
        sys.exit(1)
    
    # Start the server
    start_server()

if __name__ == "__main__":
    main() 