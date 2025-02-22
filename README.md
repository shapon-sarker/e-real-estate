sql
CREATE DATABASE e_real_estate;
------------------------------------

USE e_real_estate;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    total_flats INT NOT NULL,
    sold_flats INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE flats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    flat_no VARCHAR(50) NOT NULL,
    flat_size_sft DECIMAL(10, 2) NOT NULL,
    flat_rate_per_sft DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(15, 2) NOT NULL,
    car_parking ENUM('yes', 'no') DEFAULT 'no',
    car_parking_price DECIMAL(15, 2) DEFAULT 0,
    utility_price DECIMAL(15, 2) DEFAULT 0,
    grand_total DECIMAL(15, 2) NOT NULL,
    status ENUM('sold', 'unsold') DEFAULT 'unsold',
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    flat_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    father_name VARCHAR(255),
    date_of_birth DATE,
    occupation VARCHAR(100),
    present_address TEXT,
    permanent_address TEXT,
    phone_number VARCHAR(20),
    nationality VARCHAR(50),
    nid_passport VARCHAR(50),
    tin_number VARCHAR(50),
    car_parking ENUM('yes', 'no') DEFAULT 'no',
    loan_option ENUM('yes', 'no') DEFAULT 'no',
    payment_mode ENUM('one_time', 'installments') DEFAULT 'one_time',
    signature VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (flat_id) REFERENCES flats(id)
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    project_id INT NOT NULL,
    flat_id INT NOT NULL,
    mr_no VARCHAR(50) NOT NULL,
    payment_method ENUM('cash', 'cheque') DEFAULT 'cash',
    payment_amount DECIMAL(15, 2) NOT NULL,
    due_amount DECIMAL(15, 2) NOT NULL,
    payment_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (flat_id) REFERENCES flats(id)
);
