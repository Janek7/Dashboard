CREATE TABLE users
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    register_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    verified BOOLEAN DEFAULT FALSE,
    verified_by INTEGER,
    verify_date TIMESTAMP,
    last_page VARCHAR(50),
    last_activity TIMESTAMP
);


//PERMISSION / ROLE TABLES

CREATE TABLE roles
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE perms
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    `desc` VARCHAR(100) NOT NULL
);

CREATE TABLE perm_role_connections
(
    perm_id INT REFERENCES perms(id) ON DELETE CASCADE,
  role_id INT REFERENCES roles(id) ON DELETE CASCADE,
  PRIMARY KEY (perm_id, role_id)
);

CREATE TABLE user_perms
(
    perm_id INT REFERENCES perms(id) ON DELETE CASCADE,
  user_id INT REFERENCES users(id) ON DELETE CASCADE,
  PRIMARY KEY (perm_id, user_id)
);

CREATE TABLE user_roles
(
    role_id INT REFERENCES roles(id) ON DELETE CASCADE,
  user_id INT REFERENCES users(id) ON DELETE CASCADE

);


//CODING TABLES

CREATE TABLE coding_projects
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    start_date TIMESTAMP NOT NULL,
    git_client VARCHAR(20) NOT NULL,
    git_repo VARCHAR(200)
);

CREATE TABLE coding_project_descriptions
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT REFERENCES coding_projects(id) ON DELETE CASCADE,
    text VARCHAR(500) NOT NULL
);

CREATE TABLE coding_languages
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL
);

CREATE TABLE coding_project_languages
(
    language_id INT REFERENCES coding_languages(id) ON DELETE CASCADE,
  project_id INT REFERENCES coding_projects(id) ON DELETE CASCADE,
  PRIMARY KEY(language_id, project_id)
);