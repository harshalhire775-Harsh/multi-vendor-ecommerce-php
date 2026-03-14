# LuxeStore - Multi-Vendor E-Commerce Platform

A premium full-stack PHP & MySQL e-commerce project designed for modern standards, featuring a stunning User Interface built with TailwindCSS and FontAwesome. 

## Features
- **Frontend Customer Store**: Modern hero sections, dynamic product sliders, categories, search with filters.
- **Shopping Cart & Checkout**: Add, remove, update quantities, dynamic cart total calculation, secure mock checkout.
- **Vendor Panel**: Vendors can register, view sales, manage their own products, and check their stats.
- **Admin Panel**: Superadmin dashboard with aggregate statistics and recent transactions.
- **Authentication**: Secure password hashing with role-based redirection.
- **RESTful API**: External interface for fetching products (`/api/products.php`).
- **Responsive & Glassmorphic UI**: High-end animations and responsive design out of the box.

## How to Install (Localhost)
1. Copy the `ecommerce-project` folder to your local server (e.g., `htdocs` in XAMPP or `www` in WAMP).
2. Open phpMyAdmin and create a database named `ecommerce_db`.
3. Import the `setup.sql` file provided in the root directory into your `ecommerce_db` database.
4. Navigate to `http://localhost/ecommerce-project/` in your browser.

## Default Accounts
- **Admin**: `admin@example.com` / `admin123`
- **Vendor & Customer**: You can sign up using the Sign Up page. Try registering a vendor!

## Deployment Notes (InfinityFree)
1. Create a MySQL database on your InfinityFree CPanel.
2. Import `setup.sql` into the newly created database.
3. Update `db.php` with the InfinityFree MySQL Host, Username, Password, and Database Name.
4. Upload all files via FileZilla / Online File Manager to the `htdocs` folder.
5. You're live!

Designed by Harshal's Assistant.
