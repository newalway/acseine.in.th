INSERT INTO `banner` (`id`, `public_date`, `status`, `updated_at`, `created_at`, `position`)
VALUES
	(1, '2018-10-31', 1, '2019-02-01 16:53:22', '2018-10-31 15:33:36', 6),
	(2, '2018-10-31', 1, '2019-02-01 16:53:22', '2018-10-31 16:03:42', 5),
	(3, '2018-10-31', 0, '2019-02-01 16:53:22', '2018-10-31 16:05:07', 4),
	(4, '2018-12-14', 0, '2019-02-01 16:53:22', '2018-12-14 09:08:44', 3),
	(5, '2018-12-17', 0, '2019-02-01 16:53:22', '2018-12-17 16:50:13', 2),
	(6, '2019-01-28', 1, '2019-02-01 16:53:22', '2019-01-28 12:09:26', 7),
	(7, '2019-02-01', 1, '2019-02-01 17:09:07', '2019-02-01 16:52:04', 1);


INSERT INTO `banner_translation` (`id`, `translatable_id`, `title`, `subtitle`, `website`, `locale`, `image`, `image_mobile`)
VALUES
	(1, 1, 'SUPER SUNSHIELD EX SPF50+ PA++++', 'Banner', 'https://www.acseine.in.th/en/product/2/series/gentle-uv-care', 'en', '/uploads/userfiles/images/banner/Super-Sunshield/sun2-en.png', '/uploads/userfiles/images/banner/Super-Sunshield/sun2-en-m.png'),
	(2, 1, 'SUPER SUNSHIELD SPF50+ PA++++', NULL, 'https://www.acseine.in.th/product/2/series/gentle-uv-care', 'th', '/uploads/userfiles/images/banner/Super-Sunshield/sun2-th.png', '/uploads/userfiles/images/banner/Super-Sunshield/sun2-th-m.png'),
	(3, 2, 'MOISTBALANCE', NULL, 'https://www.acseine.in.th/en/product/1/series/for-dry-skin-that-needs-more-moisture-moistbalance', 'en', '/uploads/userfiles/images/banner/moistbalance/top_slider02_pc.jpg', '/uploads/userfiles/images/banner/moistbalance/top_slider02_sp_en.jpg'),
	(4, 2, 'MOISTBALANCE', NULL, 'https://www.acseine.in.th/campaign/moistbalance', 'th', '/uploads/userfiles/images/banner/moistbalance/top_slider02_pc_th.png', '/uploads/userfiles/images/banner/moistbalance/top_slider02_sp_th.jpg'),
	(5, 3, 'AD Control', NULL, 'http://acseine.in.th/en/product/7/series/for-sensitive-skin-thats-vulnerable-to-irritants', 'en', '/uploads/userfiles/images/banner/top_slider03_pc.jpg', '/uploads/userfiles/images/banner/Acseine-1.png'),
	(6, 3, 'AD Control', NULL, 'http://acseine.in.th/product/7/series/for-sensitive-skin-thats-vulnerable-to-irritants', 'th', '/uploads/userfiles/images/banner/top_slider03_pc_th.png', '/uploads/userfiles/images/banner/Acseine-1.png'),
	(7, 4, 'Acseine Xmas Campaign', 'โปรโมชั่น ไอคอนสยาม', 'http://acseine.in.th/product/', 'th', '/uploads/userfiles/images/banner/Acseine-Xmas-Campaign/Acseine-Xmas-Campaign.png', '/uploads/userfiles/images/banner/Acseine-Xmas-Campaign/Acseine-131218-Promotion-gray-star-Mobile.jpg'),
	(8, 4, 'Acseine Xmas Campaign', NULL, 'http://acseine.in.th/en/product/', 'en', '/uploads/userfiles/images/banner/Acseine-Xmas-Campaign/Acseine-Xmas-Campaign.png', '/uploads/userfiles/images/banner/Acseine-Xmas-Campaign/Acseine-131218-Promotion-gray-star-Mobile.jpg'),
	(9, 5, 'Acseine Lucky Box campaign', 'โปรโมชั่น ออนไลน์ วันปีใหม่', 'http://acseine.in.th/product/', 'th', '/uploads/userfiles/images/banner/Lucky-Box-campaign/banner-Lucky-Box-campaign.jpg', '/uploads/userfiles/images/banner/Lucky-Box-campaign/Acseine-767.png'),
	(10, 5, 'Acseine Lucky Box campaign', NULL, 'http://acseine.in.th/en/product/', 'en', '/uploads/userfiles/images/banner/Lucky-Box-campaign/banner-Lucky-Box-campaign.jpg', '/uploads/userfiles/images/banner/Lucky-Box-campaign/banner-Lucky-Box-campaign-m.jpg'),
	(11, 6, 'Super Sunshield BRIGHT FIT SPF50 + PA ++++', NULL, 'https://www.acseine.in.th/product/detail/17/super-sunshield-bright-fit-spf50-+-pa-++++', 'th', '/uploads/userfiles/images/banner/Super-Sunshield/sunfit-th.png', '/uploads/userfiles/images/banner/Super-Sunshield/sunfit-th-m.png'),
	(12, 6, 'Super Sunshield BRIGHT FIT SPF50 + PA ++++', NULL, 'https://www.acseine.in.th/en/product/detail/17/super-sunshield-bright-fit-spf50-+-pa-++++', 'en', '/uploads/userfiles/images/banner/Super-Sunshield/sunfit-en.png', '/uploads/userfiles/images/banner/Super-Sunshield/sunfit-en-m.png'),
	(13, 7, 'Rose Cheek Limited Powder ฟรี!', NULL, 'https://www.facebook.com/notes/acseine/acseine-celebration-30-%E0%B8%A1%E0%B8%84-10-%E0%B8%A1%E0%B8%B5%E0%B8%84-2562/2530289976999012/?fbclid=IwAR1GjhIsEXcABzYdtvtvtvAT5spyF5oz69mEMCqtElF4_nn5dD7e7YijSak', 'th', '/uploads/userfiles/images/banner/Free-Rose-Cheek-Limited-Powder/Acseine-Banner-Web-THnew.jpg', '/uploads/userfiles/images/banner/Free-Rose-Cheek-Limited-Powder/Acseine-Moblie--TH.jpg'),
	(14, 7, 'Free! Rose Cheek Limited Powder', NULL, 'https://www.facebook.com/notes/acseine/acseine-celebration-30-%E0%B8%A1%E0%B8%84-10-%E0%B8%A1%E0%B8%B5%E0%B8%84-2562/2530289976999012/?fbclid=IwAR1GjhIsEXcABzYdtvtvtvAT5spyF5oz69mEMCqtElF4_nn5dD7e7YijSak', 'en', '/uploads/userfiles/images/banner/Free-Rose-Cheek-Limited-Powder/Acseine-Banner-Web-THnew-ENG.jpg', '/uploads/userfiles/images/banner/Free-Rose-Cheek-Limited-Powder/Acseine-Moblie--ENG.jpg');
