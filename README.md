# ToDo Application

## Overview

The ToDo application is a simple task management system designed to help users manage their daily tasks efficiently. Built using PHP, this application follows a structured design for scalability and ease of use.

## Features

- Add, edit, and delete tasks
- Mark tasks as completed
- View tasks in a clean, user-friendly interface
- Persistent data storage using a database
- Environment-based configuration

## Project Structure

```
ToDo/
|-- .env                # Environment configuration
|-- .env.example        # Example environment configuration
|-- .git                # Git repository metadata
|-- .gitignore          # Git ignored files
|-- app/                # Application-specific logic and components
|-- bootstrap.php       # Initializes the application
|-- composer.json       # Composer dependency definition
|-- composer.lock       # Composer dependency lock file
|-- controllers/        # Controller classes and logic
|-- helpers.php         # Helper functions
|-- index.php           # Application entry point
|-- router.php          # Request routing logic
|-- routes/             # Application route definitions
|-- src/                # Core application source code
|-- test.php            # Test script
|-- vendor/             # Third-party dependencies
|-- views/              # Frontend templates or views
```

## Requirements

The following dependencies are required and included in the `composer.json` file:

- `php`: >=7.4
- `vlucas/phpdotenv`: ^5.5 for managing environment variables
- `symfony/var-dumper`: ^6.0 for debugging

## Design Patterns Used

This project incorporates the following design patterns:

- **Model-View-Controller (MVC)**: For separating the application logic, user interface, and data management.
- **Singleton**: Used for managing database connections to ensure only one instance exists.
- **Strategy**: Utilized for flexible implementation of different task handling strategies.
- **Factory**: For creating instances of classes dynamically, especially for controller and service objects.

## Prerequisites

- PHP >= 7.4
- Composer
- A web server (e.g., Apache, Nginx)
- A database system (e.g., MySQL, SQLite)

## Installation

1. Clone the repository:

   ```bash
   git clone <repository-url>
   cd ToDo
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Configure the environment:

   - Copy `.env.example` to `.env`
   - Update the `.env` file with your database and other configurations

4. Start the development server:

   ```bash
   php -S localhost:8000
   ```

5. Access the application in your browser at `http://localhost:8000`

## API Documentation

The application exposes the following APIs:

- **GET /tasks**: Fetch all tasks

  - Response: JSON array of tasks

- **POST /tasks**: Create a new task

  - Request body: `{ "title": "Task Title", "description": "Task description" }`
  - Response: JSON object of the created task

- **PUT /tasks/{id}**: Update a specific task

  - Request body: `{ "title": "Updated Title", "completed": true }`
  - Response: JSON object of the updated task

- **DELETE /tasks/{id}**: Delete a specific task

  - Response: Success message

## Database Schema

The application uses the following schema:

- **tasks**

  - `id` (int, primary key, auto-increment)
  - `title` (varchar, not null)
  - `completed` (boolean, default: false)
  - `created_at` (timestamp, default: current timestamp)
  - `updated_at` (timestamp, default: current timestamp on update)

- **users**

  - `id` (int, primary key, auto-increment)
  - `name` (varchar, not null)
  - `email` (varchar, unique, not null)
  - `password` (varchar, not null)
  - `telegram_id` (bigint)

## Advanced Configuration

1. **Environment Variables**

   - Configure database settings, debug modes, and other options in the `.env` file.

2. **Custom Routing**

   - Modify `router.php` to add or customize routes.

3. **Debugging**

   - Use `symfony/var-dumper` for enhanced debugging output during development.

## Usage

- Open the application in your web browser.
- Use the interface to add, update, delete, or mark tasks as completed.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Commit your changes with clear messages.
4. Submit a pull request.

## Acknowledgments

- Built with PHP and Composer
- Inspired by simple task management solutions

---

Feel free to explore and enhance the application!
