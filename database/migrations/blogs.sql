CREATE TABLE IF NOT EXISTS  `blogs` (
     `id` int NOT NULL AUTO_INCREMENT,
     `title` varchar(250) NOT NULL,
     `slug` varchar(250) NOT NULL,
     `body` TEXT NOT NULL,
     `file` TEXT,
     `created_at` datetime NOT NULL,
     `updated_at` datetime NOT NULL,
     PRIMARY KEY (`id`),
     UNIQUE KEY `blogs_slug_IDX` (`slug`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;