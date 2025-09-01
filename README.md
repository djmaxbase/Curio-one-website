Add this database file through the code or file in the repo:


```
CREATE DATABASE curioone;

USE curioone;

-- Users (inloggen)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Posts (blogartikelen)
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  author VARCHAR(50)
);
```
