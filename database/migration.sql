CREATE TABLE IF NOT EXISTS logs (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    entity      VARCHAR(50)  NOT NULL,
    action      VARCHAR(50)  NOT NULL,
    status      VARCHAR(20)  NOT NULL,
    responsible VARCHAR(11)  NULL,
    details     TEXT         NULL,
    created_at  DATETIME     NOT NULL,
    deleted_at  DATETIME     NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;