CREATE TABLE `link_user` (
                             `user_id` int NOT NULL,
                             `username` varchar(250) NOT NULL,
                             `email` varchar(250) NOT NULL,
                             `password_hash` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `link_user`
    ADD PRIMARY KEY (`user_id`);

ALTER TABLE `link_user`
    MODIFY `user_id` int NOT NULL AUTO_INCREMENT;
