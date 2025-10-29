CREATE DATABASE IF NOT EXISTS `ancapcybernews-db`;

USE `ancapcybernews-db`;

CREATE TABLE users (
                       id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(100) NOT NULL UNIQUE,
                       email VARCHAR(100) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);