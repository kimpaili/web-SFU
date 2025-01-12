-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 12 2025 г., 10:07
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `animal_salon`
--

-- --------------------------------------------------------

--
-- Структура таблицы `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `service_id`, `appointment_date`, `appointment_time`, `created_at`) VALUES
(1, 2, 5, '2025-01-16', '13:00:00', '2025-01-12 08:17:30'),
(2, 2, 11, '2025-01-14', '12:30:00', '2025-01-12 08:20:47');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `content`, `created_at`) VALUES
(1, 2, 'ВААААУ!! у салона такой крутой и эстетичный сайт!! я бы поставила 5 звезд за такую работу)))))))', '2025-01-12 08:04:59');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `available_times` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `created_at`, `start_date`, `end_date`, `available_times`) VALUES
(5, 'Груминг собак', 'Для Ваших пушистых друзей доступны разнообразные виды стрижек!!', 2500.00, '2025-01-11 17:51:34', '2025-01-18', '2025-01-31', '10:00, 13:00, 16:00'),
(6, 'Массаж для животных', 'Расслабляющий массаж для улучшения самочувствия Вашего питомца.', 3000.00, '2025-01-11 17:56:25', '2025-01-18', '2025-01-31', '10:30, 14:00, 17:00'),
(7, 'Купание кошек', 'Деликатное купание с использованием гипоаллергенных шампуней.', 1500.00, '2025-01-11 17:56:25', '2025-01-20', '2025-02-05', '11:00, 14:30, 16:30'),
(8, 'Уход за лапами', 'Обрезка когтей, уход за подушечками лап и SPA.', 1200.00, '2025-01-11 17:56:25', '2025-01-15', '2025-01-25', '10:00, 13:30, 15:00'),
(9, 'Стрижка кошек', 'Элегантные стрижки для вашего пушистого друга.', 2200.00, '2025-01-11 17:56:25', '2025-01-22', '2025-02-01', '11:30, 14:00, 17:30'),
(10, 'Чистка зубов', 'Профессиональная чистка зубов для предотвращения заболеваний полости рта.', 1800.00, '2025-01-11 17:56:25', '2025-01-19', '2025-01-29', '12:00, 15:30, 16:00'),
(11, 'Дрессировка', 'Индивидуальные занятия для обучения питомца основным командам.', 5000.00, '2025-01-11 17:56:25', '2025-01-25', '2025-02-10', '10:00, 12:30, 15:00'),
(12, 'Гигиеническая стрижка', 'Поддержание опрятного внешнего вида питомца.', 2000.00, '2025-01-11 17:56:25', '2025-01-18', '2025-02-01', '10:30, 13:00, 16:30'),
(13, 'Уход за ушами', 'Глубокая чистка ушей и обработка.', 1000.00, '2025-01-11 17:56:25', '2025-01-20', '2025-01-30', '11:00, 14:30, 16:00'),
(14, 'Медицинский осмотр', 'Проверка здоровья питомца ветеринаром.', 3500.00, '2025-01-11 17:56:25', '2025-01-23', '2025-02-07', '09:30, 13:00, 17:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `gender`, `phone`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Полина', 'Гастюнина', '', '89620751488', 'gastuynina0570@gmail.com', '$2y$10$xF8acJI6zO9kI2IM6sjqkuU5wi1FUy3q6bb2iBBEGTYYr/bl1/j/m', 'admin', '2025-01-08 11:26:53'),
(2, 'Наська', 'Дроздова', 'Female', '89235213337', 'leska@gmail.com', '$2y$10$AGa5HRnM/g.B0y6U9kp5f.gEj1sTSEDazAWQuYXD6RPBGCrkFROtK', 'user', '2025-01-08 11:36:24'),
(3, 'Янка', 'Спасская', 'Female', '89444445566', 'yanka@gmail.com', '$2y$10$.JFEmNQTrgbXhEsQSCwTle1WrOnD033PxEhdCLlLSQGwfSLhC2PQG', 'user', '2025-01-12 08:59:04'),
(7, 'Ирка', 'Козырек', 'Female', '89620751414', 'ostrikozirek@gmail.com', '$2y$10$6uKgDOvqlIhVhOE1dLJYquyKnBoRqdJa17W7yd22UxcMBsbQB0ksi', 'user', '2025-01-12 09:03:33');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_id` (`service_id`,`appointment_date`,`appointment_time`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
