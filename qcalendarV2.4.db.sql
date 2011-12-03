CREATE TABLE `qcalendar` (
  `id` int(11) NOT NULL auto_increment,
  `day` varchar(2) NOT NULL,
  `month` varchar(2) NOT NULL,
  `year` varchar(4) NOT NULL,
  `link` enum('none','url','div') default 'none',
  `url` text,
  `hr` tinyint(2) NOT NULL default '0',
  `min` tinyint(2) NOT NULL default '0',
  `category_id` int(11) default NULL,
  `email_alert` tinyint(1) NOT NULL default '0',
  `sms_alert` tinyint(1) NOT NULL default '0',
  `cron_email` varchar(255) NOT NULL,
  `cron_sms_number` varchar(255) default NULL,
  `short_desc` text NOT NULL,
  `long_desc` text NOT NULL,
  `short_desc_image` text,
  `long_desc_image` text,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `qcalendar_category_id` (`category_id`)
);

CREATE TABLE `qcalendar_category` (
  `id` int(11) NOT NULL auto_increment,
  `short_desc` text NOT NULL,
  `long_desc` text NOT NULL,
  `short_desc_image` text NOT NULL,
  `long_desc_image` text NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
);

-- 
-- Dumping data for table `qcalendar_category`
-- 

INSERT INTO `qcalendar_category` VALUES (1, 'General', 'Anything can go in here', '', '', 1);
INSERT INTO `qcalendar_category` VALUES (2, 'Health', 'Regular Health Checks.', '', '', 1);
INSERT INTO `qcalendar_category` VALUES (3, 'School', 'All school work related stuff goes in here', '', '', 1);
INSERT INTO `qcalendar_category` VALUES (4, 'Work', 'All work related events.', '', '', 1);
INSERT INTO `qcalendar_category` VALUES (5, 'Public Holidays', 'Australian public holidays.', '', '', 1);
        
-- 
-- Dumping data for table `qcalendar`
-- 

INSERT INTO `qcalendar` VALUES (1, '7', '5', '*', 'div', NULL, 5, 0, 1, 1, 0, '', '', 'my birthday', '<p>today is my birthday</p>', '', '', 1);
INSERT INTO `qcalendar` VALUES (17, '2', '*', '*', 'url', 'http://www.sitecritic.net', 9, 0, 4, 0, 0, '', '', 'visit alan site first thing in the morning everyday.', '', '', '', 1);
INSERT INTO `qcalendar` VALUES (2, '12', '12', '2008', 'div', NULL, 0, 0, 3, 1, 0, '', '', 'Visit our favourite web design website', '<p>nothing here</p>', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (4, '9', '*', '*', 'div', NULL, 9, 0, 4, 0, 0, '', '', 'optimise my website', '<p>Search engine optimization has revolutionalized the internet to such an   extend that people can hardly find a well designed site with real content any   more. Every time you do a google search, you will probably see many sites with   useless information appearing in which upon clicking it, you probaly arrive at a   site full of advertisements which does not communicate. We hope more websites   are able to communicate, ie to have good content. </p>\r\n<p>We also want sitecritic.net to be a source of inspiration for designers or   people who are interested in internet technologies. As such we have added 2 more   sections. </p>\r\n', '', '', 1);
INSERT INTO `qcalendar` VALUES (5, '9', '*', '*', 'div', NULL, 20, 30, 4, 0, 0, '', '', 'Check my email', '<p>check for spam every night</p>', '', '', 1);
INSERT INTO `qcalendar` VALUES (8, '10', '3', '*', 'none', NULL, 0, 0, 5, 0, 0, '', '', 'Labour Day', '', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (9, '10', '4', '*', 'none', NULL, 0, 0, 5, 0, 0, '', '', 'Good Friday', '', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (10, '13', '4', '*', 'none', NULL, 0, 0, 5, 0, 0, '', '', 'Easter Monday', '', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (11, '25', '4', '*', 'none', NULL, 0, 0, 5, 0, 0, '', '', 'ANZAC Day', '', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (12, '8', '6', '*', 'none', NULL, 0, 0, 5, 0, 0, '', '', 'Queen''s Birthday', '', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (13, '3', '11', '*', 'none', NULL, 0, 0, 5, 0, 0, '', '5', 'Melbourne Cup', '', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (14, '25', '12', '*', 'none', NULL, 0, 0, 5, 0, 0, '', '', 'Christmas Day', '', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (7, '26', '1', '*', 'none', NULL, 0, 0, 5, 0, 0, '', '', 'Australia Day', '', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (6, '15', '*', '*', 'none', NULL, 0, 0, 1, 0, 0, '', '', 'full moon every month reminder.', '', NULL, NULL, 1);
INSERT INTO `qcalendar` VALUES (15, '9', '*', '*', 'div', NULL, 18, 20, 3, 0, 0, '', '', 'Do homework', '<p>It is time to do homework.</p><p>don''t watch TV.</p>', '', '', 1);
INSERT INTO `qcalendar` VALUES (18, '5', '*', '*', 'div', NULL, 5, 5, 2, 0, 0, '', '', 'Weights Training. Remember to workout!', '<p>exercising is good for health</p>\r\n', '', '', 1);
        