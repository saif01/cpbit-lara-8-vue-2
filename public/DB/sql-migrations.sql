-- users

INSERT INTO `cpbit_8`.`users`(`id`, `login`, `user`, `admin`, `name`, `image`, `department`, `office_id`, `office_contact`, `personal_contact`, `office_email`, `personal_email`, `office`, `business_unit`, `nid`, `manager_id`, `manager_emails`, `verify`, `verify_by`, `status`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `login`, `user`, `admin`, `name`, `image`,  `designation`, `office_id`, `office_contact`, `personal_contact`, `office_email`, `personal_email`, `office`, `business_unit`, `nid`, `manager_id`, `manager_emails`, `verify`, `verify_by`, `status`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`users`

UPDATE `users` SET `image`= REPLACE(`image`, 'images/users/original/', '')

UPDATE `users` SET `zone_office` = `office`
UPDATE `users` SET `zone_office`= "Account and Finance"  WHERE `zone_office`= "Account & Finance" 
UPDATE `users` SET `zone_office`= "TAX and VAT" WHERE `zone_office`= "TAX & VAT"
UPDATE `users` SET `zone_office`= "Valuka 14 and 15 Farm" WHERE `zone_office`= "Valuka 14 & 15 Farm"; 



-- roles

INSERT INTO `cpbit_8`.`roles`(`id`, `name`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`roles`

UPDATE `cpbit_8`.`roles` SET `status`= 1


-- role_user

INSERT INTO `cpbit_8`.`role_user`(`id`, `role_id`, `user_id`, `created_at`, `updated_at`) SELECT `id`, `role_id`, `user_id`, `created_at`, `updated_at` FROM `cpbit`.`role_user`



-- sms_operations
INSERT INTO `cpbit_8`.`sms_operations`(`id`, `name`, `code`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `code`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`iservice_operations`

-- sms_operation_user
INSERT INTO `cpbit_8`.`sms_operation_user`(`id`, `sms_operation_id`, `user_id`, `created_at`, `updated_at`) SELECT `id`, `iservice_operation_id`, `user_id`, `created_at`, `updated_at` FROM `cpbit`.`iservice_operation_user`