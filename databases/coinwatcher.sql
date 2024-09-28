-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-09-2024 a las 23:57:12
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `coinwatcher`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `co_obligations`
--

CREATE TABLE `co_obligations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `paid` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `co_operations`
--

CREATE TABLE `co_operations` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT 'Ocio, Imprevisto, Obligacion, indefinido',
  `value` varchar(255) NOT NULL,
  `user_id` bigint(11) NOT NULL,
  `wrote` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `username_attempt` varchar(255) COLLATE utf8_bin NOT NULL,
  `success` int(11) NOT NULL,
  `ip` varchar(255) COLLATE utf8_bin NOT NULL,
  `message` text COLLATE utf8_bin DEFAULT NULL,
  `date` datetime NOT NULL,
  `extra_data` longtext COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `user_id`, `username_attempt`, `success`, `ip`, `message`, `date`, `extra_data`) VALUES
(1, 1, 'root', 1, '::1', '', '2021-06-28 08:43:58', '{\"dimensions\":{\"w\":1920,\"h\":1080},\"userAgent\":\"Mozilla\\/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/91.0.4472.114 Safari\\/537.36\"}'),
(2, 4, 'le7els10@gmail.com', 1, '::1', '', '2024-09-28 15:54:40', '{\"dimensions\":{\"w\":null,\"h\":null},\"userAgent\":\"Mozilla\\/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/129.0.0.0 Safari\\/537.36\"}'),
(3, 4, 'le7els10@gmail.com', 1, '::1', '', '2024-09-28 15:55:09', '{\"dimensions\":{\"w\":null,\"h\":null},\"userAgent\":\"Mozilla\\/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/129.0.0.0 Safari\\/537.36\"}'),
(4, 4, 'le7els10@gmail.com', 1, '::1', '', '2024-09-28 16:03:52', '{\"dimensions\":{\"w\":null,\"h\":null},\"userAgent\":\"Mozilla\\/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/129.0.0.0 Safari\\/537.36\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message_from` bigint(20) NOT NULL,
  `message_to` bigint(20) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `subject` text COLLATE utf8_bin NOT NULL,
  `message` text COLLATE utf8_bin DEFAULT NULL,
  `attachment` text COLLATE utf8_bin DEFAULT NULL,
  `readed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages_responses`
--

CREATE TABLE `messages_responses` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `message_from` bigint(20) NOT NULL,
  `message` text COLLATE utf8_bin DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `attachment` text COLLATE utf8_bin DEFAULT NULL,
  `readed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pcsphp_app_config`
--

CREATE TABLE `pcsphp_app_config` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` longtext COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `pcsphp_app_config`
--

INSERT INTO `pcsphp_app_config` (`id`, `name`, `value`) VALUES
(1, 'backgrounds', '[\"statics\\/login-and-recovery\\/images\\/login\\/bg1.jpg\",\"statics\\/login-and-recovery\\/images\\/login\\/bg2.jpg\",\"statics\\/login-and-recovery\\/images\\/login\\/bg3.jpg\",\"statics\\/login-and-recovery\\/images\\/login\\/bg4.jpg\",\"statics\\/login-and-recovery\\/images\\/login\\/bg5.jpg\"]'),
(2, 'description', 'Descripción de la página.'),
(3, 'favicon', 'statics/images/favicon.png'),
(4, 'favicon-back', 'statics/images/favicon-back.png'),
(5, 'keywords', '[\"A\",\"B\",\"C D\"]'),
(6, 'logo', 'statics/images/logo.png'),
(7, 'logo-login', 'statics/images/logo-login.png'),
(8, 'logo-mailing', 'statics/images/logo-mailing.png'),
(9, 'logo-sidebar-bottom', 'statics/images/logo-sidebar-bottom.png'),
(10, 'logo-sidebar-top', 'statics/images/logo-sidebar-top.png'),
(11, 'mail', '{\"auto_tls\":true,\"protocol\":\"ssl\",\"host\":\"smtp.zoho.com\",\"auth\":true,\"user\":\"correo@correo.com\",\"password\":\"123456\",\"port\":465}'),
(12, 'meta_theme_color', '#2692D0'),
(13, 'open_graph_image', 'statics/images/open_graph.jpg'),
(14, 'osTicketAPI', 'http://ayuda.tejidodigital.com'),
(15, 'osTicketAPIKey', '93F0F2E3DCD3B79A686A3157620CFF24'),
(16, 'owner', 'Sample Inc.'),
(17, 'title_app', 'Nombre Plataforma');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pcsphp_blackboard_news_messages`
--

CREATE TABLE `pcsphp_blackboard_news_messages` (
  `id` int(11) NOT NULL,
  `author` bigint(20) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `text` longtext COLLATE utf8_bin NOT NULL,
  `type` bigint(20) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pcsphp_dynamic_images`
--

CREATE TABLE `pcsphp_dynamic_images` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `link` text COLLATE utf8_bin DEFAULT NULL,
  `image` text COLLATE utf8_bin NOT NULL,
  `meta` longtext COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pcsphp_recovery_password`
--

CREATE TABLE `pcsphp_recovery_password` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `code` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `expired` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pcsphp_tickets_log`
--

CREATE TABLE `pcsphp_tickets_log` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `message` text COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `information` longtext COLLATE utf8_bin DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pcsphp_tokens`
--

CREATE TABLE `pcsphp_tokens` (
  `id` int(11) NOT NULL,
  `token` text COLLATE utf8_bin NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pcsphp_users`
--

CREATE TABLE `pcsphp_users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(255) COLLATE utf8_bin NOT NULL,
  `secondname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `first_lastname` varchar(255) COLLATE utf8_bin NOT NULL,
  `second_lastname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `meta` text COLLATE utf8_bin DEFAULT NULL,
  `type` int(3) NOT NULL,
  `status` int(3) NOT NULL DEFAULT 1,
  `failed_attempts` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `pcsphp_users`
--

INSERT INTO `pcsphp_users` (`id`, `username`, `password`, `firstname`, `secondname`, `first_lastname`, `second_lastname`, `email`, `meta`, `type`, `status`, `failed_attempts`, `created_at`, `modified_at`) VALUES
(1, 'root', '$2y$10$7zoL4vBsF3FZ/73jSUrrD.yjYExwn3ZTIp4TsGGJr0xEaMQCmDBEK', 'Administrador', '', 'Root', '', 'vicsenmorantes@tejidodigital.com', '', 0, 1, 0, '2018-06-20 14:11:54', '2019-01-21 05:19:37'),
(2, 'admin', '$2y$10$hdmge3MNnbOcD5hp2OwCtuC/HzqKwkgibWGKc0hqpfn55mfRqDCfu', 'Lacey', 'Russo', 'Young', 'Curry', 'jonys@mailinator.net', NULL, 1, 1, 0, '2019-10-08 11:07:37', '2019-10-08 11:07:37'),
(3, 'general', '$2y$10$sIZ0qYha8A/6xIv2tsatL.sDPXlkmLMZt.QqUPvNZxnlcD4cgYiuW', 'Diana', 'Donovan', 'Bean', 'Buckley', 'wynim@mailinator.com', 'null', 2, 1, 0, '2019-10-08 11:07:45', '2019-10-08 11:08:01'),
(4, 'le7els10@gmail.com', '$2y$10$syFxiDinicKebrDKxML68u.ETTLaPEopR1nuCOyFPvo/rSp5EEwdW', 'Juan', '', 'Nuñez', '', 'le7els10@gmail.com', NULL, 2, 1, 0, '2024-09-28 15:54:40', '2024-09-28 15:54:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pcsphp_user_problems`
--

CREATE TABLE `pcsphp_user_problems` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `code` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `expired` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `time_on_platform`
--

CREATE TABLE `time_on_platform` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `minutes` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `co_obligations`
--
ALTER TABLE `co_obligations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `co_operations`
--
ALTER TABLE `co_operations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_from` (`message_from`),
  ADD KEY `message_to` (`message_to`);

--
-- Indices de la tabla `messages_responses`
--
ALTER TABLE `messages_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_from` (`message_from`),
  ADD KEY `message_id` (`message_id`);

--
-- Indices de la tabla `pcsphp_app_config`
--
ALTER TABLE `pcsphp_app_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `pcsphp_blackboard_news_messages`
--
ALTER TABLE `pcsphp_blackboard_news_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`);

--
-- Indices de la tabla `pcsphp_dynamic_images`
--
ALTER TABLE `pcsphp_dynamic_images`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pcsphp_recovery_password`
--
ALTER TABLE `pcsphp_recovery_password`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pcsphp_tickets_log`
--
ALTER TABLE `pcsphp_tickets_log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pcsphp_tokens`
--
ALTER TABLE `pcsphp_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pcsphp_users`
--
ALTER TABLE `pcsphp_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pcsphp_user_problems`
--
ALTER TABLE `pcsphp_user_problems`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `time_on_platform`
--
ALTER TABLE `time_on_platform`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `co_obligations`
--
ALTER TABLE `co_obligations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `co_operations`
--
ALTER TABLE `co_operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `messages_responses`
--
ALTER TABLE `messages_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pcsphp_app_config`
--
ALTER TABLE `pcsphp_app_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `pcsphp_blackboard_news_messages`
--
ALTER TABLE `pcsphp_blackboard_news_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pcsphp_dynamic_images`
--
ALTER TABLE `pcsphp_dynamic_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pcsphp_recovery_password`
--
ALTER TABLE `pcsphp_recovery_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pcsphp_tickets_log`
--
ALTER TABLE `pcsphp_tickets_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pcsphp_tokens`
--
ALTER TABLE `pcsphp_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pcsphp_users`
--
ALTER TABLE `pcsphp_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pcsphp_user_problems`
--
ALTER TABLE `pcsphp_user_problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `time_on_platform`
--
ALTER TABLE `time_on_platform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `co_operations`
--
ALTER TABLE `co_operations`
  ADD CONSTRAINT `co_operations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pcsphp_users` (`id`);

--
-- Filtros para la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pcsphp_users` (`id`);

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`message_from`) REFERENCES `pcsphp_users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`message_to`) REFERENCES `pcsphp_users` (`id`);

--
-- Filtros para la tabla `messages_responses`
--
ALTER TABLE `messages_responses`
  ADD CONSTRAINT `messages_responses_ibfk_1` FOREIGN KEY (`message_from`) REFERENCES `pcsphp_users` (`id`),
  ADD CONSTRAINT `messages_responses_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`);

--
-- Filtros para la tabla `pcsphp_blackboard_news_messages`
--
ALTER TABLE `pcsphp_blackboard_news_messages`
  ADD CONSTRAINT `pcsphp_blackboard_news_messages_ibfk_1` FOREIGN KEY (`author`) REFERENCES `pcsphp_users` (`id`);

--
-- Filtros para la tabla `time_on_platform`
--
ALTER TABLE `time_on_platform`
  ADD CONSTRAINT `time_on_platform_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pcsphp_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
