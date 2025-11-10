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
