# SignServer - Deployment & Configuration Guide

This repository contains the SignServer application, integrating a C# RSSP SDK with a Laravel backend.

## 1. RSSP SDK Configuration

The application requires the compiled `rssp_sdk.exe` executable to handle digital signatures.

### Build and Setup:
1. Navigate to the C# source code.
2. Build the project (ensure the target environment is set correctly, e.g., .NET Framework 4.8.1).
3. Retrieve the compiled executable from the `Release_Restful` folder.
4. Place `rssp_sdk.exe` into the following directory within the project:
   `app/private/rssp_sdk/`

### Environment Variables (.env)
Add the following configuration to your `.env` file:

```env
RSSP_SDK_DIRECTORY="app/private/rssp_sdk"
RSSP_SDK_NAME="rssp_sdk.exe"
```

---

## 2. Deployment Commands

Run the following commands sequentially to deploy and initialize the application:

### 1. Install Composer dependencies
```bash
composer install
```

### 2. Run database migrations
*(This will create all necessary tables, including roles and permissions tables)*
```bash
php artisan migrate
```

### 3. Seed roles and permissions
*(This will create 'admin' and 'user' roles, define permissions, and assign the 'admin' role to the user with ID 1)*
```bash
php artisan db:seed
```

### 4. Clear application caches
```bash
php artisan optimize:clear
```
