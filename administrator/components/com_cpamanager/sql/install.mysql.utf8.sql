
CREATE TABLE IF NOT EXISTS `#__cpamanager_bibles` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`created_by` int(10) unsigned NOT NULL DEFAULT '0',
	`title` varchar(255) NOT NULL,
	`category` varchar(255) NOT NULL,
	`created` datetime NOT NULL,
	`description` text NOT NULL,
	`link` varchar(255) NOT NULL,
	`audio` varchar(255) NOT NULL,
	`comments` text NOT NULL,
	PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cpamanager_comments` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`userid` int(10) unsigned NOT NULL DEFAULT '0',
	`item_id` int(11) NOT NULL,
	`title` varchar(255) NOT NULL,
	`comment` text NOT NULL,
	`type` varchar(255) DEFAULT NULL,
	`created` datetime NOT NULL,
	PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cpamanager_config` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`categories_bible` text NOT NULL,
	`categories_event` text NOT NULL,
	`categories_prayer` text NOT NULL,
	`params` text NOT NULL,
	`notify_user` text NOT NULL,
	`notify_bible` text NOT NULL,
	`notify_event` text NOT NULL,
	`notify_request` text NOT NULL,
	`notify_for` text NOT NULL,
	`notify_vip` text NOT NULL,
	PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;
INSERT INTO `#__cpamanager_config` VALUES ('1', '[{\"name\":\"Category 1\"}]', '[{\"name\":\"Category 1\"}]', '[{\"name\":\"Category 1\"}]', '\"\"', '<p>Hi [USER_NAME],</p>\r\n<p>Project Name [PROJECT_NAME]</p>\r\n<p>[MESSAGES]</p>\r\n<p>Project Time [COMPLETION_TIME]</p>\r\n<p>Username: [USER_USERNAME]</p>\r\n<p>Password: [USER_PASSWORD]</p>\r\n<p>Thanks</p>', '<p>Hi [USER_NAME],</p>\r\n<p>Project Name [PROJECT_NAME]</p>\r\n<p>[MESSAGES]</p>\r\n<p>Project Time [COMPLETION_TIME]</p>\r\n<p>Username: [USER_USERNAME]</p>\r\n<p>Password: [USER_PASSWORD]</p>\r\n<p>Thanks</p>', '<p>Hi [USER_NAME],</p>\r\n<p>Project Name [PROJECT_NAME]</p>\r\n<p>[MESSAGES]</p>\r\n<p>Project Time [COMPLETION_TIME]</p>\r\n<p>Username: [USER_USERNAME]</p>\r\n<p>Password: [USER_PASSWORD]</p>\r\n<p>Thanks</p>', '<p>Hi [USER_NAME],</p>\r\n<p>Project Name [PROJECT_NAME]</p>\r\n<p>[MESSAGES]</p>\r\n<p>Project Time [COMPLETION_TIME]</p>\r\n<p>Username: [USER_USERNAME]</p>\r\n<p>Password: [USER_PASSWORD]</p>\r\n<p>Thanks</p>', '<p>Hi [USER_NAME],</p>\r\n<p>Project Name [PROJECT_NAME]</p>\r\n<p>[MESSAGES]</p>\r\n<p>Project Time [COMPLETION_TIME]</p>\r\n<p>Username: [USER_USERNAME]</p>\r\n<p>Password: [USER_PASSWORD]</p>\r\n<p>Thanks</p>', '<p>Hi [USER_NAME],</p>\r\n<p>Project Name [PROJECT_NAME]</p>\r\n<p>[MESSAGES]</p>\r\n<p>Project Time [COMPLETION_TIME]</p>\r\n<p>Username: [USER_USERNAME]</p>\r\n<p>Password: [USER_PASSWORD]</p>\r\n<p>Thanks</p>');

CREATE TABLE IF NOT EXISTS `#__cpamanager_events` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`asset_id` int(10) unsigned NOT NULL DEFAULT '0',
	`ordering` int(11) NOT NULL,
	`subject` varchar(255) NOT NULL,
	`date_start` datetime NOT NULL,
	`location` varchar(255) NOT NULL,
	`latitude` varchar(255) NOT NULL,
	`longitude` varchar(255) NOT NULL,
	`featured` int(1) unsigned NOT NULL DEFAULT '0',
	`image1` varchar(255) NOT NULL,
	`created_by` int(11) NOT NULL,
	`date_end` datetime NOT NULL,
	`phone` varchar(255) NOT NULL,
	`contact` varchar(255) NOT NULL,
	`address` varchar(255) NOT NULL,
	`category` varchar(255) DEFAULT NULL,
	`description` text,
	`image2` varchar(255) NOT NULL,
	`image3` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cpamanager_links` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL,
	`image` varchar(255) NOT NULL,
	`link` varchar(255) NOT NULL,
	`created` datetime NOT NULL,
	`state` tinyint(1) NOT NULL,
	PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cpamanager_profiles` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`asset_id` int(10) unsigned NOT NULL DEFAULT '0',
	`ordering` int(11) NOT NULL,
	`userid` int(11) NOT NULL,
	`phone` varchar(255) NOT NULL,
	`avatar` varchar(255) NOT NULL,
	`email` varchar(255) DEFAULT NULL,
	`church` varchar(255) NOT NULL,
	`location` varchar(255) DEFAULT NULL,
	`pastor` varchar(255) NOT NULL,
	`bio` text NOT NULL,
	`testimonials` text NOT NULL,
	`created` datetime NOT NULL,
	`account` tinyint(2) NOT NULL,
	PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cpamanager_requests` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`asset_id` int(10) unsigned NOT NULL DEFAULT '0',
	`ordering` int(11) NOT NULL,
	`userid` int(11) NOT NULL,
	`date_post` datetime NOT NULL,
	`prayer_request` varchar(255) NOT NULL,
	`prayer_description` text NOT NULL,
	`category` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cpamanager_warriors` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`asset_id` int(10) unsigned NOT NULL DEFAULT '0',
	`ordering` int(11) NOT NULL,
	`userid` int(11) NOT NULL,
	`praying_desc` text NOT NULL,
	`prayfor` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;










