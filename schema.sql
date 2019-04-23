CREATE DATABASE doingsdone;

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
    user_id       INT,
    projects_id   INT,
    data_task     DATETIME,
    status        INT,
    task_name     CHAR(255) NOT NULL,
    file          CHAR(255),
    lifetime      DATETIME
);

CREATE TABLE users
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    date_reg  DATETIME,
    user_name CHAR(64) NOT NULL UNIQUE,
    email     CHAR(128) NOT NULL UNIQUE,
    password  CHAR(64)
);

CREATE INDEX projects ON projects(projects_name);
CREATE INDEX task ON task(task_name);
