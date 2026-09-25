# Taskflow

Project Code: WST21-PM-2026-SF  
Student Name:  Jasmine Cariquitan
Course & Year:  BSIT-2
Database Used: SQLite

## Purpose

Taskflow is a simple personal task manager that helps users organize daily responsibilities, track progress, and keep tasks updated from one dashboard.

## Features

- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status
- Responsive dashboard using `#1892a2` as the primary color, with `#e07ef0` and `#386ac0` as accents

## Run locally

```bash
php artisan migrate
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000` in a browser.

Run the test suite with:

```bash
php artisan test
```