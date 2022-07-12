CREATE TABLE IF NOT EXISTS `users` (
     `id` int NOT NULL AUTO_INCREMENT,
     `name` varchar(250) NOT NULL,
     `email` varchar(250) NOT NULL,
     `password` varchar(250) NOT NULL,
     `remember_token` varchar(250),
     `remember_identifier` varchar(250),
     `created_at` datetime,
     `updated_at` datetime,
     PRIMARY KEY (`id`),
     UNIQUE KEY `users_email_IDX` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;