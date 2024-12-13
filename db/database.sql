CREATE DATABASE IF NOT EXISTS pension;
USE pension;

CREATE TABLE IF NOT EXISTS documents (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fio VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    pension_date DATE NOT NULL,
    dismissal_date DATE,
    work_experience INT NOT NULL,
    transfer_date DATE NOT NULL,
    transfer_amount DECIMAL(10, 2) NOT NULL,
    order_number VARCHAR(255) NOT NULL,
    named_transfer_date DATE NOT NULL,
    named_transfer_amount DECIMAL(10, 2) NOT NULL,
    username VARCHAR(255) NOT NULL,
    record_date DATE NOT NULL,
    record_time TIME NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Пример вставки данных в таблицу documents
INSERT INTO documents (fio, dob, pension_date, dismissal_date, work_experience, transfer_date, transfer_amount, order_number, named_transfer_date, named_transfer_amount, username, record_date, record_time)
VALUES 
('Иванов Иван Иванович', '1980-01-01', '2045-01-01', '2025-01-01', 20, '2023-01-01', 10000.00, '12345', '2023-01-01', 5000.00, 'admin', '2023-01-01', '12:00:00');