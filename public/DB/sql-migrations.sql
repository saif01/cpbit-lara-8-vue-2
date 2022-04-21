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
INSERT INTO `cpbit_8`.`application_complains`(`id`, `user_id`, `cat_id`, `subcat_id`, `details`, `process`, `document`, `document2`, `document3`, `document4`, `status`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `category`, `subcategory`, `details`, `process`, `document`, `document2`, `document3`, `document4`, `status`, `created_at`, `updated_at` FROM `cpbit`.`application_complains`

-- application_remarks
INSERT INTO `cpbit_8`.`application_remarks`(`id`, `comp_id`, `process`, `details`, `document`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `comp_id`, `process`, `details`, `document`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`application_remarks`



-- hardware_complains
INSERT INTO `cpbit_8`.`hardware_complains`(`id`, `user_id`,  `details`, `process`, `computer_name`, `document`, `accessories`, `status`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `details`, `process`, `computer_name`, `document`, `tools`, `status`, `created_at`, `updated_at` FROM `cpbit`.`hardware_complains`






-- Inventory

-- inventory_new_products
INSERT INTO `cpbit_8`.`inventory_new_products`(`id`, `cat_id`, `subcat_id`, `name`, `serial`, `remarks`, `document`, `purchase`, `warranty`, `created_by`, `give_st`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `category`, `subcategory`, `name`, `serial`, `remarks`, `document`, `purchase`, `warranty`, `created_by`, `give_st`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`inventory_new_products`

UPDATE `inventory_new_products` SET `document`= REPLACE(`document`, 'images/inventory/', '')


SELECT `id` FROM `hardware_categories` WHERE `name` = 'Attendance Machine'
UPDATE `inventory_new_products` SET `category`= 30 WHERE `category` = 'Attendance Machine'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'Printer Laser'
UPDATE `inventory_new_products` SET `category`= 9 WHERE `category` = 'Printer Laser'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'Printer Thermal'
UPDATE `inventory_new_products` SET `category`= 10 WHERE `category` = 'Printer Thermal'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'Printer Dot Matrix' 
UPDATE `inventory_new_products` SET `category`= 16 WHERE `category` = 'Printer Dot Matrix'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'UPS'
UPDATE `inventory_new_products` SET `category`= 6 WHERE `category` = 'UPS'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'Monitor'
UPDATE `inventory_new_products` SET `category`= 8 WHERE `category` = 'Monitor'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'Projector'
UPDATE `inventory_new_products` SET `category`= 21 WHERE `category` = 'Projector'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'Mouse'
UPDATE `inventory_new_products` SET `category`= 28 WHERE `category` = 'Mouse'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'WIFI'
UPDATE `inventory_new_products` SET `category`= 23 WHERE `category` = 'WIFI'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'Weight Scale'
UPDATE `inventory_new_products` SET `category`= 42 WHERE `category` = 'Weight Scale'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'Switch'
UPDATE `inventory_new_products` SET `category`= 24 WHERE `category` = 'Switch'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'Computer Desktop'
UPDATE `inventory_new_products` SET `category`= 12 WHERE `category` = 'Computer Desktop'

SELECT `id` FROM `hardware_categories` WHERE `name` = 'CCTV'
UPDATE `inventory_new_products` SET `category`= 22 WHERE `category` = 'CCTV'

SELECT id FROM `hardware_categories` WHERE `name` = 'Barcode Scanner'
UPDATE `inventory_new_products` SET `category`= 26 WHERE `category` = 'Barcode Scanner'

SELECT id FROM `hardware_categories` WHERE `name` = 'Router'
UPDATE `inventory_new_products` SET `category`= 25 WHERE `category` = 'Router'

SELECT id FROM `hardware_categories` WHERE `name` = 'Printer Inkjet'
UPDATE `inventory_new_products` SET `category`= 17 WHERE `category` = 'Printer Inkjet'

SELECT id FROM `hardware_categories` WHERE `name` = 'Keyboard'
UPDATE `inventory_new_products` SET `category`= 27 WHERE `category` = 'Keyboard'

SELECT id FROM `hardware_categories` WHERE `name` = 'Laptop'
UPDATE `inventory_new_products` SET `category`= 20 WHERE `category` = 'Laptop' 

SELECT id FROM `hardware_categories` WHERE `name` = 'Computer All IN One'
UPDATE `inventory_new_products` SET `category`= 19 WHERE `category` = 'Computer All IN One' 

-- subcategory
SELECT id FROM `hardware_subcategories` WHERE `name` = 'Canon'
UPDATE `inventory_new_products` SET `subcategory`= 59 WHERE `subcategory` = 'Canon'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Actatek'
UPDATE `inventory_new_products` SET `subcategory`= 116 WHERE `subcategory` = 'Actatek'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'A4Tech'
UPDATE `inventory_new_products` SET `subcategory`= 104 WHERE `subcategory` = 'A4Tech'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'HP'
UPDATE `inventory_new_products` SET `subcategory`= 57 WHERE `subcategory` = 'HP'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Epson'
UPDATE `inventory_new_products` SET `subcategory`= 64 WHERE `subcategory` = 'Epson'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Online 10000 VA'
UPDATE `inventory_new_products` SET `subcategory`= 84 WHERE `subcategory` = 'Online 10000 VA'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Samsung'
UPDATE `inventory_new_products` SET `subcategory`= 58 WHERE `subcategory` = 'Samsung'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Netgear Gigaport'
UPDATE `inventory_new_products` SET `subcategory`= 101 WHERE `subcategory` = 'Netgear Gigaport'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Brother'
UPDATE `inventory_new_products` SET `subcategory`= 62 WHERE `subcategory` = 'Brother'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Altai'
UPDATE `inventory_new_products` SET `subcategory`= 91 WHERE `subcategory` = 'Altai'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Wireless'
UPDATE `inventory_new_products` SET `subcategory`= 92 WHERE `subcategory` = 'Wireless'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Wired (USB)'
UPDATE `inventory_new_products` SET `subcategory`= 93 WHERE `subcategory` = 'Wired (USB)'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Mikrotik'
UPDATE `inventory_new_products` SET `subcategory`= 94 WHERE `subcategory` = 'Mikrotik'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Camera HD'
UPDATE `inventory_new_products` SET `subcategory`= 88 WHERE `subcategory` = 'Camera HD'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'HP CPU'
UPDATE `inventory_new_products` SET `subcategory`= 69 WHERE `subcategory` = 'HP CPU'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Zebra'
UPDATE `inventory_new_products` SET `subcategory`= 63 WHERE `subcategory` = 'Zebra'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Fm21e 300 Kg'
UPDATE `inventory_new_products` SET `subcategory`= 238 WHERE `subcategory` = 'Fm21e 300 Kg'

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Offline 1000 VA '
UPDATE `inventory_new_products` SET `subcategory`= 25 WHERE `subcategory` = 'Offline 1000 VA '

SELECT id FROM `hardware_subcategories` WHERE `name` = 'Lenovo' 
UPDATE `inventory_new_products` SET `subcategory`= 70 WHERE `subcategory` = 'Lenovo '

SELECT id FROM `hardware_subcategories` WHERE name = 'Dell CPU'
UPDATE `inventory_new_products` SET `subcategory`= 68 WHERE `subcategory` = 'Dell CPU '

SELECT id FROM `hardware_subcategories` WHERE name = 'Dell'
UPDATE `inventory_new_products` SET `subcategory`= 56 WHERE `subcategory` = 'Dell'

SELECT id FROM `hardware_subcategories` WHERE name = 'Asus' 
UPDATE `inventory_new_products` SET `subcategory`= 71 WHERE `subcategory` = 'Asus'

-- operation
UPDATE `inventory_old_products` SET `operation` = 2 WHERE `operation` = 'Head Office'
UPDATE `inventory_old_products` SET `operation` = 3 WHERE `operation` = 'Feedmil'
UPDATE `inventory_old_products` SET `operation` = 4 WHERE `operation` = 'Breeder & Hatchery'
UPDATE `inventory_old_products` SET `operation` = 5 WHERE `operation` = 'Integration Business'
UPDATE `inventory_old_products` SET `operation` = 6 WHERE `operation` = 'Aqua Business'
UPDATE `inventory_old_products` SET `operation` = 7 WHERE `operation` = 'Food Business'


-- inventory old product
INSERT INTO `cpbit_8`.`inventory_old_products`( `id`, `new_pro_id`, `cat_id`, `subcat_id`, `office`, `business_unit`, `operation_id`, `name`, `serial`, `remarks`, `type`, `rec_name`, `rec_contact`, `rec_position`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `new_pro_id`, `category`, `subcategory`, `office`, `business_unit`, `operation`, `name`, `serial`, `remarks`, `type`, `rec_name`, `rec_contact`, `rec_position`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`inventory_old_products`









-- Power BI

-- pbi_roles
INSERT INTO `cpbit_8`.`pbi_roles`(`id`, `name`, `link`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `link`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`iservice_powerbis` 

-- pbi_user_role
INSERT INTO `cpbit_8`.`pbi_user_role`(`id`, `pbi_role_id`, `user_id`, `created_at`, `updated_at`) SELECT `id`, `iservice_powerbi_id`, `user_id`, `created_at`, `updated_at` FROM `cpbit`.`iservice_powerbi_user`





-- mobile_app_roles
INSERT INTO `cpbit_8`.`mobile_app_roles`(`id`, `name`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`isales_roles`

-- mobile_app_role_user
INSERT INTO `cpbit_8`.`mobile_app_role_user`(`id`, `mobile_app_role_id`, `user_id`, `created_at`, `updated_at`) SELECT `id`, `iqscm_role_id`, `user_id`, `created_at`, `updated_at` FROM `cpbit`.`isales_role_user`

-- mobile_app_versions
INSERT INTO `cpbit_8`.`mobile_app_versions`(`id`, `name`, `version`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `version`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`isales_app_versions`




-- Room Booking
INSERT INTO `cpbit_8`.`rooms`(`id`, `name`, `capacity`, `projector`, `image`, `image2`, `image3`, `remarks`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `capacity`, `projector`, `image`, `image2`, `image3`, `remarks`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`rooms`


UPDATE `rooms` SET `image`=REPLACE(`image`, 'images/room/original/', ''),
`image2`=REPLACE(`image2`, 'images/room/original/', ''),
`image3`=REPLACE(`image3`, 'images/room/original/', '');


UPDATE `rooms` SET `projector`= 1  where `id` = 7;
UPDATE `rooms` SET `projector`= 1  where `id` = 8;
UPDATE `rooms` SET `projector`= 1  where `id` = 13;

-- room_bookings
INSERT INTO `cpbit_8`.`room_bookings`(`id`, `user_id`, `room_id`, `start`, `end`, `duration`, `purpose`, `status`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `room_id`, `start`, `end`, `hours`, `purpose`, `status`, `created_at`, `updated_at` FROM `cpbit`.`room_bookings`



--Carpool

--carpool_bookings
INSERT INTO `cpbit_8`.`carpool_bookings`(`id`, `user_id`, `car_id`, `driver_id`, `start`, `end`, `destination`, `purpose`, `status`, `gas`, `octane`, `toll`, `cost`, `driver_rating`, `start_mileage`, `end_mileage`, `km`, `comit_st`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `car_id`, `driver_id`, `start`, `end`, `destination`, `purpose`, `status`, `gas`, `octane`, `toll`, `cost`, `driver_rating`, `start_mileage`, `end_mileage`, `km`, `comit_st`, `created_at`, `updated_at` FROM `cpbit`.`carpool_bookings` 

-- carpool_cars
INSERT INTO `cpbit_8`.`carpool_cars`(`id`, `number`, `name`, `capacity`, `temporary`, `image`, `image2`, `image3`, `remarks`, `last_use`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `number`, `name`, `capacity`, `temporary`, `image`, `image2`, `image3`, `remarks`, `last_use`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_cars`


UPDATE `carpool_cars` SET `image`=REPLACE(`image`, 'images/carpool/cars/original/', ''),
`image2`=REPLACE(`image2`, 'images/carpool/cars/original/', ''),
`image3`=REPLACE(`image3`, 'images/carpool/cars/original/', '');


INSERT INTO `cpbit_8`.`carpool_car_maintenances`(`id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_car_maintenances`


INSERT INTO `cpbit_8`.`carpool_car_requisitions`(`id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_car_requisitions`

INSERT INTO `cpbit_8`.`carpool_destinations`(`id`, `name`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_destinations`

-- carpool_drivers
INSERT INTO `cpbit_8`.`carpool_drivers`(`id`, `name`, `contact`, `car_id`, `image`, `image_small`, `license`, `nid`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `contact`, `car_id`, `image`, `image_small`, `license`, `nid`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_drivers`

-- carpool_driver_leaves
INSERT INTO `cpbit_8`.`carpool_driver_leaves`(`id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_driver_leaves`
 


