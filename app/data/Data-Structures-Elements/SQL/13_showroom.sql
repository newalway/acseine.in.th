INSERT INTO `showroom` (`id`, `image`, `latitude`, `longitude`, `phone`, `fax`, `mobile`, `position`, `status`, `updated_at`, `created_at`, `location_id`, `place_id`)
VALUES
	(1, NULL, '13.7269397', '100.50999609999997', NULL, NULL, NULL, 0, 1, '2018-12-20 09:41:09', '2018-10-31 09:48:50', 1, 'ChIJFRjwgc2Z4jAR9JIadoa9YBY');


INSERT INTO `showroom_translation` (`id`, `translatable_id`, `title`, `address`, `locale`, `closest_station`)
VALUES
	(1, 1, 'Iconsiam (Siam Takashimaya M Floor)', '299 Charoen Nakhon 5, Charoen Nakhon Rd, Khwaeng Khlong Ton Sai, Khet Khlong San, Krung Thep Maha Nakhon 10600', 'en', 'Iconsiam'),
	(2, 1, 'Iconsiam (Siam Takashimaya M Floor)', '299 ซอยเจริญนคร 5, ถนน เจริญนคร แขวง คลองต้นไทร เขต คลองสาน กรุงเทพมหานคร 10600', 'th', 'BTS สะพานตากสิน (Free shuttle boat) / BTS กรุงธนบุรี (Free shuttle bus)');
