CREATE TABLE `link_page` (
                             `page_id` int NOT NULL,
                             `owner_id` int DEFAULT NULL,
                             `theme` enum('default','dark','purple','') NOT NULL,
                             `url_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `link_page`
    ADD PRIMARY KEY (`page_id`),
    ADD KEY `owner` (`owner_id`);

ALTER TABLE `link_page`
    MODIFY `page_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `link_page`
    ADD CONSTRAINT `owner` FOREIGN KEY (`owner_id`) REFERENCES `link_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
