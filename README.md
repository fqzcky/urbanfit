# Urban Sneakers - E-Commerce Platform 

Urban Sneakers is a modern, premium e-commerce web application built for sneakerheads and streetwear enthusiasts. Developed with a focus on seamless user experience (UX) and robust backend architecture, this project serves as a comprehensive showcase of full-stack web development capabilities.

## 🚀 Key Features

* **Premium User Interface:** Designed with a "Bunglon" dynamic transparent navbar, edge-to-edge video hero banner, and a modern typography combination (Plus Jakarta Sans & Bebas Neue) to replicate the feel of international streetwear brands.
* **Seamless Payment Integration:** Fully integrated with **Midtrans Payment Gateway (Snap API)**, allowing users to safely checkout using BCA, Mandiri, GoPay, and QRIS (Sandbox environment).
* **Dynamic Shipping Calculation:** Implements real-time shipping cost calculations using external logistics APIs based on the user's province, city, and district.
* **Interactive Cart & Order Summary:** Features a sticky order summary, real-time subtotal calculation, and asynchronous item removal for an uninterrupted shopping experience.
* **Complete Order Management:** Users can track order history, view detailed invoices, and cancel pending transactions directly from their dashboard.
* **Floating WhatsApp Integration:** Quick customer service access via a floating WhatsApp button embedded across the application.

## 🛠️ Tech Stack

* **Backend:** Laravel 10 (PHP)
* **Frontend:** Blade Templating Engine, HTML5, CSS3
* **UI Framework:** Bootstrap 5.3
* **Database:** MySQL
* **Third-Party Services:** Midtrans Payment Gateway, Ongkir API (RajaOngkir/Dikomers)
* **Animation & Assets:** AOS (Animate On Scroll), Bootstrap Icons

## ⚙️ Installation & Setup Guide

To run this project locally, follow these steps:

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/fqzcky/urbanfit.git](https://github.com/fqzcky/urbanfit.git)
    cd urbanfit
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Environment Setup:**
    Duplicate the `.env.example` file and rename it to `.env`.
    ```bash
    cp .env.example .env
    ```
    Generate the application key:
    ```bash
    php artisan key:generate
    ```

4.  **Database Configuration:**
    Configure your database credentials in the `.env` file:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=urbanfit
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Midtrans & API Keys Configuration:**
    Add your API keys to the `.env` file:
    ```env
    MIDTRANS_CLIENT_KEY=your_client_key_here
    MIDTRANS_SERVER_KEY=your_server_key_here
    ```

6.  **Run Migrations & Seeders:**
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Link Storage (For Product Images):**
    ```bash
    php artisan storage:link
    ```

8.  **Serve the Application:**
    ```bash
    php artisan serve
    ```
    Visit `http://127.0.0.1:8000` in your browser.

## 👨‍💻 Author

**Muhammad Faiq Zacky** *Informatics Student at Universitas Amikom Yogyakarta*
* GitHub: [@fqzcky](https://github.com/fqzcky)

---
*This project was developed as a comprehensive portfolio piece demonstrating modern web development practices.*