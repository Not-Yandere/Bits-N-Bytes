# BitsNBytes E-commerce Website

Welcome to BitsNBytes, a state-of-the-art e-commerce platform where you can find the best deals on electronics, accessories, and more. This project showcases a fully functional e-commerce website built with PHP and MySQL, featuring secure user authentication, product management, and a seamless shopping experience.

## Live Demo

Check out the live website here: [BitsNBytes](http://bitsnbytes.rf.gd)

## Features

- **User Authentication**: Secure login and registration system with session management.
- **Product Management**: Admin panel for adding, editing, and deleting products.
- **Shopping Cart**: Add products to your cart, view cart details, and proceed to checkout.
- **Responsive Design**: Fully responsive design for optimal viewing on any device.

## Tech Stack

- **Backend**: PHP, MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Libraries and Frameworks**: Jquery (THAT'S IT !!)
- **Hosting**: Hosted on [bitsnbytes.rf.gd](http://bitsnbytes.rf.gd)

## Installation

To set up the project locally, follow these steps:

1. **Clone the repository**:
    ```bash
    git clone https://github.com/Not-Yandere/bitsnbytes.git
    cd bitsnbytes
    ```

2. **Set up the database**:
    - Create a MySQL database.
    - Import the `database.sql` file to set up the necessary tables.

3. **Configure the environment**:
    - Create a `.env` file in the /config directory.
    - Add your database configuration details in the `.env` file.

4. **Run the project**:
    - Start your local server (e.g., XAMPP, WAMP).
    - Navigate to the project directory and open `index.php` in your browser.

## Folder Structure

- `/admin-dashboard`: Contains admin-related pages for adding, editing, and managing products.
    - `add-item.php`: Add a new product.
    - `admin-in.php`: Admin login page.
    - `dashboard.php`: Admin dashboard.
    - `edit-item.php`: Edit an existing product.
    - `valide-admin-in.php`: Validate admin login.
- `/config`: Contains the database configuration files.
    - `db_connect.php`: Database connection script.
    - `.env`: Environment configuration file (create it and add your db credentials).
- `/CSS`: Contains CSS files for styling the website.
    - `amazon.css`
    - `carttt.css`
    - `dashboard.css`
    - `log--in.css`
    - `product.css`
- `/data`: Contains data files.
    - `visitor.txt`: Log file for visitors. (don't worry the directory and the file is created when the first user visit the website.)
- `/hardware`: Contains a seperate page for products view.
    - `header1.php`
    - `product1.php`
- `/Images`: Contains product images and icons used in design of website.
- `/PHPMailer`: Contains PHPMailer library for sending emails.
- `/products`: Contains product images and user uploads.
- `.htaccess`: Apache configuration file.
- `404.php`: Custom 404 error page.
- `accessories.php`: Accessories page.
- `ajax_search.php`: AJAX search functionality.
- `cart.php`: Cart page.
- `cart.js`: JavaScript file for cart functionality.
- `checkout.php`: Checkout page.
- `checkout_success.php`: Checkout success page.
- `consoles.php`: Consoles page.
- `cookie-consent.php`: Cookie consent management.
- `database.sql`: SQL file for setting up the database.
- `forgot-password.php`: Forgot password page.
- `games.php`: Games page.
- `get-products.php`: Script to fetch products.
- `Hardware.php`: Hardware products page.
- `header.php`: Common header file.
- `index.php`: Home page.
- `laptops.php`: Laptops page.
- `log-in.php`: Login page.
- `logout_func.php`: Logout functionality.
- `menu.js`: JavaScript file for menu functionality.
- `monitors.php`: Monitors page.
- `phones.php`: Phones page.
- `privacy-policy.php`: Privacy policy page.
- `reset-password.php`: Reset password page.
- `search.php`: Search functionality.
- `session_check.php`: Session check script.
- `sign-up.php`: Signup page.
- `terms-of-service.php`: Terms of service page.
- `validation.js`: JavaScript file for client-side validation.
- `valide-in.php`: Validation script for login.
- `valide-up.php`: Validation script for signup.
- `verify-otp.php`: Verify OTP page.

## Contributing

Contributions are welcome! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact

For any inquiries or feedback, please reach out to us at mohamedtarekhamad@gmail.com or on telegram @NOT_YANDERE

---

Thank you for visiting BitsNBytes repo this was a  wonderful project to work on and hopefully it's my first step to become a remarkable backend dev !!
