# Task Management AI System

## Overview

Task Management AI System is a full-stack web application built with Laravel, React, MySQL, and Laravel Sanctum.

The application allows users to securely register and log in, manage tasks through a responsive interface, and interact with an AI-powered assistant capable of creating tasks, generating suggestions, and summarizing task descriptions.

The system implements Role-Based Access Control (RBAC) with Admin and User roles.

---

# Features

## Authentication

* User Registration
* User Login
* User Logout
* Password Hashing
* Laravel Sanctum Token Authentication
* Protected API Routes

## Role-Based Access Control

### Admin

* View all tasks
* Manage all tasks
* Manage users
* Assign user roles

### User

* Create tasks
* View own tasks
* Update own tasks
* Delete own tasks

---

## Task Management

Users can:

* Create Tasks
* Read Tasks
* Update Tasks
* Delete Tasks

### Task Fields

| Field       | Type                              |
| ----------- | --------------------------------- |
| Title       | String                            |
| Description | Text                              |
| Due Date    | Date                              |
| Status      | Pending / In Progress / Completed |

---

## AI Assistant

The application includes an AI-powered assistant.

### Supported Features

#### Task Suggestions

Example:

Create a study plan for Laravel

#### Summarization

Converts long task descriptions into concise summaries.

#### Natural Language Commands

Examples:

Create a task to study Laravel tomorrow

Create a task to finish React project by Friday

List my tasks

Delete task 3

When the OpenAI API is unavailable, the system automatically uses a fallback AI response mechanism.

---

## Frontend

Built using:

* React
* Axios
* Vite

Features:

* Dynamic Task Dashboard
* Real-Time UI Updates
* Authentication
* Task Management
* AI Interaction

---

# Technology Stack

## Backend

* PHP 8+
* Laravel 12
* Laravel Sanctum
* MySQL

## Frontend

* React
* Axios
* Vite

## AI

* OpenAI API
* Custom Fallback Service

---

# Project Structure

task-management-ai/

├── app/

├── routes/

├── database/

├── resources/

├── frontend/

│ ├── src/

│ ├── public/

│ ├── package.json

│ └── vite.config.js

├── .env

├── composer.json

└── README.md

---

# Installation

## Prerequisites

* PHP 8+
* Composer
* MySQL
* Node.js 20+
* npm

---

# Backend Setup

Clone repository:

git clone https://github.com/yourusername/task-management-ai.git

Navigate to project:

cd task-management-ai

Install dependencies:

composer install

Copy environment file:

cp .env.example .env

Generate application key:

php artisan key:generate

Configure database settings inside .env

Run migrations:

php artisan migrate

Run seeders:

php artisan db:seed

Start Laravel server:

php artisan serve

Backend URL:

http://localhost:8000

---

# Frontend Setup

Navigate to frontend folder:

cd frontend

Install dependencies:

npm install

Start frontend:

npm run dev

Frontend URL:

http://localhost:5173

---

# Environment Variables

Configure the following values inside .env

APP_NAME=TaskManagementAI

APP_ENV=local

APP_KEY=

APP_DEBUG=true

APP_URL=http://localhost:8000

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=task_management_ai

DB_USERNAME=root

DB_PASSWORD=

OPENAI_API_KEY=

---

# Authentication

Login returns a Sanctum token.

Example:

POST /api/login

Request:

{
"email": "[admin@test.com](mailto:admin@test.com)",
"password": "password"
}

Response:

{
"user": {
"id": 1,
"name": "Admin"
},
"token": "your-token"
}

Include token in requests:

Authorization: Bearer your-token

---

# API Documentation

## Authentication

### Register

POST /api/register

### Login

POST /api/login

### Logout

POST /api/logout

---

## Tasks

### Get Tasks

GET /api/tasks

Returns all tasks belonging to the authenticated user.

Admins can view all tasks.

### Get Task

GET /api/tasks/{id}

### Create Task

POST /api/tasks

Request:

{
"title": "Study Laravel",
"description": "Read Laravel documentation",
"due_date": "2026-06-20",
"status": "Pending"
}

### Update Task

PUT /api/tasks/{id}

Request:

{
"title": "Study Laravel",
"status": "Completed"
}

### Delete Task

DELETE /api/tasks/{id}

---

## AI Endpoints

### Chat

POST /api/ai/chat

Request:

{
"message": "How can I improve productivity?"
}

---

### Suggestions

POST /api/ai/suggest

Request:

{
"prompt": "Learn React"
}

---

### Summarize

POST /api/ai/summarize

Request:

{
"text": "Long task description..."
}

---

### Natural Language Commands

POST /api/ai/command

Request:

{
"message": "Create a task to study Laravel tomorrow"
}

Response:

{
"type": "task_created",
"task": {
"id": 1,
"title": "Study Laravel tomorrow"
}
}

---

# Security

The application follows security best practices:

* Passwords are hashed using Laravel Hash
* Authentication is protected by Laravel Sanctum
* API routes require authentication
* Role-based access control is enforced
* Sensitive environment variables are stored in .env
* SQL injection protection through Eloquent ORM
* CSRF protection provided by Laravel

---

# Deployment

## VPS Deployment

1. Upload source code to server
2. Install Composer dependencies
3. Configure MySQL database
4. Configure environment variables
5. Run migrations
6. Build frontend

npm install

npm run build

7. Configure Nginx or Apache
8. Restart services

---

# Testing

Example manual test flow:

1. Register user
2. Login
3. Create task
4. Update task
5. Delete task
6. Test AI command endpoint
7. Verify authorization restrictions

---

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/a0fb14c9-4178-4f3e-b216-4fbd7f7fb021" />

