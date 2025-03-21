# Laravel Task 2

This is a Laravel project for managing orders, customers, and cart items. The project contains several functionalities like displaying orders, their associated customers, and the items in the order. The focus of the task is to optimize an unoptimized Laravel controller method to ensure that it performs better in terms of database queries and readability.

## Setup Instructions

Follow these steps to set up the project locally:

### 1. Clone the repository:
```bash
  git clone https://github.com/karadzinov/task2.git
```
### 2. Navigate into the project directory:
```bash
  cd task2
```
### 3. Install project dependencies:
```bash
  composer install
```
### 4. Set up your environment variables:
```bash
  cp .env.example .env
```
#### Generate an application key:
```bash
  php artisan key:generate
```
### 5. Run migrations:
```bash
  php artisan migrate
```
### 6. Seed the database 
```bash
  php artisan db:seed
```
```bash
  php artisan serve
```

## Access the application:
   Open your browser and go to http://127.0.0.1:8000/orders to view the orders.


### Refactoring Task
The goal is to refactor the given Laravel controller method to improve its performance and efficiency.

Refactored code:
https://github.com/karadzinov/task2/blob/c97d208dd1cdb1f6842deed11971024c05b13f84/app/Http/Controllers/OrderController.php#L14
