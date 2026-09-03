CREATE DATABASE IF NOT EXISTS helpdesk_ticket;

USE helpdesk_ticket;

CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    category ENUM('Hardware', 'Software', 'Network', 'Others') NOT NULL,
    description TEXT NOT NULL,
    status ENUM('Open', 'In Progress', 'Closed') NOT NULL DEFAULT 'Open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);