//25-10-25
ALTER TABLE `properties` CHANGE `publish` `publish` TINYINT(1) NULL DEFAULT '0' COMMENT '0: No, 1: Yes';
ALTER TABLE `properties` DROP `image`;
ALTER TABLE `properties` CHANGE `purpose` `purpose` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: Sale, 1: Rent';
ALTER TABLE `properties` CHANGE `feature_id` `feature_id` INT UNSIGNED NULL COMMENT 'Reference for the Property Feature table';
ALTER TABLE `properties` CHANGE `type_id` `type_id` INT UNSIGNED NULL COMMENT 'Reference for the Property Type Table';
ALTER TABLE `properties` CHANGE `name` `name` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Property name or Title';
ALTER TABLE `laravel_devotion_estate`.`properties` ADD INDEX `feature_IDX` (`feature_id`);
ALTER TABLE `laravel_devotion_estate`.`properties` ADD INDEX `type_IDX` (`type_id`);
ALTER TABLE `properties` CHANGE `type` `type` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: Residential, 1: Commercial';
ALTER TABLE `properties` CHANGE `slug` `slug` VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;
ALTER TABLE `properties` CHANGE `area` `area` DECIMAL(20) NULL DEFAULT NULL;
ALTER TABLE `properties` CHANGE `address` `location_id` INT NULL COMMENT 'Reference for the location table' AFTER `admin_id`;
ALTER TABLE `properties` ADD `h1_tag` VARCHAR(250) NOT NULL AFTER `slug`, ADD `seo_title` VARCHAR(250) NOT NULL AFTER `h1_tag`, ADD `meta_desccription` TEXT NOT NULL AFTER `seo_title`, ADD `description` LONGTEXT NOT NULL AFTER `meta_desccription`;
ALTER TABLE `properties` ADD `sub_type_id` INT NOT NULL COMMENT 'Reference for the property type table' AFTER `type`;
ALTER TABLE `laravel_devotion_estate`.`properties` DROP INDEX `type_IDX`, ADD INDEX `type_IDX` (`type_id`, `sub_type_id`) USING BTREE;
ALTER TABLE `properties` ADD `is_furnish` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes' AFTER `count`;
ALTER TABLE `properties` ADD `is_complete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: Other Select, 1: Ready, 2: Secondary, 3: Off Plan' AFTER `is_furnish`, ADD `is_occupancy` TINYINT(1) NULL DEFAULT '0' COMMENT '0: Other Select, 1: Vacant, 2: Rented' AFTER `is_complete`;
ALTER TABLE `laravel_devotion_estate`.`properties` ADD INDEX `purpose_IDX` (`purpose`, `is_complete`, `is_occupancy`);
ALTER TABLE `properties` ADD `ownership_status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:Freehold, 1: Leasehold' AFTER `is_occupancy`;
ALTER TABLE `laravel_devotion_estate`.`properties` ADD INDEX `owner_status_IDX` (`ownership_status`);
ALTER TABLE `properties` ADD `is_finance_available` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: Not Sure, 1: Yes, 2: No' AFTER `ownership_status`, ADD `finance_name` VARCHAR(100) NULL DEFAULT NULL AFTER `is_finance_available`;
ALTER TABLE `laravel_devotion_estate`.`properties` ADD INDEX `finance_IDX` (`is_finance_available`);
ALTER TABLE `properties` ADD `rera_number` VARCHAR(25) NOT NULL AFTER `finance_name`, ADD `permit_number` VARCHAR(25) NOT NULL AFTER `rera_number`;
ALTER TABLE `users` CHANGE `type` `type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1: User, 2: Owner, 3: Client, 4: Agent';
ALTER TABLE `properties` ADD `agent_id` INT NOT NULL COMMENT 'Reference For the User Table' AFTER `location_id`;
ALTER TABLE `laravel_devotion_estate`.`properties` DROP INDEX `admin_id`, ADD INDEX `admin_id` (`admin_id`, `agent_id`) USING BTREE;
ALTER TABLE `properties` ADD `completed_date` DATE NULL DEFAULT NULL COMMENT 'once complete status off plan then set completed date' AFTER `ownership_status`;
ALTER TABLE `properties` ADD `unique_id` VARCHAR(10) NOT NULL COMMENT 'Property Unique ID' AFTER `id`;
ALTER TABLE `properties` DROP `type_id`
ALTER TABLE `properties` DROP `feature_id`
ALTER TABLE `properties` ADD `rent_frequency` TINYINT NOT NULL DEFAULT '0' COMMENT '0: None, 1: Daily, 2: Weekly, 3: Monthly, 4: Yearly' AFTER `permit_number`, ADD `rent_contract_period` TINYINT NOT NULL DEFAULT '0' AFTER `rent_frequency`, ADD `rent_notice_period` VARCHAR(3) NOT NULL DEFAULT '0' AFTER `rent_contract_period`, ADD `maintenance_fees` DECIMAL(10,2) NOT NULL DEFAULT '0' AFTER `rent_notice_period`, ADD `maintenance_paid` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: None, 1: Landlord, 2: Tenant' AFTER `maintenance_fees`;
ALTER TABLE `properties` ADD `off_plan_sale_type` TINYINT(1) NULL DEFAULT '0' COMMENT '0: None, 1: Initial Sale, 2: ReSale' AFTER `ownership_status`;
ALTER TABLE `properties` CHANGE `meta_desccription` `meta_description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;

Create Table "property_feature_map"
Create Table "property_image_map"

//28-10-2025
ALTER TABLE `properties` ADD `is_set_new_property` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes' AFTER `updated_at`, ADD `is_featured_property` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes' AFTER `is_set_new_property`, ADD `is_laxury_Property` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes' AFTER `is_featured_property`;
ALTER TABLE `properties` ADD `is_hot_offer` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes' AFTER `is_laxury_Property`;