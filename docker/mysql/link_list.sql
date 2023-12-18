CREATE TABLE `link_list` (
                             `id` int NOT NULL,
                             `name` varchar(100) NOT NULL,
                             `url` text NOT NULL,
                             `displayname` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


ALTER TABLE `link_list`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `link_list`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;
