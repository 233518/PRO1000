CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
	first_name VARCHAR(50),
	last_name VARCHAR(50),
	email VARCHAR(100),
    admin TINYINT(1)
);