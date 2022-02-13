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







-- application_categories
INSERT INTO `cpbit_8`.`application_categories`(`id`, `name`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`application_categories`

-- application_subcategories
INSERT INTO `cpbit_8`.`application_subcategories`(`id`, `cat_id`, `name`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `cat_id`, `name`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`application_subcategories`


-- category update by id

-- Win Food = SmartSoft_Food
-- Smart_iLab = SmartSoft_iLab

UPDATE `application_complains` SET `category`='6' WHERE `category` = 'SmartSoft';
UPDATE `application_complains` SET `category`='7' WHERE `category` = 'SmartSoft_Feed';
UPDATE `application_complains` SET `category`='8' WHERE `category` = 'SmartSoft_Farm (Poultry)';
UPDATE `application_complains` SET `category`='9' WHERE `category` = 'SmartSoft_iLab';
UPDATE `application_complains` SET `category`='9' WHERE `category` = 'Smart_iLab';
UPDATE `application_complains` SET `category`='10' WHERE `category` = 'SmartSoft_Farm (Aqua)';
UPDATE `application_complains` SET `category`='11' WHERE `category` = 'SmartSoft_Food';
UPDATE `application_complains` SET `category`='11' WHERE `category` = 'Win Food';
UPDATE `application_complains` SET `category`='13' WHERE `category` = 'Smartsoft_nir';





-- subcategory update by id
--  Live birds Information = Livebird System
-- Send Gl To Ss	= Send Gl To Ss
-- Payment Module   = Bill
-- Sales System Module = Sale Management
-- Payment Module  = Check

UPDATE `application_complains` SET `subcategory`='9' WHERE `subcategory` = 'Payment Module';
UPDATE `application_complains` SET `subcategory`='9' WHERE `subcategory` = 'Check';
UPDATE `application_complains` SET `subcategory`='9' WHERE `subcategory` = 'Bill';
UPDATE `application_complains` SET `subcategory`='10' WHERE `subcategory` = 'Receipt Module';
UPDATE `application_complains` SET `subcategory`='12' WHERE `subcategory` = 'Fixed Asset Module';
UPDATE `application_complains` SET `subcategory`='13' WHERE `subcategory` = 'Production Module';
UPDATE `application_complains` SET `subcategory`='14' WHERE `subcategory` = 'Sales Module';
UPDATE `application_complains` SET `subcategory`='15' WHERE `subcategory` = 'Purchases Module';
UPDATE `application_complains` SET `subcategory`='16' WHERE `subcategory` = 'Cost Module';
UPDATE `application_complains` SET `subcategory`='17' WHERE `subcategory` = 'Generate Module';
UPDATE `application_complains` SET `subcategory`='18' WHERE `subcategory` = 'Inventory Module';
UPDATE `application_complains` SET `subcategory`='19' WHERE `subcategory` = 'Interface Transaction';
UPDATE `application_complains` SET `subcategory`='20' WHERE `subcategory` = 'Smart Credit Module';
UPDATE `application_complains` SET `subcategory`='21' WHERE `subcategory` = 'Master Set Up';
UPDATE `application_complains` SET `subcategory`='22' WHERE `subcategory` = 'Queue Module';
UPDATE `application_complains` SET `subcategory`='23' WHERE `subcategory` = 'Weight Module';
UPDATE `application_complains` SET `subcategory`='24' WHERE `subcategory` = 'Purchasing Direct Module (QC Pass)';
UPDATE `application_complains` SET `subcategory`='25' WHERE `subcategory` = 'Purchasing Indirect Module (Non QC )';
UPDATE `application_complains` SET `subcategory`='26' WHERE `subcategory` = 'Credit Control Module';
UPDATE `application_complains` SET `subcategory`='27' WHERE `subcategory` = 'Accounting Stock Module';
UPDATE `application_complains` SET `subcategory`='28' WHERE `subcategory` = 'Cost Accounting Module';
UPDATE `application_complains` SET `subcategory`='29' WHERE `subcategory` = 'Spare Part Module';
UPDATE `application_complains` SET `subcategory`='30' WHERE `subcategory` = 'Sales System Module';
UPDATE `application_complains` SET `subcategory`='30' WHERE `subcategory` = 'Sale Management';
UPDATE `application_complains` SET `subcategory`='31' WHERE `subcategory` = 'Finish goods Inventory Management Module';
UPDATE `application_complains` SET `subcategory`='32' WHERE `subcategory` = 'Raw Material Inventory Management Module';
UPDATE `application_complains` SET `subcategory`='33' WHERE `subcategory` = 'NCR-CAR Online Module';
UPDATE `application_complains` SET `subcategory`='34' WHERE `subcategory` = 'Set Up Module';
UPDATE `application_complains` SET `subcategory`='35' WHERE `subcategory` = 'Winfarm';
UPDATE `application_complains` SET `subcategory`='36' WHERE `subcategory` = 'Purchases or Transfer in';
UPDATE `application_complains` SET `subcategory`='37' WHERE `subcategory` = 'Sale or Transfer Out';
UPDATE `application_complains` SET `subcategory`='38' WHERE `subcategory` = 'Stock System';
UPDATE `application_complains` SET `subcategory`='39' WHERE `subcategory` = 'Breeder Farm Management';
UPDATE `application_complains` SET `subcategory`='40' WHERE `subcategory` = 'Set Up for Accountant';
UPDATE `application_complains` SET `subcategory`='41' WHERE `subcategory` = 'Set Up Module';
UPDATE `application_complains` SET `subcategory`='42' WHERE `subcategory` = 'Generate PO to Feed Mill';
UPDATE `application_complains` SET `subcategory`='43' WHERE `subcategory` = 'Interface';


-- application_complains
INSERT INTO `cpbit_8`.`application_complains`(`id`, `user_id`, `cat_id`, `subcat_id`, `details`, `process`, `document`, `document2`, `document3`, `document4`, `status`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `category`, `subcategory`, `details`, `process`, `document`, `document2`, `document3`, `document4`, `status`, `created_at`, `updated_at` FROM `cpbit_copy`.`application_complains`

-- application_remarks
INSERT INTO `cpbit_8`.`application_remarks`(`id`, `comp_id`, `process`, `details`, `document`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `comp_id`, `process`, `details`, `document`, `created_by`, `created_at`, `updated_at` FROM `cpbit_copy`.`application_remarks`
