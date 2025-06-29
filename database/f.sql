-- Active: 1746959382050@@127.0.0.1@3306
ALTER DATABASE truhlik_project CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE product_variants CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE products CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE colors CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE categories CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
