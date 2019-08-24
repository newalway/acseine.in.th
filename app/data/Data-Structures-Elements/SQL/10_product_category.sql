INSERT INTO `product_category` (`id`, `image`, `position`, `updated_at`, `created_at`)
VALUES
	(1, NULL, 1, '2018-11-01 15:43:56', '2018-10-31 10:03:13'),
	(2, NULL, 2, '2018-11-01 15:43:56', '2018-11-01 15:15:46');


INSERT INTO `product_category_translation` (`id`, `translatable_id`, `title`, `short_desc`, `locale`)
VALUES
	(1, 1, 'Skin care products', NULL, 'en'),
	(2, 1, 'ผลิตภัณฑ์บำรุงผิว', NULL, 'th'),
	(3, 2, 'Base/Makeup products', NULL, 'en'),
	(4, 2, 'ครีมกันแดดและรองพื้น', NULL, 'th');
