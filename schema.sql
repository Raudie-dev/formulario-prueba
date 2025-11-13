-- Create database
CREATE DATABASE IF NOT EXISTS formularios_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE formularios_db;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Forms table
CREATE TABLE forms (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    mes_anio VARCHAR(50),
    codigo VARCHAR(100),
    fecha_emision VARCHAR(100),
    temp_muestra VARCHAR(50),
    observaciones LONGTEXT,
    data JSON,
    pdf_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX(user_id),
    INDEX(created_at)
);

-- Form measurements table
CREATE TABLE form_measurements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    form_id INT NOT NULL,
    row_id VARCHAR(50),
    field_id VARCHAR(50),
    value VARCHAR(255),
    FOREIGN KEY (form_id) REFERENCES forms(id) ON DELETE CASCADE,
    INDEX(form_id)
);

-- Form images table
CREATE TABLE form_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    form_id INT NOT NULL,
    field_id VARCHAR(100),
    image_path VARCHAR(255),
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (form_id) REFERENCES forms(id) ON DELETE CASCADE,
    INDEX(form_id)
);
