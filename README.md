# JLibrary Management

A modern, responsive library management application built with PHP and MySQL.

## Features

📚 **Book Management**

- Add, edit, and delete books
- Track book inventory
- ISBN and publication year tracking
- Book descriptions

📊 **Dashboard**

- Real-time statistics
- Total books and copies count
- Recently added books tracking
- Quick action cards

## Project Structure

```
library/
├── includes/           # Modular components
│   ├── auth.php       # Authentication check
│   ├── config.php     # Configuration settings
│   ├── footer.php     # Footer template
│   ├── functions.php  # Reusable functions
│   ├── header.php     # Header template
│   └── navbar.php     # Navigation bar
├── db/                # Database files
├── index.php          # Login page
├── signup.php         # Registration page
├── home.php           # Dashboard
├── books.php          # Book listing
├── add-book.php       # Add book form
├── edit-book.php      # Edit book form
└── style.css          # Styling
```

## Installation

1. Import the database schema
2. Update database credentials in `includes/config.php`
3. Place files in your web server directory
4. Access through your browser

## Original Tutorial

Based on tutorial by [Elias Abdurrahman](https://github.com/codingWithElias) - [YouTube](https://youtu.be/QxZxHUf7c_0)
