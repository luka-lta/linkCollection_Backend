CREATE TABLE `link_list` (
                             `linkId` int NOT NULL,
                             `name` varchar(100) NOT NULL,
                             `url` text NOT NULL,
                             `displayName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `link_list`
    ADD PRIMARY KEY (`linkId`);

ALTER TABLE `link_list`
    MODIFY `linkId` int NOT NULL AUTO_INCREMENT;
