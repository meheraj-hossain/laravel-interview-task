<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Setup Instructions

Follow these steps to set up the project locally:

1. **Clone the Repository**
   ```bash
   git clone https://github.com/meheraj-hossain/laravel-interview-task.git
2. **Run Composer Install**
    ```bash
    composer install
3. **Setup Environment** <br>
    copy .env.example file and paste as .env <br><br>
4. **Generate Application Key**
    ```bash
    php artisan key:generate
5. **Generate JWT Secret**
    ```bash
    php artisan jwt:secret
6. **Run Migration**
    ```bash
    php artisan migrate
7. **Seed The Database (If necessary)**
    ```bash
    php artisan db:seed

## Environment Configuration

Set up local environment (only changed variables are given below):

```bash
APP_NAME=Application name
APP_ENV=local
APP_KEY=Generated by php artisan key:generate
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql or any other supported database
DB_HOST=Database host, e.g., 127.0.0.1.
DB_PORT=Database port, e.g., 3306.
DB_DATABASE=Your database name
DB_USERNAME=Your database username
DB_PASSWORD=Your database password

JWT_SECRET=generated by php artisan jwt:secret
```

## Run The Project Locally
    php artisan serve


## API Endpoints

### 1. Auth
- **Registration**: `http://127.0.0.1:8000/api/register`
- **Login**: `http://127.0.0.1:8000/api/login`
- **Logout**: `http://127.0.0.1:8000/api/logout`

### 2. Projects
- **Index**: `http://127.0.0.1:8000/api/projects`
- **Store**: `http://127.0.0.1:8000/api/projects`
- **Report**: `http://127.0.0.1:8000/api/projects/{id}/report`
- **Update**: `http://127.0.0.1:8000/api/projects/{project}`
- **Delete**: `http://127.0.0.1:8000/api/projects/{project}`

### 3. Tasks
- **Index**: `http://127.0.0.1:8000/api/projects/{project}/tasks`
- **Store**: `http://127.0.0.1:8000/api/projects/{project}/tasks`
- **Upload**: `http://127.0.0.1:8000/api/projects/{project}/tasks/upload`
- **Update**: `http://127.0.0.1:8000/api/projects/{project}/tasks/{task}`
- **Delete**: `http://127.0.0.1:8000/api/projects/{project}/tasks/{task}`

### 4. Subtasks
- **Index**: `http://127.0.0.1:8000/api/tasks/{task}/subtasks`
- **Store**: `http://127.0.0.1:8000/api/tasks/{task}/subtasks`
- **Update**: `http://127.0.0.1:8000/api/tasks/{task}/subtasks/{subtask}`
- **Delete**: `http://127.0.0.1:8000/api/tasks/{task}/subtasks/{subtask}`



<!-- ## Form Fields

### 1. Auth
- **Registration**: `name, email, password, password_confirmation`
- **Login**: `email, password`

### 2. Projects
- **Store**: `name`
- **Update**: `name`

### 3. Tasks
- **Store**: `name`
- **upload**: `tasks_file`
- **Update**: `name`

### 4. Subtasks
- **Store**: `name`
- **Update**: `name` -->
