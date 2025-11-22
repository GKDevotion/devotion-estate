/* 01-11-2025 */
ALTER TABLE `users` CHANGE `designtation_id` `designation_id` INT NULL DEFAULT '0' COMMENT 'reference for the designation table';
ALTER TABLE `properties` CHANGE `is_laxury_Property` `is_luxury_property` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes';

/* 05-11-2025 */
ALTER TABLE `properties` ADD `beds` INT NOT NULL DEFAULT '0' AFTER `publish`, ADD `baths` INT NOT NULL DEFAULT '0' AFTER `beds`;

/* 07-11-2025 */
ALTER TABLE `properties` CHANGE `purpose` `purpose` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: Sale, 1: Rent, 2: Land';
ALTER TABLE `properties` CHANGE `purpose` `purpose` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: All, 1: Sale, 2: Rent, 3: Land';
ALTER TABLE `properties` CHANGE `type` `type` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: All, 1: Residential, 2: Commercial';
ALTER TABLE `properties` ADD `payment_plan_id` INT NULL DEFAULT NULL COMMENT '0: NO, >0 = Reference for the payment plan table' AFTER `completed_date`;
ALTER TABLE `properties` ADD INDEX `payment_plan_IDX` (`payment_plan_id`);

/* 08-11-2025 */
ALTER TABLE `admins` ADD `login` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: Disabled, 1: Enabled' AFTER `status`;
ALTER TABLE `admins` ADD `company_id` INT NOT NULL AFTER `gender`;
ALTER TABLE properties ADD garage INT NOT NULL AFTER baths;
ALTER TABLE properties CHANGE garage garages INT NOT NULL DEFAULT '0';
ALTER TABLE properties CHANGE beds beds INT NOT NULL DEFAULT '0' COMMENT '0:studio ';

/* 10-11-2025 */
ALTER TABLE `properties` ADD `additional_features` TEXT NULL DEFAULT NULL COMMENT 'additional features' AFTER `description`;

/* 11-11-2025 */
ALTER TABLE `properties` ADD `parkings` INT NOT NULL DEFAULT '0' AFTER `baths`;
ALTER TABLE `properties` CHANGE `garages` `garages` INT NULL DEFAULT NULL;

/* 13-11-2025 */
ALTER TABLE `properties` ADD `building_name` VARCHAR(255) NOT NULL AFTER `name`;
ALTER TABLE `properties` ADD `staff_accomodation` VARCHAR(100) NOT NULL AFTER `maintenance_paid`;
ALTER TABLE `properties` ADD `plan_detail` VARCHAR(255) NULL DEFAULT NULL AFTER `payment_plan_id`;
ALTER TABLE `properties` ADD `quarter` INT NOT NULL DEFAULT '1' COMMENT '1:quarter1, 2:quarter2 , so that' AFTER `completed_date`;
ALTER TABLE `properties` CHANGE `quarter` `quarter` INT(11) NOT NULL DEFAULT '1' COMMENT '1:quarter1, 2:quarter2 ,3:quarter ';

ALTER TABLE `locations` ADD `slug` VARCHAR(255) NOT NULL AFTER `name`;
ALTER TABLE `properties` CHANGE `baths` `baths` INT NOT NULL;
ALTER TABLE `properties` CHANGE `quarter` `quarter` INT NOT NULL COMMENT '1:quarter1, 2:quarter2 ,3:quarter ';
ALTER TABLE `properties` CHANGE `quarter` `quarter` INT NULL DEFAULT NULL COMMENT '1:quarter1, 2:quarter2 ,3:quarter ';
ALTER TABLE `properties` CHANGE `baths` `baths` INT NULL DEFAULT NULL;
ALTER TABLE `properties` CHANGE `quarter` `quarter` VARCHAR(255) NULL DEFAULT NULL;

/* 14-11-2025 */
ALTER TABLE `properties` ADD `develop_by` VARCHAR(255) NOT NULL AFTER `location_id`;
ALTER TABLE `properties` CHANGE `develop_by` `develop_by` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

/* 15-11-2025 */
ALTER TABLE `properties` CHANGE `is_furnish` `is_furnish` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: UnFurnished, 1: Furnished,3:Semi-Furnished';

-- 17-11-2025
ALTER TABLE `property_contact` ADD `property_id` VARCHAR(10) NULL DEFAULT NULL AFTER `message`;

/* 19-11-2025 */
ALTER TABLE `users` ADD `image` VARCHAR(200) NOT NULL AFTER `designation_id`;

-- 21-11-2025
ALTER TABLE `brochures` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '0';
DROP TABLE IF EXISTS `banners`;
CREATE TABLE IF NOT EXISTS `banners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Disabled , 1:Enabled',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

TRUNCATE TABLE `banners`;

INSERT INTO `banners` (`id`, `name`, `sub_title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Find your dream home with Us', 'Affordable options, easy financing, expert advice every step of the way', '1763707083_692008cb41054.jpg', 1, '2025-11-21 05:08:03', '2025-11-21 05:08:03'),
(7, 'Find your perfect home', 'Discover homes built for modern living', '1763707194_6920093a4b2b4.jpg', 1, '2025-11-21 05:09:54', '2025-11-21 05:09:54'),
(8, 'Start your journey', 'Start your journey to finding the perfect property', '1763707239_692009675a2c7.jpg', 1, '2025-11-21 05:10:39', '2025-11-21 05:10:39');

DROP TABLE IF EXISTS `awards`;
CREATE TABLE IF NOT EXISTS `awards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Disabled , 1:Enabled',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 22-11-2025
ALTER TABLE `property_contact` ADD `property_name` VARCHAR(255) NOT NULL COMMENT 'Reference from the properties table' AFTER `property_id`;
ALTER TABLE `property_contact` ADD `is_read` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:is_read , 1:is_unread' AFTER `message`;
ALTER TABLE `property_contact` CHANGE `is_read` `is_read` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:Read , 1:UnRead';
ALTER TABLE `property_contact` CHANGE `is_read` `is_read` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:UnRead , 1:Read';
ALTER TABLE `notifications` CHANGE `description` `message` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'notification message';
ALTER TABLE `notifications` CHANGE `status` `is_read` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: Un-Read, 1: Read';