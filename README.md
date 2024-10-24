# E-Commerce API Documentation

## Overview

This API provides endpoints for managing products and orders in a simple e-commerce system.

## Base URL http://127.0.0.1:8000/api
## Authentication

All endpoints require authentication. Use Laravel Sanctum for user authentication.

## Endpoints

### 1. Auth
#### Login

- **Endpoint**: `/login`
- **Method**: `POST`
- **Description**: Authenticate a user and retrieve an access token.
- **Request Body** (application/x-www-form-urlencoded):
  - `email`: The user's email address (string).
  - `password`: The user's password (string).
  
- **Request Body**:
  ```json
  {   
    "email":"user@user.com",
    "password":"123123123"
  }
  ```
- **Response**:
    - **200 OK**: Returns the authentication token.
    - **Example Response**:
    ```json
    {
        "token": "1|dRnuBifkKVzEvZpYERUZzjlT1pEkpfDa0I4yCIEG9c55b23e"
    }
    ```
   - **422 Unprocessable Content**: Returned for validation errors.
  
#### Register

- **Endpoint**: `/register`
- **Method**: `POST`
- **Description**: Register a new user and create an accoun.
- **Request Body** (application/x-www-form-urlencoded):
  - `email`: The user's email address (string).
  - `email`: The user's email address (string).
  - `password`: The user's password (string).
  - `password_confirmation`: Confirmation of the user's password (string).
  
- **Request Body**:
  ```json
  {   
    "name":"user",
    "email":"user@user.com",
    "password":"123123123",
    "password_confirmation":"123123123"
  }
  ```
- **Response**:
    - **201 Created**: Returns the newly created user and the authentication token.
    <!-- - **Example Response**:
    ```json
    {
    "user": {
        "id": 1,
        "name": "user",
        "email": "user@user.com"
    },
    "token": "1|dRnuBifkKVzEvZpYERUZzjlT1pEkpfDa0I4yCIEG9c55b23e"
    }
    ``` -->
   - **422 Unprocessable Content**: Returned for validation errors.


### 2. Products

#### Get All Products

- **Endpoint**: `/products`
- **Method**: `GET`
- **Description**: Retrieve a list of all products.
- **Query Parameters** (optional):
  - `name`: Filter products by name (string).
  - `min_price`: Filter products by minimum price (float).
  - `max_price`: Filter products by maximum price (float).
- **Response**:
  - **200 OK**: Returns a paginated list of products.
  - **Example Response**:
    ```json
    {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Eve Bayer PhD",
                "price": "1549.00",
                "stock": 0,
                "created_at": "2024-10-24T05:01:01.000000Z",
                "updated_at": "2024-10-24T05:01:01.000000Z"
            },
        ],
        "first_page_url": "http://ecommerce-task.test/api/products?page=1",
        "from": 1,
        "last_page": 5,
        "last_page_url": "http://ecommerce-task.test/api/products?page=5",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
        ],
        "next_page_url": "http://ecommerce-task.test/api/products?page=2",
        "path": "http://ecommerce-task.test/api/products",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 50
    }
    ```
   - **401 Unauthorized**: Returned when authentication is required but not provided.

### 2. Orders

#### Place an Order

- **Endpoint**: `/orders`
- **Method**: `POST`
- **Description**: Place a new order.
- **Request Body**:
  ```json
  {
    "products": [
        {
        "id": 9,
        "quantity": 2
        }
    ]
  }
  ```
- **Response**:
  - **201 Created**: Returns the created order with associated products.
  - **Example Response**:
  ```json
    {
        "updated_at": "2024-10-24T05:32:55.000000Z",
        "created_at": "2024-10-24T05:32:55.000000Z",
        "id": 1,
        "products": [
            {
                "id": 9,
                "name": "Elta Skiles",
                "price": "5657.00",
                "stock": 3,
                "created_at": "2024-10-24T05:01:01.000000Z",
                "updated_at": "2024-10-24T05:32:55.000000Z",
                "pivot": {
                    "order_id": 1,
                    "product_id": 9,
                    "quantity": 2
                }
            }
        ]
    }
  ```
   - **422 Unprocessable Content**: Returned for validation errors.
   - **401 Unauthorized**: Returned when authentication is required but not provided.
     
#### Show an Order
- **Endpoint**: `/orders/{id}`
- **Method**: `GET`
- **Description**: Retrieve the details of a specific order by its ID.
- **URL Parameters**:
  - `id`: The ID of the order you want to retrieve (integer).
- **Response**:
  - **200 OK**: Returns the order details, including associated products.
  - **Example Response**:
    ```json
    {
        "updated_at": "2024-10-24T05:32:55.000000Z",
        "created_at": "2024-10-24T05:32:55.000000Z",
        "id": 1,
        "products": [
            {
                "id": 9,
                "name": "Elta Skiles",
                "price": "5657.00",
                "stock": 3,
                "created_at": "2024-10-24T05:01:01.000000Z",
                "updated_at": "2024-10-24T05:32:55.000000Z",
                "pivot": {
                    "order_id": 1,
                    "product_id": 9,
                    "quantity": 2
                }
            }
        ]
    }
    ```
   - **404 Not Found**: Returned if the order with the specified ID does not exist.
   - **401 Unauthorized**: Returned when authentication is required but not provided.
