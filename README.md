
# Log Management System

A full-stack solution for collecting, analyzing, and managing application logs with secure API and interactive dashboard.

---

## ✨ Key Features

### 📡 API Component

APP IS MOST BUILT IN MCV ARHITCETURE WITH BREZZE AUTH, WHIL HERE IS ONLY API ROUTE FOR ADDING LOGS

| Feature            | Description                                                   |
|--------------------|---------------------------------------------------------------|
| JWT Authentication | Secure token-based authentication                             |
| Log Ingestion      | REST API for receiving structured logs with validation        |
| Access Control     | Role-based permissions (Admin/Editor) with policy enforcement |

### 🖥 Web Dashboard

| Feature            | Description                                                   |
|--------------------|---------------------------------------------------------------|
| Advanced Filters   | Combine multiple filters (project, severity, date, etc.)      |
| Data Export        | Excel export with custom column selection                     |
| User Management    | Admin interface for managing users                            |

---

## 🛠 Tech Stack

### Backend
- PHP 8.2 + Laravel 10  
- MySQL 8.0 (with JSON column support)  
- Laravel Sanctum (API auth)  
- Laravel Excel (export functionality)  

### Frontend
- React 18   
- Inertia.js (server-side routing)  
- Tailwind CSS 3.3 (styling)  

---

## 🚀 Installation

### Clone Repository


### Install Dependencies
```bash
composer install
npm install && npm run build
```

### Configuration
```bash
cp .env.example .env
```

### Database Setup
```bash
php artisan migrate --seed
php artisan key:generate
php artisan storage:link
```


## 📡 API POSTMAN

Find a example of postan collection to test api in Log API.postman_collection

## SOME TEHNICAL IMLEMENTATIONS FOR REAL PROJECT
- Analyzing implened code, for better props sahring, and data between controllers and views
- Add indexisng on most called column line users table id, projects tale id,....
- Implement better cache strategy, here i just impemnted example of cache using on stats
- Now statisc is here jus like example it need more work on them, like specific statistic for every user, make taht admin can filer statistic, see own , or see only for specific user
- Make more interasctive graphs for statistic, with drill downs and more optios (library which i prefer to use for graphs, and cahrts is Kooleptor Dashboard)
- Real time analytic with tools like Pusher
- Better role magment
- Better user experience, and forntend, here the forntes is written only to test backend
- Better eroor and messages handling, here I implent useFlash hook, for shwoing messages, but it need to be adapeted and implemnted in all app structure.
- Implement Excel file handling
- Make realtions between tables better structured
- Full logs managment option, in lower hand adding full CRUD optios for log


THERE IS LOTOF MORE THING THAT CAN BE UPGRADED FROM LOGIC TO TEHNICAL BUT THIS IS SOME BASIC, TAHAT APP CAN BE USED



