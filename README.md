# Task Management API (Laravel)

## Overview
A RESTful Task Management API built with Laravel.  
It includes authentication, role-based access control, and full CRUD operations for tasks.

---

## Features

### Authentication
- User registration & login
- Laravel Sanctum token authentication

### Role-Based Access Control (RBAC)
- Admin role
- User role
- Built using Spatie Laravel Permission

### Task Management
- Create tasks
- Read tasks
- Update tasks
- Delete tasks

### Permissions
- Users can manage only their own tasks
- Admins can manage all tasks

---

## Tech Stack
- Laravel 10+
- MySQL
- Laravel Sanctum
- Spatie Laravel Permission

---

## API Endpoints

### Auth
- POST /api/register
- POST /api/login
- POST /api/logout

### Tasks
- GET /api/tasks
- POST /api/tasks
- GET /api/tasks/{id}
- PUT /api/tasks/{id}
- DELETE /api/tasks/{id}

---

## Authorization Rules

- Admin: full access
- User: only own tasks

---

## Setup Instructions

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
