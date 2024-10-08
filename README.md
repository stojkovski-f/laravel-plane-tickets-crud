<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


# DEMO APP - Minimal Laravel API
### Airplane Tickets Management 
This demo showcases a streamlined Laravel API for a virtual airline ticketing system. It demonstrates core functionalities including booking, canceling, and modifying plane tickets, catering to both direct customer use and integration with other systems.


- Live demo [https://demo.filipstojkovski.com](https://demo.filipstojkovski.com)
- API Documentation [Swager docs](https://demo.filipstojkovski.com/api/documentation).




# Local Setup
### Prerequisites

- Git installed on your local machine
- PHP 8.3
- Composer
- Node.js and npm



### Step-by-Step Guide

1. **Clone the repository:**
    
    ```bash
    git clone https://github.com/stojkovski-f/laravel-plane-tickets-crud
    cd laravel-plane-tickets-crud
    ```
    
2. **Install PHP dependencies:**
    
    ```bash
    composer install
    ```
    
3. **Install JavaScript dependencies:**
    
    ```bash
    npm install
    ```
    
4. **Create a copy of the .env file:**
    
    ```bash
    cp .env.example .env
    ```
    
5. **Generate an application key:**
    
    ```bash
    php artisan key:generate
    ```
    
6. **Configure your database in the .env file:**Update the DB_* variables to match your local database setup.
7. **Run database migrations:**
    
    ```bash
    php artisan migrate
    ```
    
8. **Compile assets:**
    
    ```bash
    npm run dev
    ```
    
9. **Start the development server:**
    
    ```bash
    php artisan serve
    ```
    

Open the app with the url that the console returns (ussualy http://localhost:8000).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
