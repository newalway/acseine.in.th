INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`)
VALUES
	(1, 'contact_mail_address', 'acseine.thailand@gmail.com', 'Recipients', 'text', 'Contact Us', 'email', '2019-01-16 10:16:58', '2017-11-20 11:35:20'),
	(2, 'contact_mail_name', 'Acseine', 'Sender name', 'text', 'Contact Us', 'email', NULL, '2017-11-20 11:35:20'),
	(3, 'order_mail_address', 'acseine.thailand@gmail.com', 'Recipients', 'text', 'Order', 'email', '2019-01-16 10:16:58', '2017-11-20 11:35:20'),
	(4, 'order_mail_name', 'Acseine', 'Sender name', 'text', 'Order', 'email', NULL, '2017-11-20 11:35:20'),
	(7, 'low_stock_report_status', 'true', 'Enable low stock notification', 'boolean', 'Low Stock Notification', 'email', NULL, '2017-11-20 11:35:20'),
	(8, 'low_stock_report_min_qty', '3', 'Low stock quantity', 'text', 'Low Stock Notification', 'email', '2019-01-16 10:16:58', '2017-11-20 11:35:20'),
	(9, 'low_stock_report_mail_address', 'acseine.thailand@gmail.com', 'Recipients', 'text', 'Low Stock Notification', 'email', '2019-01-16 10:16:58', '2017-11-20 11:35:20'),
	(10, 'low_stock_report_mail_name', 'Acseine', 'Sender name', 'text', 'Low Stock Notification', 'email', NULL, '2017-11-20 11:35:20');
