/* 01-11-2025 */
ALTER TABLE `users` CHANGE `designtation_id` `designation_id` INT NULL DEFAULT '0' COMMENT 'reference for the designation table';
ALTER TABLE `properties` CHANGE `is_laxury_Property` `is_luxury_property` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes';

/* 05-11-2025 */
ALTER TABLE `properties` ADD `beds` INT NOT NULL DEFAULT '0' AFTER `publish`, ADD `baths` INT NOT NULL DEFAULT '0' AFTER `beds`;