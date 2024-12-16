CREATE DATABASE IF NOT EXISTS dolphin_crm;
USE dolphin_crm;

-- Users table
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Contacts table
CREATE TABLE Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(10),
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    company VARCHAR(255),
    type VARCHAR(50) NOT NULL,
    assigned_to INT,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES Users(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

-- Notes table
CREATE TABLE Notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES Contacts(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

-- Default admin user
INSERT INTO Users (firstname, lastname, password, email, role)
VALUES (
    'Admin',
    'User',
    '\$2y\$10\$8Z.YM/9OJ3xwgHwV.mwmkOYz6TtxMQJqhN9V3UF9T3HJGQZsuHhJi',
    'admin@project2.com',
    'admin'
);