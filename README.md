# Task Management App

A web-based task management system built with Laravel. It lets teams organize projects, assign tasks, track status updates, and manage user roles through an admin dashboard — turning scattered task tracking into a centralized, organized workflow.

## Features

- **User roles & permissions** — separate access levels for Admin and Member accounts
- **Project management** — create and organize multiple projects
- **Task assignment** — assign specific tasks to team members
- **Status tracking** — update tasks through To Do, In Progress, and Done stages
- **Admin dashboard** — centralized view of all projects and tasks

## Tech Stack

- **Laravel** — backend framework and routing
- **Laravel Breeze** — authentication (login, registration, password reset)
- **Blade** — templating engine for dynamic views
- **MySQL** — relational database for storing tasks, projects, and users
- **Tailwind CSS** — utility-first styling framework

## Roles & Permissions

| Role | Permissions |
|------|-------------|
| **Admin** | Create and manage projects, assign tasks, manage users and roles |
| **Member** | View assigned tasks, update their own task status, track personal progress |

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL

### Installation

1. Clone the repository
   ```bash
   git clone https://github.com/mgabunad/task-management-app.git
   cd task-management-app
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install JS dependencies
   ```bash
   npm install
   ```

4. Copy the environment file and generate an app key
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your `.env` file with your database credentials

6. Run migrations
   ```bash
   php artisan migrate
   ```

7. Build frontend assets
   ```bash
   npm run dev
   ```

8. Start the local server
   ```bash
   php artisan serve
   ```

The app will be available at `http://127.0.0.1:8000`.

## Project Background

This project was built as a final project for CIIT College, adapted from a paired e-commerce guide template. The authentication (Laravel Breeze) and admin dashboard shell were reused as-is, while the core structure (products, orders) was rebuilt around Projects, Tasks, and Roles to fit a task management workflow.

## Author

**Mayjhon V. Gabunada**
Full Stack Web Developer & Data Analyst
[GitHub](https://github.com/mgabunad)
