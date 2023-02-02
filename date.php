<!-- Выбрать всех пользователей которые родились после 1991 года -->
SELECT * FROM `users` WHERE `birthday` > '1991-12-31';

<!-- Выбрать пользователей в формате (Фамилия И. - name, Город city, Возраст - количество полных лет - age) -->
SELECT CONCAT(`last_name`, ' ', SUBSTRING(`first_name`,1,1),'.') AS `name`,
`city`, (
    (YEAR(CURRENT_DATE) - YEAR(`birthday`)) -
    (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(`birthday`, '%m%d')) 
  ) AS `age`
FROM `users` WHERE `first_name` != '' AND `birthday` IS NOT NULL

<!-- - Выбрать пользователей в возрасте от 25 до 35 лет в формате (Фамилия И. - name, Город city, Возраст - age) -->
SELECT CONCAT(`last_name`, ' ', SUBSTRING(`first_name`,1,1),'.') AS `name`,
`city`, (
    (YEAR(CURRENT_DATE) - YEAR(`birthday`)) -
    (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(`birthday`, '%m%d')) 
  ) AS `age`
FROM `users`
WHERE `first_name` != '' AND `birthday` IS NOT NULL
HAVING `age` BETWEEN 25 AND 35;

<!-- - Дни рождения сотрудников список в формате (first_name, last_name, birthday формат "01 November"). Колонка день рождения должна содержать только день и месяц рождения, например 01 November. Не выводить сотрудников у которых не заполнено поле день рождения -->
SELECT `first_name`,`last_name`,CONCAT_WS(' ', DAY(`birthday`), MONTHNAME(`birthday`)) AS `birthday` FROM `users` WHERE `birthday` IS NOT NULL

<!-- - Дни рождения сотрудников в формате (first_name, last_name, birthday "01 November", age) и сколько лет исполнится -->
SELECT `first_name`,`last_name`,CONCAT_WS(' ', DAY(`birthday`), MONTHNAME(`birthday`)) AS `birthday`, (
    (YEAR(CURRENT_DATE) - YEAR(`birthday`)) -
    (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(`birthday`, '%m%d')) 
  ) + 1 AS `be years`
FROM `users` WHERE `first_name` != '' AND `birthday` IS NOT NULL;

<!-- - Месяц и количество дней рождений сотрудников в этом месяце (month, birthdays).  -->
SELECT MONTHNAME(`birthday`) AS `mounth`, COUNT(`birthday`) FROM `users` GROUP BY  `mounth` HAVING `mounth` IS NOT NULL;

<!-- -Только месяца в которых есть дни рождения -->
SELECT MONTHNAME(`birthday`) AS `mounth` FROM `users` GROUP BY  `mounth` HAVING `mounth` IS NOT NULL;

<!-- - Какой максимальный возраст сотрудника -->
SELECT MAX( (
    (YEAR(CURRENT_DATE) - YEAR(`birthday`)) -
    (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(`birthday`, '%m%d')) 
  )) AS `max_age`
FROM `users` WHERE `first_name` != '' AND `birthday` IS NOT NULL;

<!-- - Напишите запрос чтобы в таблице `department_user` не хранились дубли (дубль связки одного и того же пользователя с одним и тем же отделом) -->
SELECT DISTINCT * FROM `department_user`;

<!-- - Вывести одним запросом - максимальный, средний, минимальный возраст сотрудников. -->
SELECT MAX( (
    (YEAR(CURRENT_DATE) - YEAR(`birthday`)) -
    (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(`birthday`, '%m%d')) 
  )) AS `max_age`,
   ROUND(AVG( (
    (YEAR(CURRENT_DATE) - YEAR(`birthday`)) -
    (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(`birthday`, '%m%d')) 
  ))) AS `middle_age`,
   MIN( (
    (YEAR(CURRENT_DATE) - YEAR(`birthday`)) -
    (DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(`birthday`, '%m%d')) 
  )) AS `min_age`
  
  
FROM `users` WHERE `first_name` != '' AND `birthday` IS NOT NULL;

<!-- - Выведите все отделы и сотрудников которые в них работают в формате (Название отдела, Фамилия, Имя) отсортированных по названию отдела. Примечание выводить даже отделы в которых нет сотрудников -->

SELECT`departments`.`name` AS `Название отдела`, `users`.`last_name` AS `Фамилия`, `users`.`first_name` AS `Имя`  FROM `users` JOIN `department_user`
ON `users`.`id` = `department_user`.`user_id` 
RIGHT JOIN `departments`
ON `department_user`.`department_id` = `departments`.`id`
ORDER BY `departments`.`name`;

<!-- - Выведите отделы (только в которых есть сотрудники) и сотрудников которые в них работают в формате (Название отдела, Фамилия, Имя) отсортированных по названию отдела. Выводить только отделы в которых есть сотрудники. -->

SELECT `departments`.`name` AS `Название отдела`, `users`.`last_name` AS `Фамилия`, `users`.`first_name` AS `Имя`  FROM `users` JOIN `department_user`
ON `users`.`id` = `department_user`.`user_id` 
 JOIN `departments`
ON `department_user`.`department_id` = `departments`.`id`
ORDER BY `departments`.`name`;

<!-- - Вывести название отделы и количество сотрудников которые в них работают в формате (department_name, count). Только отделы в которых есть сотрудники -->

SELECT `departments`.`name` AS `department_name`, COUNT(`users`.`last_name`) AS `count` FROM `users` JOIN `department_user` ON `users`.`id` = `department_user`.`user_id` JOIN `departments` ON `department_user`.`department_id` = `departments`.`id` GROUP BY `departments`.`name` ORDER BY `departments`.`name`;