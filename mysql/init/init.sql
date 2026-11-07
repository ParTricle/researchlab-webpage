-- Создание базы данных и таблиц для researchlab

CREATE DATABASE IF NOT EXISTS researchlab;
USE researchlab;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица постов
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    author_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id)
);

-- Добавляем тестового пользователя
INSERT INTO users (username, password, email) VALUES 
('admin', 'admin123', 'admin@example.com'),
('user1', 'password123', 'user1@example.com');

-- Добавляем тестовые посты
INSERT INTO posts (title, content, author_id) VALUES 
('Первый пост', 'Это тестовый пост для проверки работы сайта', 1),
('Второй пост', 'Еще один тестовый пост', 2);
