INSERT INTO `shipping_rate` (`id`, `rate_type`, `title`, `minimum_range`, `maximum_range`, `rate_amount`, `updated_at`, `created_at`, `free_shipping`)
VALUES
	(1, 'item_based_rate', 'Free Shipping (over 2 items)', 2, 0, NULL, '2019-02-01 10:30:15', '2019-01-22 15:17:26', 1),
	(2, 'item_based_rate', '1 Item (Cost 65B)', 1, 1, 65, '2019-02-01 10:37:21', '2019-02-01 10:30:43', 0);
