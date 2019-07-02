CREATE DATABASE doingsdone
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE projects
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    user_id       INT,
    projects_name CHAR(255) NOT NULL
);

CREATE TABLE task
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    projects_id   INT,
    data_task     DATE,
    status        INT,
    task_name     CHAR(255) NOT NULL,
    task_description CHAR(255),
    file          CHAR(255),
    file_name     CHAR(255),
    lifetime      DATE
);

CREATE TABLE users
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    date_reg  DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_name CHAR(64) NOT NULL UNIQUE,
    email     CHAR(128) NOT NULL UNIQUE,
    password  CHAR(255)
);

CREATE FULLTEXT INDEX task_ft_search
ON task(task_name);
CREATE INDEX projects ON projects(projects_name);
CREATE INDEX task ON task(task_name);

