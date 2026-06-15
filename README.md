# Task Management AI System

## Overview

This project is a Task Management System built with Laravel, MySQL, React, and OpenAI integration.

The application allows users to manage tasks, authenticate securely, interact through AI-powered commands, and access functionality based on assigned roles.

---

## Features

### Authentication

* User Registration
* User Login
* User Logout
* Laravel Sanctum Authentication
* Password Hashing

### Role-Based Access Control

Roles:

* Admin
* User

Permissions:

* Users can manage their own tasks
* Admins can manage all tasks and users

### Task Management

* Create Tasks
* View Tasks
* Update Tasks
* Delete Tasks

Task fields:

* Title
* Description
* Due Date
* Status

### AI Assistant

Features:

* Task Suggestions
* Task Summarization
* Natural Language Commands

Examples:

* "Create a task to study Laravel tomorrow"
* "List my tasks"

Fallback responses are provided when the OpenAI API is unavailable.

### Frontend

Built with:

* React
* Axios
* Vite

Features:

* Dynamic task list
* Real-time UI updates
* Token-based authentication
* Dashboard interface

---

## Tech Stack

Backend:

* PHP 8+
* Laravel 12
* Laravel Sanctum
* MySQL

Frontend:

* React
* Axios
* Vite

AI:

* OpenAI API
* Local fallback AI service

---

## Installation

### Clone Repository

git clone <repository-url>

cd task-management-ai

### Backend Setup

composer install

cp .env.example .env

php artisan key:generate

Configure database settings inside .env

Run migrations:

php artisan migrate

Run seeders:

php artisan db:seed

Start server:

php artisan serve

### Frontend Setup

cd frontend

npm install

npm run dev

---

## Environment Variables

Required variables:

OPENAI_API_KEY=

DB_DATABASE=

DB_USERNAME=

DB_PASSWORD=

---

## API Endpoints

Authentication

POST /api/register

POST /api/login

POST /api/logout

Tasks

GET /api/tasks

GET /api/tasks/{id}

POST /api/tasks

PUT /api/tasks/{id}

DELETE /api/tasks/{id}

AI

POST /api/ai/chat

POST /api/ai/suggest

POST /api/ai/summarize

POST /api/ai/command

---

## Authentication Header

Authorization: Bearer {token}

---

## Example Login

POST /api/login

{
"email": "[admin@test.com](mailto:admin@test.com)",
"password": "password"
}

Response:

{
"token": "..."
}

---

## Deployment

1. Upload project to VPS.
2. Configure Apache/Nginx.
3. Configure MySQL.
4. Run migrations.
5. Configure environment variables.
6. Build frontend:

npm run build

7. Serve Laravel application.

---

## Author

Anatay Smankulov
