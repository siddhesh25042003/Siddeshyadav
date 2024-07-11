CREATE DATABASE dynamic_slider;
USE dynamic_slider;
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE images (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  title VARCHAR(100) NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

ALTER TABLE users MODIFY COLUMN name VARCHAR(50) DEFAULT NULL;
drop table images;

CREATE TABLE categories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL
);

CREATE TABLE slider_images (
  id INT PRIMARY KEY AUTO_INCREMENT,
  image_id INT NOT NULL,
  category_id INT NOT NULL,
  FOREIGN KEY (image_id) REFERENCES images(id),
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

ALTER TABLE images ADD COLUMN image_url VARCHAR(255);
ALTER TABLE images ADD COLUMN image_path VARCHAR(255) NOT NULL;