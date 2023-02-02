<!-- Выбрать всех пользователей -->
SELECT * FROM `users`;

<!-- Добавление нового сотрудника -->
INSERT INTO `users`(`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `phone`, `gender`, `birthday`, `city`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14]);

<!-- Выбрать первых двух пользователей -->
SELECT * FROM `users` limit 2;

<!-- Выбрать двух пользователей со смещением 2 -->

SELECT * FROM `users` limit 2,2;

<!--  Выбрать всех пользователей в формате (Фамилия, Имя, Телефон) -->
SELECT `last_name`, `first_name`, `phone` FROM `users` ORDER BY `last_name`;

<!-- - Выбрать всех пользователей в формате (Город, Фамилия, Имя, Телефон) с сортировкой, сначала по городу потом по фамилии -->
SELECT `city`, `last_name`, `first_name`, `phone` FROM `users` ORDER BY `city`, `last_name`;

<!-- - Выбрать всех пользователей в формате (Фамилия И., Телефон, Город) с сортировкой по фамилии. Колонку c "Фамилия И." назвать name -->
SELECT CONCAT(`last_name`, ' ', SUBSTRING(`first_name`,1,1),'.') AS `name` FROM `users` ORDER BY `last_name`;

<!-- - Тоже самое что и в предыдущем но чтобы в поле Name не выводилась точка, если у пользователя не указано имя -->
SELECT CONCAT(`last_name`, ' ', SUBSTRING(`first_name`,1,1),IF(`first_name` = '', '','.')) AS `name` FROM `users` ORDER BY `last_name`;

<!-- - Выбрать всех пользователей из города челябинск -->
SELECT * FROM `users` WHERE `city` = 'Челябинск';

<!-- - Выбрать всех пользователей из городов Москва и Миасс -->
SELECT * FROM `users` WHERE `city` = 'Москва' OR `city` = 'Миасс';

<!--  Выбрать всех девущек (gender==2) -->
SELECT * FROM `users` WHERE `gender` = 2;

<!--  Выбрать всех девушек (gender==2) из городов Москва и Миасс -->
SELECT * FROM `users` WHERE `gender` = 2 AND `city` = 'Москва' OR `city` = 'Миасс';

<!-- - Выбрать всех пользователей из городов Москва, Миасс, Екатеринбург -->
SELECT * FROM `users` WHERE `city` = 'Москва' OR `city` = 'Челябинск' OR `city` = 'Екатеринбург';

<!-- Сколько всего пользователей -->
SELECT COUNT(*) FROM `users`;

<!--Сколько всего городов в которых есть пользователи-->
SELECT COUNT(`city`) FROM `users` WHERE `created_at` IS NOT NULL;


<!-- Вывести название городов в которых есть пользователи-->
SELECT `city` FROM `users` WHERE `created_at` IS NOT NULL;

<!-- Сколько пользователей в каждом городе в формате (City, Count)-->
SELECT `city` , COUNT(`created_at`) AS `number_of_users` FROM `users` WHERE `created_at` IS NOT NULL GROUP BY `city`;

<!--Сколько пользователей в каждом городе в формате (City, Count) отсортированных по количеству (сначала города с максимальным количество пользователей)-->
SELECT `city`, COUNT(`created_at`) AS `Count` FROM `users` WHERE `created_at` IS NOT NULL GROUP BY `city` ORDER BY `Count` DESC;

<!-- - Вывести для городов где большее 1 сотрудника - количество пользователей в городе в формате (City, Count) отсортированных по количеству (сначала города с максимальным количество пользователей) -->
SELECT `city`, COUNT(`created_at`) AS `number_users` FROM `users` GROUP BY `city` HAVING COUNT(`city`) > 1 ORDER BY COUNT(`created_at`) DESC

<!-- - Вывести всех пользователей у которых почта на Яндексе -->
SELECT * FROM `users` WHERE `username` LIKE '%yandex%';

<!--Вывести всех пользователей у которых не заполнено поле телефон-->
SELECT * FROM `users` WHERE `phone` IS NULL OR `phone` = '';
