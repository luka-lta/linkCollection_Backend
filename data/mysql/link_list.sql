CREATE TABLE `link_list` (
                             `link_id` int NOT NULL,
                             `page_id` int DEFAULT NULL,
                             `name` varchar(100) NOT NULL,
                             `url` text NOT NULL,
                             `displayName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `link_list`
    ADD PRIMARY KEY (`link_id`),
    ADD KEY `page_id` (`page_id`);

ALTER TABLE `link_list`
    MODIFY `link_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `link_list`
    ADD CONSTRAINT `page_id` FOREIGN KEY (`page_id`) REFERENCES `link_page` (`page_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;
