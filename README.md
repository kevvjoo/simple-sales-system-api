# Sales Management System

A simple sales management system built with Laravel (backend) and Vue 3 (frontend).

## Features

- ✅ Product Management (CRUD)
    - Add, edit, delete products
    - Track stock levels
- ✅ Customer Management (CRUD)
    - Add, edit, delete customers
- ✅ Sales Transaction Management
    - Select customer and products
    - Multiple products per transaction
    - Automatic subtotal and total calculation
    - Stock validation (prevents overselling)
    - Automatic stock reduction after transaction
- ✅ Responsive UI with Tailwind CSS
- ✅ Form validation
- ✅ Loading states
- ✅ Error handling

## Tech Stack

### Backend
- Laravel 12.x
- PostgresSQL
- PHP 8.4+

## Installation

### Prerequisites
- PHP 8.4+
- Composer
- Node.js 22+
- MySQL
- Laravel Herd (optional) or PHP built-in server

### Backend Setup

1. Clone the repository
```bash
git clone https://github.com/kevvjoo/simple-sales-system-api.git
cd simple-sales-system-api
```

2. Install dependencies
```bash
composer install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env`
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=simple-sales-system
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations and seeders
```bash
php artisan migrate --seed
```

This will create sample data:
- 4 products (Laptop, Mouse, Keyboard, Monitor)
- 3 customers

6. Start the server

**Option A: Using Laravel Herd** (Recommended if installed)
```bash
# Herd automatically serves at: http://simple-sales-system-api.test
# Make sure Herd is running
```

**Option B: Using PHP Built-in Server**
```bash
php artisan serve
# Server will run at: http://localhost:8000
```

## Database Schema

### products
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Product name |
| price | decimal(16,2) | Product price |
| stock | integer | Available stock |
| timestamps | timestamp | Created/Updated/Deleted |

### customers
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Customer name |
| phone | string | Phone number |
| timestamps | timestamp | Created/Updated/Deleted |

### sales_orders
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| customer_id | bigint | Foreign key to customers |
| date | timestamp | Transaction date |
| total | decimal(16,2) | Total amount |
| timestamps | timestamp | Created/Updated/Deleted |

### product_sales_order
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| product_id | bigint | Foreign key to products |
| sales_order_id | bigint | Foreign key to sales orders |
| quantity | integer | Quantity |
| price | decimal(16,2) | Product price |
| subtotal | decimal(16,2) | Item subtotal |
| timestamps | timestamp | Created/Updated |

## API Endpoints

### Products
- `GET /api/products` - List all products
- `POST /api/products` - Create product
- `GET /api/products/{id}` - Show product
- `PUT /api/products/{id}` - Update product
- `DELETE /api/products/{id}` - Delete product

### Customers
- `GET /api/customers` - List all customers
- `POST /api/customers` - Create customer
- `GET /api/customers/{id}` - Show customer
- `PUT /api/customers/{id}` - Update customer
- `DELETE /api/customers/{id}` - Delete customer

### Sales
- `GET /api/sales` - List all sales transactions
- `POST /api/sales` - Create sale transaction

## Developer

**Kevin**
- GitHub: [kevvjoo]
- Test Assignment: Junior-Mid Full Stack Developer
- This project was created for educational/assessment purposes.

---

**Built with ❤️ using Laravel**
