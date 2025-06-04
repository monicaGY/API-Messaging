# API - Messaging
This **RESTful API**, developed with **Laravel**, follows the **Hexagonal Architecture**, which allows a clear separation between business logic and external layers such as controllers, persistence, or external services. This design promotes a **decoupled, domain-driven** and highly testable architecture.

The project consistently applies **Object-Oriented Programming (OOP)** principles along with the **SOLID principles**, ensuring **clean, maintainable, and scalable** code.

### Key Features

- 🔐 **Token-based authentication** using Laravel Sanctum to securely protect endpoints.
- 🛡️ **Custom and authentication middlewares** that control access, such as verifying if a user belongs to a conversation before allowing message actions.
- ✅ **Custom request validators** to ensure incoming JSON payloads have the correct structure and valid data before processing.
- 🌱 **Database seeders** to populate the database with initial data, useful for development and testing environments.
- 🧪 **Automated testing with Mockery**, enabling effective unit testing through dependency mocking.
- 📚 **API documentation via Swagger (OpenAPI)**, allowing easy exploration and interaction with the available endpoints.
- 🐳 **Docker support**, making it simple to deploy and run the API in reproducible environments suitable for development, staging, or production.


## Prerequisites

Before you begin, ensure you have the following installed:
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)

## Getting Started

### 1. Clone the Repository

```bash
# Clone the repository
git clone https://github.com/monicaGY/API-Messaging.git api-messaging

# Navigate to the project directory
cd api-messaging
```

### 2. Environment Setup

```bash
# Copy the example env file
cp .env.example .env

# Update the following variables in .env file
DB_PORT=3306
DB_PASSWORD=my_secret_password
DB_HOST=mysql

# Add this variables in .env file
MONGO_CONNECTION=mongodb
MONGO_HOST=mongo
MONGO_PORT=27017
MONGO_DATABASE=api_messaging
MONGO_USERNAME=root
MONGO_PASSWORD=root2025
```

### 3. Build and Run Docker Containers

```bash
# Build and start the containers
docker-compose up -d

# Install PHP dependencies
docker-compose exec app composer install

# Generate application key
docker-compose exec app php artisan key:generate
```

**Permission Issues**
```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data storage
docker-compose exec app chmod -R 775 storage
```


### 4. Database Setup

```bash
# Run database migrations
docker-compose exec app php artisan migrate

# Seed the database
docker-compose exec app php artisan db:seed
```

## Available Services

| Service | Port                    |
|---------|-------------------------|
| API | `http://localhost:8000` |
| Documentation | `http://localhost:8000/api/documentation` |

### 5. API Messaging - login
You can use the following test accounts to authenticate and interact with the API during development:

| Email | Password                    |
|---------|-------------------------|
| `juana.gutierrez@example.com` | `juana123` |
| `fernando.gomez@example.com` | `fernando123` |
| `sebastian.garcia@example.com` | `sebastian123` |

