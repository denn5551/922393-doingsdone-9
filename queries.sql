# Добавляем пользователей

INSERT INTO users (user_name, email, password)
VALUES ('Андрей', 'andro@ya.ru', '$2y$10$3yBoZts1vSzg5tUUksSl3eMndL8HpiLUC3cQ1uvHUxGSubW1fbCEO'); # id=9

INSERT INTO users (user_name, email, password)
VALUES ('Максим', 'max@ya.ru', '$2y$10$qtMlm8QvaC8AjSU4rb95cO4ff/nv3vy4M0GL75k34N6GIxlob4/La'); # id=10

# Добавляем проекты

INSERT INTO projects (user_id, projects_name)
VALUES (9,'Входящие');

INSERT INTO projects (user_id, projects_name)
VALUES (9,'Учеба');

INSERT INTO projects (user_id, projects_name)
VALUES (9,'Работа');

INSERT INTO projects (user_id, projects_name)
VALUES (10,'Домашние дела');

INSERT INTO projects (user_id, projects_name)
VALUES (10,'Авто');


# Добавляем задачи

INSERT INTO task (projects_id, status, task_name, lifetime)
VALUES  (3,0,'Собеседование в IT компании','2019-04-23');

INSERT INTO task (projects_id, status, task_name, lifetime)
VALUES  (3,0,'Выполнить тестовое задание','2019-04-23');

INSERT INTO task (projects_id, status, task_name, lifetime)
VALUES  (2,1,'Сделать задание первого раздела','2019-04-23');

INSERT INTO task (projects_id, status, task_name, lifetime)
VALUES  (1,0,'Встреча с другом','2019-04-23');

INSERT INTO task (projects_id, status, task_name, lifetime)
VALUES  (4,0,'Купить корм для кота','2019-04-23');

INSERT INTO task (projects_id, status, task_name, lifetime)
VALUES  (4,0,'Заказать пиццу','2019-04-23');


# получить список из всех проектов для одного пользователя
SELECT projects_name FROM projects where user_id = 9;

# Объедините проекты с задачами, чтобы посчитать количество задач в каждом проекте и в дальнейшем выводить эту цифру рядом с именем проекта;

SELECT p.id, projects_name FROM projects p
JOIN task t
ON p.id = t.projects_id;

# Считаем количество задач
SELECT p.id, projects_name, COUNT(projects_name) FROM projects p
join task t
ON  p.id = t.projects_id
GROUP BY projects_name;

#получить список из всех задач для одного проекта
SELECT task_name FROM task WHERE projects_id = 3;

#получить списка из всех задач у текущего пользователя
SELECT projects_id, task_name  FROM task t
JOIN projects p
ON p.id = t.projects_id AND user_id = 9;

#пометить задачу как выполненную;
UPDATE task SET status = 1
WHERE id = 9;

# обновить название задачи по её идентификатору
UPDATE task SET task_name = 'Новая задача'
WHERE id = 9;

# Полнотекстовой поиск. Создание индекса.
CREATE FULLTEXT INDEX index_task ON task (task_name)