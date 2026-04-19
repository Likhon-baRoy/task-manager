# 📝 Task Management System (Laravel)

A simple and clean task management system built with Laravel to help teams organize daily work efficiently.

---

## 🚀 Features

* ✅ Create, update, and delete tasks
* ✅ Track task status (Pending, In Progress, Completed)
* ✅ Inline status update from task list
* ✅ Filter tasks by status (with Select2 dropdown)
* ✅ Clean and responsive UI using Bootstrap
* ✅ Validation with user-friendly error handling
* ✅ Feature tests for core functionalities
* ✅ Structured layout with separated CSS & JS

---

## 🛠️ Technologies Used

* **Backend:** Laravel
* **Frontend:** Blade (Laravel templating)
* **Styling:** Bootstrap 5
* **Enhancements:** jQuery, Select2
* **Database:** MySQL

---

## ⚙️ Installation Guide

Follow these steps to run the project locally:

### 1️⃣ Clone the repository

```bash
git clone https://github.com/your-username/task-manager.git
cd task-manager
```

---

### 2️⃣ Install dependencies

```bash
composer install
```

---

### 3️⃣ Setup environment file

```bash
cp .env.example .env
php artisan key:generate
```

---

### 4️⃣ Configure database

Update your `.env` file:

```env
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

---

### 5️⃣ Run migrations

```bash
php artisan migrate
```

---

### 6️⃣ Start development server

```bash
php artisan serve
```

Now open:

```
http://127.0.0.1:8000/tasks
```

---

## 🧪 Testing

Run feature tests using:

```bash
php artisan test
```

### ✔ What is tested?

* Task creation
* Task update
* Task deletion
* Task listing

These tests ensure that core functionalities behave as expected.

---

## 🧠 Key Design Decisions

* **Blade instead of SPA (React/Vue):**
  Chosen for simplicity and faster development for this scope.

* **Inline status update:**
  Improves user experience by reducing navigation.

* **Select2 for filtering:**
  Provides a cleaner and more interactive filtering UI.

* **Separated layout, CSS, and JS:**
  Ensures maintainable and scalable structure.

* **Backend filtering instead of frontend-only:**
  Keeps logic reliable and consistent.

---

## ⚠️ Assumptions

* No authentication required (single-user system)
* Tasks are independent (no user assignment or roles)
* Focus is on core functionality and usability

---

## 📌 Future Improvements

* User authentication & roles
* Task assignment to users
* Due dates & reminders
* AJAX-based updates (no page reload)
* Pagination & API support

---

## 👨‍💻 Author Notes

This project focuses on:

* Clean and maintainable code
* Logical structure and separation of concerns
* Reliable functionality with testing
* Thoughtful UX improvements

---

## ✅ Conclusion

This system fulfills all the core requirements:

* Efficient task management
* Smooth frontend-backend interaction
* Reliable and tested functionality
* Clean and user-friendly interface

---

✨ Thank you for reviewing this project!
