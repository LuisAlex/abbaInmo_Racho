DROP TABLE IF EXISTS `#__properties_available_product`;
DROP TABLE IF EXISTS `#__properties_available_product`;
CREATE TABLE `#__properties_available_product` (
  `id` int(11) NOT NULL auto_increment,
  `id_product` int(11) NOT NULL,
  `date` date NOT NULL,
  `available` tinyint(4) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__properties_bookings`;
CREATE TABLE `#__properties_bookings` (
  `ob_id_order` int(5) NOT NULL auto_increment,
  `ob_id_property` int(5) NOT NULL,
  `ob_name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_address` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_postcode` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_city` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_state` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_country` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_phone` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_text` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_mail` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_created` datetime NOT NULL,
  `ob_from` date NOT NULL,
  `ob_to` date NOT NULL,
  `ob_price` int(5) NOT NULL,
  `ob_adults` tinyint(1) NOT NULL,
  `ob_boys` tinyint(1) NOT NULL,
  `ob_babies` tinyint(1) NOT NULL,
  `ob_deposit` date default NULL,
  `ob_deposit_amount` int(9) NOT NULL,
  `ob_confirmed` tinyint(4) NOT NULL,
  `ob_confirmed_date` date default NULL,
  `ob_confirmed_by` int(5) NOT NULL,
  `ob_send_mail` tinyint(1) NOT NULL,
  `ob_text_mail` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_language` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_contract_name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ob_contract_send` date default NULL,
  PRIMARY KEY  (`ob_id_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__properties_category`;
CREATE TABLE `#__properties_category` (
  `id` int(2) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `alias` varchar(100) default NULL,
  `parent` int(2) default NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(1) NOT NULL,
  `checked_out` tinyint(1) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `access` tinyint(3) NOT NULL,
  `params` text NOT NULL,
  `metadesc` varchar(1024) NOT NULL,
  `metakey` varchar(1024) NOT NULL,
  `layout` varchar(100) NOT NULL,
  `cat_currency` VARCHAR(5) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `#__properties_category` VALUES 
(1, 'For Rent', 'for-rent', 0, 1, 0, 0, '0000-00-00 00:00:00', 0, '', '', '', '', ''),
(2, 'For Sale', 'for-sale', 0, 1, 0, 0, '0000-00-00 00:00:00', 0, '', '', '', '', '');

DROP TABLE IF EXISTS `#__properties_comments`;
CREATE TABLE `#__properties_comments` (
  `id` int(10) NOT NULL auto_increment,
  `userid` int(10) NOT NULL default '0',
  `status` int(10) NOT NULL default '0',
  `productid` int(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `name` varchar(200) default NULL,
  `title` varchar(200) NOT NULL default '',
  `comment` text NOT NULL,
  `preview` text NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `published` tinyint(1) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `email` varchar(100) NOT NULL default '',
  `website` varchar(100) NOT NULL default '',
  `updateme` smallint(5) unsigned NOT NULL default '0',
  `custom1` varchar(200) NOT NULL default '',
  `custom2` varchar(200) NOT NULL default '',
  `custom3` varchar(200) NOT NULL default '',
  `custom4` varchar(200) NOT NULL default '',
  `custom5` varchar(200) NOT NULL default '',
  `star` decimal(3,2) NOT NULL default '5.00',
  `star1` tinyint(1) NOT NULL,
  `star2` tinyint(1) NOT NULL,
  `star3` tinyint(1) NOT NULL,
  `star4` tinyint(1) NOT NULL,
  `star5` tinyint(1) NOT NULL,
  `user_id` int(10) unsigned NOT NULL default '0',
  `option` varchar(50) NOT NULL default 'com_content',
  `voted` smallint(6) NOT NULL default '0',
  `referer` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__properties_contacts`;
CREATE TABLE `#__properties_contacts` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `cp` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `userfile` varchar(255) NOT NULL,
  `layout` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `#__properties_contacts` VALUES 
(1, 1, 0, '2010-09-30 12:57:07', 'Administrator', 'admin@property30.com', '0735 82499', '1233 Meklin', 'Alicante', 'Buenos Aires', '8000', '', '', ''),
(2, 1, 0, '2010-09-30 12:57:38', 'Fabio Esteban Uzeltinger', 'fabiouz@gmail.com', '0861.712728', '1233 Meklin', 'Alicante', '', '', '', '', ''),
(3, 2, 0, '2010-09-30 12:58:15', 'SOLUCIONES', 'test2@property30.com', '0735 82499', 'Lungomare Marconi', 'Bahia Blanca', '', '', '', '', ''),
(4, 8, 0, '2011-08-19 13:57:19', 'Marek Vondřička', 'fabiouz@gmail.com', '4545422', '', '', '', '', '555', '', '');

DROP TABLE IF EXISTS `#__properties_country`;
CREATE TABLE `#__properties_country` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `mid` int(2) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `#__properties_country` VALUES 
(1, 'United States', 'united-states', 0, 1, 0, 0, '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `#__properties_images`;
CREATE TABLE `#__properties_images` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `parent` int(4) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(4) NOT NULL,
  `type` varchar(100) NOT NULL,
  `path` varchar(255) NOT NULL,
  `rout` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `uid` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `sector` varchar(255) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

INSERT INTO `#__properties_images` VALUES 
(1, '1_1.jpg', 1, 1, 1, 'jpg', '', '', '2010-06-20 12:42:51', 62, 0, '', ''),
(2, '2_1.jpg', 1, 1, 2, 'jpg', '', '', '2010-06-20 12:42:51', 62, 0, '', ''),
(3, '3_1.jpg', 1, 1, 3, 'jpg', '', '', '2010-06-20 12:42:51', 62, 0, '', ''),
(4, '4_1.jpg', 1, 1, 0, 'jpg', '', '', '2010-06-20 12:42:51', 62, 0, '', ''),
(5, '5_1.jpg', 1, 1, 4, 'jpg', '', '', '2010-06-20 12:42:51', 62, 0, '', ''),
(6, '6_1.jpg', 1, 1, 5, 'jpg', '', '', '2010-06-20 12:42:51', 62, 0, '', ''),
(7, '7_2.jpg', 2, 1, 1, 'jpg', '', '', '2010-06-20 12:44:03', 62, 0, '', ''),
(8, '8_2.jpg', 2, 1, 2, 'jpg', '', '', '2010-06-20 12:44:03', 62, 0, '', ''),
(9, '9_2.jpg', 2, 1, 3, 'jpg', '', '', '2010-06-20 12:44:03', 62, 0, '', ''),
(10, '10_2.jpg', 2, 1, 4, 'jpg', '', '', '2010-06-20 12:44:03', 62, 0, '', ''),
(11, '11_2.jpg', 2, 1, 5, 'jpg', '', '', '2010-06-20 12:44:03', 62, 0, '', ''),
(12, '12_2.jpg', 2, 1, 6, 'jpg', '', '', '2010-06-20 12:44:03', 62, 0, '', ''),
(13, '13_3.jpg', 3, 1, 1, 'jpg', '', '', '2010-06-20 12:45:15', 62, 0, '', ''),
(14, '14_3.jpg', 3, 1, 2, 'jpg', '', '', '2010-06-20 12:45:15', 62, 0, '', ''),
(15, '15_3.jpg', 3, 1, 3, 'jpg', '', '', '2010-06-20 12:45:15', 62, 0, '', ''),
(16, '16_3.jpg', 3, 1, 4, 'jpg', '', '', '2010-06-20 12:45:15', 62, 0, '', ''),
(17, '17_3.jpg', 3, 1, 5, 'jpg', '', '', '2010-06-20 12:45:15', 62, 0, '', ''),
(18, '18_3.jpg', 3, 1, 6, 'jpg', '', '', '2010-06-20 12:45:15', 62, 0, '', ''),
(19, '19_4.jpg', 4, 1, 5, 'jpg', '', '', '2010-06-20 12:46:16', 62, 0, '', ''),
(20, '20_4.jpg', 4, 1, 2, 'jpg', '', '', '2010-06-20 12:46:16', 62, 0, '', ''),
(21, '21_4.jpg', 4, 1, 3, 'jpg', '', '', '2010-06-20 12:46:16', 62, 0, '', ''),
(22, '22_4.jpg', 4, 1, 4, 'jpg', '', '', '2010-06-20 12:46:16', 62, 0, '', ''),
(23, '23_4.jpg', 4, 1, 1, 'jpg', '', '', '2010-06-20 12:46:16', 62, 0, '', ''),
(24, '24_4.jpg', 4, 1, 6, 'jpg', '', '', '2010-06-20 12:46:16', 62, 0, '', ''),
(25, '25_5.jpg', 5, 1, 1, 'jpg', '', '', '2010-06-20 12:47:50', 62, 0, '0', ''),
(26, '26_5.jpg', 5, 1, 2, 'jpg', '', '', '2010-06-20 12:47:50', 62, 0, '0', ''),
(27, '27_5.jpg', 5, 1, 3, 'jpg', '', '', '2010-06-20 12:47:50', 62, 0, '0', ''),
(28, '28_5.jpg', 5, 1, 4, 'jpg', '', '', '2010-06-20 12:47:50', 62, 0, '0', ''),
(29, '29_5.jpg', 5, 1, 5, 'jpg', '', '', '2010-06-20 12:47:50', 62, 0, '0', ''),
(30, '30_5.jpg', 5, 1, 6, 'jpg', '', '', '2010-06-20 12:47:50', 62, 0, '0', ''),
(31, '31_6.jpg', 6, 1, 1, 'jpg', '', '', '2010-06-20 12:49:43', 62, 6, '', ''),
(32, '32_7.jpg', 7, 1, 1, 'jpg', '', '', '2010-06-20 12:50:04', 62, 7, '', ''),
(33, '33_8.jpg', 8, 1, 1, 'jpg', '', '', '2010-06-20 12:50:18', 62, 8, '', ''),
(34, '34_9.jpg', 9, 1, 1, 'jpg', '', '', '2010-06-20 12:50:49', 62, 9, '', ''),
(35, '35_10.jpg', 10, 1, 1, 'jpg', '', '', '2010-06-20 12:51:10', 62, 10, '', ''),
(36, '36_11.jpg', 11, 1, 1, 'jpg', '', '', '2010-06-20 12:51:25', 62, 11, '', ''),
(37, '37_12.jpg', 12, 1, 1, 'jpg', '', '', '2010-06-20 12:51:40', 62, 12, '', ''),
(38, '38_13.jpg', 13, 1, 1, 'jpg', '', '', '2010-06-20 12:52:55', 62, 13, '', ''),
(39, '39_14.jpg', 14, 1, 1, 'jpg', '', '', '2010-06-20 12:53:12', 62, 14, '', ''),
(40, '40_15.jpg', 15, 1, 1, 'jpg', '', '', '2010-10-09 13:30:17', 62, 0, '', '');

DROP TABLE IF EXISTS `#__properties_lightbox`;
CREATE TABLE `#__properties_lightbox` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `propid` int(11) NOT NULL default '0',
  `date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__properties_locality`;
CREATE TABLE `#__properties_locality` (
  `id` int(6) NOT NULL auto_increment,
  `parent` int(3) NOT NULL,
  `mid` int(6) NOT NULL,
  `zipcode` int(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `#__properties_locality` VALUES 
(1, 2, 0, 0, 'Atlanta', 'atlanta', 1, 0, 0, '0000-00-00 00:00:00'),
(2, 2, 0, 0, 'Roswell', 'roswell', 1, 0, 0, '0000-00-00 00:00:00'),
(3, 2, 0, 0, 'Smyrna', 'smyrna', 1, 0, 0, '0000-00-00 00:00:00'),
(4, 2, 0, 0, 'Gainesville', 'gainesville', 1, 0, 0, '0000-00-00 00:00:00'),
(5, 2, 0, 0, 'Dunwoody', 'dunwoody', 1, 0, 0, '0000-00-00 00:00:00'),
(6, 1, 0, 0, 'Washington City', 'washington-city', 1, 1, 0, '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `#__properties_pdfs`;
CREATE TABLE `#__properties_pdfs` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `parent` int(3) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(5) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `archivo_path` varchar(255) NOT NULL,
  `archivo_rout` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

INSERT INTO `#__properties_pdfs` VALUES 
(7, 'PANEL', 'panel', 1, 1, 1, '', '2011-09-05', 'PANEL.pdf', '', ''),
(8, 'Mi Perfil', 'mi-perfil', 1, 1, 2, '', '2011-09-05', 'Mi Perfil.pdf', '', '');

DROP TABLE IF EXISTS `#__properties_products`;
CREATE TABLE `#__properties_products` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `parent` int(6) NOT NULL,
  `agent_id` int(6) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `ref` varchar(50) NOT NULL,
  `type` int(6) NOT NULL,
  `cid` int(6) NOT NULL,
  `lid` int(6) NOT NULL,
  `sid` int(6) NOT NULL,
  `cyid` int(6) NOT NULL,
  `postcode` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `description` text NOT NULL,
  `text` text NOT NULL,
  `price` decimal(15,2) default NULL,
  `currency` VARCHAR(5) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `use_booking` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `panoramic` varchar(255) default NULL,
  `video` text NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `featured` tinyint(4) NOT NULL,
  `years` int(4) NOT NULL,
  `capacity` int(2) NOT NULL,
  `bedrooms` tinyint(1) NOT NULL,
  `bathrooms` tinyint(1) NOT NULL,
  `garage` tinyint(1) NOT NULL,
  `area` int(5) NOT NULL,
  `covered_area` int(5) NOT NULL,
  `hits` int(6) NOT NULL,
  `listdate` date NOT NULL default '0000-00-00',
  `refresh_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `language` tinyint(1) NOT NULL,
  `access` tinyint(3) NOT NULL,
  `params` text NOT NULL,
  `metatitle` varchar(255) NOT NULL,
  `metadesc` text NOT NULL,
  `metakey` text NOT NULL,
  `layout` varchar(100) NOT NULL,
  `extra1` tinyint(1) NOT NULL default '0',
  `extra2` tinyint(1) NOT NULL default '0',
  `extra3` tinyint(1) NOT NULL default '0',
  `extra4` tinyint(1) NOT NULL default '0',
  `extra5` tinyint(1) NOT NULL default '0',
  `extra6` tinyint(1) NOT NULL default '0',
  `extra7` tinyint(1) NOT NULL default '0',
  `extra8` tinyint(1) NOT NULL default '0',
  `extra9` tinyint(1) NOT NULL default '0',
  `extra10` tinyint(1) NOT NULL default '0',
  `extra11` tinyint(1) NOT NULL default '0',
  `extra12` tinyint(1) NOT NULL default '0',
  `extra13` tinyint(1) NOT NULL default '0',
  `extra14` tinyint(1) NOT NULL default '0',
  `extra15` tinyint(1) NOT NULL default '0',
  `extra16` tinyint(1) NOT NULL default '0',
  `extra17` tinyint(1) NOT NULL default '0',
  `extra18` tinyint(1) NOT NULL default '0',
  `extra19` tinyint(1) NOT NULL default '0',
  `extra20` tinyint(1) NOT NULL default '0',
  `extra21` tinyint(1) NOT NULL default '0',
  `extra22` tinyint(1) NOT NULL default '0',
  `extra23` tinyint(1) NOT NULL default '0',
  `extra24` tinyint(1) NOT NULL default '0',
  `extra25` tinyint(1) NOT NULL default '0',
  `extra26` tinyint(1) NOT NULL default '0',
  `extra27` tinyint(1) NOT NULL default '0',
  `extra28` tinyint(1) NOT NULL default '0',
  `extra29` tinyint(1) NOT NULL default '0',
  `extra30` tinyint(1) NOT NULL default '0',
  `extra31` tinyint(1) NOT NULL default '0',
  `extra32` tinyint(1) NOT NULL default '0',
  `extra33` tinyint(1) NOT NULL default '0',
  `extra34` tinyint(1) NOT NULL default '0',
  `extra35` tinyint(1) NOT NULL default '0',
  `extra36` tinyint(1) NOT NULL default '0',
  `extra37` tinyint(1) NOT NULL default '0',
  `extra38` tinyint(1) NOT NULL default '0',
  `extra39` tinyint(1) NOT NULL default '0',
  `extra40` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

INSERT INTO `#__properties_products` VALUES 
(1, 'House number 1', 'house-number-1', 0, 70, '', 'DKH236', 2, 2, 1, 2, 1, '30312', '454 Grant St.', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 329000.00,'', 1, 0, 1, '1_0.jpg', '', 33.742184, -84.376495, 3, 1, 0, 0, 0, 0, 0, 0, 0, 351, '2010-06-19', '2011-09-12 15:35:10', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'House number 1', 'House number 1, House, For Sale, 30312, 454 Grant St., Atlanta', 'House number 1, House, For Sale, 30312, 454 Grant St., Atlanta', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 'House number 2', 'house-number-2', 0, 70, '', 'QKE949', 2, 2, 2, 2, 1, '30075', 'Corner of Knollwoods', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 315000.00,'', 1, 0, 2, NULL, '', 34.058624, -84.385742, 1, 0, 0, 0, 0, 0, 0, 0, 0, 149, '2010-06-19', '2011-09-12 15:35:14', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'House number 2', 'House number 2, House, For Sale, 30075, Corner of Knollwoods, Roswell', 'House number 2, House, For Sale, 30075, Corner of Knollwoods, Roswell', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'House number 3', 'house-number-3', 0, 70, '', 'CZG922', 2, 2, 3, 2, 1, '30082', '3754 Plumcrest Rd.', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 275000.00,'', 1, 0, 3, NULL, '', 33.862503, -84.538498, 1, 0, 0, 0, 5, 0, 0, 0, 0, 129, '2010-06-19', '2011-09-12 15:35:18', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'House number 3', 'House number 3, House, For Sale, 30082, 3754 Plumcrest Rd., Smyrna', 'House number 3, House, For Sale, 30082, 3754 Plumcrest Rd., Smyrna', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'House number 4', 'apartment-number-4', 0, 70, '', 'DYT122', 2, 2, 3, 2, 1, '30080', '2770 Stonecreek Road', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 198900.00,'', 1, 0, 4, NULL, '', 33.885960, -84.532845, 1, 0, 0, 0, 0, 0, 0, 0, 0, 130, '2010-06-19', '2011-09-12 15:35:22', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'House number 4', 'House number 4, House, For Sale, 30080, 2770 Stonecreek Road, Smyrna', 'House number 4, House, For Sale, 30080, 2770 Stonecreek Road, Smyrna', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'Land number 1', 'land-number-1', 0, 70, '', 'DZM514', 3, 2, 4, 2, 1, '30506', '6021 Trojan Drive', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 499000.00,'', 1, 0, 5, NULL, '', 34.427200, -83.863800, 1, 0, 0, 0, 0, 0, 0, 0, 0, 130, '2010-06-19', '2011-09-12 15:35:26', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'Land number 1', 'Land number 1, Oficce, For Sale, 30506, 6021 Trojan Drive, Gainesville', 'Land number 1, Oficce, For Sale, 30506, 6021 Trojan Drive, Gainesville', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'Condo number 1', 'condo-number-1', 0, 70, '', 'GNN985', 5, 2, 1, 2, 1, '30363', '361 17th St. NW', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 94900.00,'', 1, 0, 6, NULL, '', 33.791382, -84.398399, 1, 0, 0, 0, 0, 0, 0, 0, 0, 139, '2010-06-19', '2011-09-12 15:35:31', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'Condo number 1', 'Condo number 1, Condos, For Sale, 30363, 361 17th St. NW, Atlanta', 'Condo number 1, Condos, For Sale, 30363, 361 17th St. NW, Atlanta', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'Town House number 1', 'town-house-number-1', 0, 70, '', 'SSY788', 6, 2, 5, 2, 1, '30346', '4534 Deerpark Lane', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 126400.00,'', 1, 0, 7, NULL, '', 33.926041, -84.341057, 1, 0, 0, 0, 0, 0, 0, 0, 0, 169, '2010-06-19', '2010-10-09 10:22:44', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', '', '', '', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'Water Front number 1', 'water-front-number-1', 0, 70, '', 'SHP769', 7, 2, 4, 2, 1, '30506', '6756 Lake Lanier Trail', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 2699000.00,'', 1, 0, 8, NULL, '', 34.408966, -83.963799, 1, 0, 0, 0, 0, 0, 0, 0, 0, 188, '2010-06-19', '2010-10-09 10:22:51', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', '', '', '', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'House for rent number 1', 'house-for-rent-number-1', 0, 70, '', 'YLC756', 2, 1, 1, 2, 1, '30327', '2730 Ridgeway Road', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 20000.00,'', 1, 0, 9, NULL, '', 33.922081, -84.283272, 2, 0, 0, 0, 0, 0, 0, 0, 0, 166, '2010-06-19', '2011-08-20 08:54:22', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'House for rent number 1', 'House for rent number 1, House, For Rent, 30327, 2730 Ridgeway Road, Atlanta', 'House for rent number 1, House, For Rent, 30327, 2730 Ridgeway Road, Atlanta', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'Apartment number 4', '2011-08-18-16-21-12', 0, 70, '', 'WYM393', 1, 1, 3, 2, 1, '30080', '2770 Stonecreek Road', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae   euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.   Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque   quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,   leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam   neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras   suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam   justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat   purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,   velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero   justo scelerisque augue. Cum sociis natoque penatibus et magnis dis   parturient montes, nascetur ridiculus mus.</p>', 1000.00,'', 1, 1, 13, NULL, '', 33.885960, -84.532845, 1, 0, 10, 0, 4, 2, 2, 550, 320, 167, '2010-10-09', '2011-08-20 10:30:29', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'Apartment number 4', 'Apartment number 4, Apartment, For Rent, 30080, 2770 Stonecreek Road, Smyrna', 'Apartment number 4, Apartment, For Rent, 30080, 2770 Stonecreek Road, Smyrna', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'Apartment number 5', 'apartment-number-5', 0, 70, '', 'KYE938', 1, 1, 1, 2, 1, '30363', '361 17th St. NW', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae   euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.   Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque   quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,   leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam   neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras   suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam   justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat   purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,   velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero   justo scelerisque augue. Cum sociis natoque penatibus et magnis dis   parturient montes, nascetur ridiculus mus.</p>', 1000.00,'', 1, 0, 14, NULL, '', 33.791382, -84.398399, 1, 0, 10, 0, 2, 4, 2, 300, 200, 200, '2010-10-09', '2011-08-20 10:30:56', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'Apartment number 5', 'Apartment number 5, Apartment, For Rent, 30363, 361 17th St. NW, Atlanta', 'Apartment number 5, Apartment, For Rent, 30363, 361 17th St. NW, Atlanta', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'Apartment number 6', 'apartment-number-6', 0, 70, '', 'BSH565', 1, 1, 5, 2, 1, '30364', '4534 Deerpark Lane', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae   euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.   Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque   quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,   leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam   neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras   suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam   justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat   purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,   velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero   justo scelerisque augue. Cum sociis natoque penatibus et magnis dis   parturient montes, nascetur ridiculus mus.</p>', 1000.00,'', 1, 0, 15, NULL, '', 33.680000, -84.440002, 1, 0, 11, 0, 4, 2, 1, 280, 225, 231, '2010-10-09', '2011-09-03 11:23:49', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'Apartment number 6', 'Apartment number 6, Apartment, For Rent, 30364, 4534 Deerpark Lane, Dunwoody', 'Apartment number 6, Apartment, For Rent, 30364, 4534 Deerpark Lane, Dunwoody', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'Apartment number 1', 'apartment-number-1', 0, 63, '', 'DBQ624', 1, 2, 3, 2, 1, '30312', '454 Grant St.', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 700000.00,'', 1, 0, 10, NULL, '', 33.775513, -84.483482, 1, 1, 10, 0, 2, 2, 2, 100, 70, 178, '2010-06-19', '2011-09-07 14:55:55', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'Apartment number 1', 'Apartment number 1, Apartment, For Sale, 30312, 454 Grant St., Smyrna', 'Apartment number 1, Apartment, For Sale, 30312, 454 Grant St., Smyrna', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'Apartment number 2', 'apartment-number-2', 0, 63, '', 'DQQ367', 1, 1, 4, 2, 1, '30075', 'Corner of Knollwoods', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 2500.00,'', 1, 0, 11, NULL, '', 34.058624, -84.385742, 1, 1, 10, 0, 2, 2, 2, 100, 70, 205, '2010-06-19', '2011-08-20 08:54:40', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'Apartment number 2', 'Apartment number 2, Apartment, For Rent, 30075, Corner of Knollwoods, Gainesville', 'Apartment number 2, Apartment, For Rent, 30075, Corner of Knollwoods, Gainesville', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'Apartment number 3', 'apartment-number-3', 0, 63, '', 'ZER246', 1, 2, 6, 1, 1, '30082', '3754 Plumcrest Rd.', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae  euismod urna. Donec malesuada nunc sit amet turpis imperdiet varius.  Vivamus tempus dui eu leo lacinia sed dictum magna tincidunt. Quisque  quis placerat velit. Morbi eu massa nisl, nec posuere turpis. In rutrum,  leo nec lacinia vestibulum, turpis leo luctus dolor, id malesuada quam  neque id ipsum. Maecenas ac orci ut magna mollis sollicitudin. Cras  suscipit sagittis diam sed volutpat. Sed ut lectus sem. Sed ac quam  justo. Donec hendrerit, dui sed cursus aliquet, risus risus feugiat  purus, vitae facilisis quam massa blandit lacus. Vestibulum accumsan,  velit quis dictum ullamcorper, risus arcu viverra leo, in egestas libero  justo scelerisque augue. Cum sociis natoque penatibus et magnis dis  parturient montes, nascetur ridiculus mus.</p>', 500000.00,'', 1, 0, 12, NULL, '', 33.862503, -84.538498, 1, 0, 10, 0, 2, 2, 2, 100, 70, 172, '2010-06-19', '2011-08-18 13:22:05', 0, '0000-00-00 00:00:00', 0, 0, 'PeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=', 'Apartment number 3', 'Apartment number 3, Apartment, For Sale, 30082, 3754 Plumcrest Rd., Washington City', 'Apartment number 3, Apartment, For Sale, 30082, 3754 Plumcrest Rd., Washington City', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

DROP TABLE IF EXISTS `#__properties_products_translations`;
CREATE TABLE `#__properties_products_translations` (
  `pt_id` int(11) NOT NULL auto_increment,
  `pt_pid` int(11) NOT NULL,
  `pt_langid` int(2) NOT NULL,
  `pt_langcode` varchar(5) NOT NULL,
  `pt_name` varchar(255) NOT NULL,
  `pt_alias` varchar(255) NOT NULL,
  `pt_address` varchar(255) default NULL,
  `pt_description` text NOT NULL,
  `pt_text` text NOT NULL,
  `pt_currency` varchar(20) default NULL,
  `pt_published` tinyint(1) NOT NULL,
  `pt_metatitle` varchar(1024) NOT NULL,
  `pt_metadesc` varchar(1024) NOT NULL,
  `pt_metakey` varchar(1024) NOT NULL,
  PRIMARY KEY  (`pt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__properties_product_category`;
CREATE TABLE `#__properties_product_category` (
  `productid` int(11) NOT NULL default '0',
  `categoryid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`productid`,`categoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__properties_product_category` VALUES 
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(9, 1),
(10, 2),
(11, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 2),
(22, 1),
(23, 1),
(24, 1);

DROP TABLE IF EXISTS `#__properties_profiles`;
CREATE TABLE `#__properties_profiles` (
  `id` int(6) NOT NULL auto_increment,
  `mid` int(6) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `alias` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL default '',
  `type` int(1) NOT NULL default '0',
  `info` varchar(255) NOT NULL default '',
  `bio` mediumtext NOT NULL,
  `properties` int(3) NOT NULL default '0',
  `address1` varchar(50) NOT NULL default '',
  `address2` varchar(50) NOT NULL default '',
  `locality` varchar(50) NOT NULL default '',
  `pcode` varchar(10) NOT NULL default '',
  `state` varchar(50) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  `show` tinyint(1) NOT NULL default '0',
  `email` varchar(50) NOT NULL default '',
  `phone` varchar(20) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `mobile` varchar(20) NOT NULL default '',
  `skype` varchar(30) NOT NULL default '',
  `ymsgr` varchar(30) NOT NULL default '',
  `icq` varchar(30) NOT NULL default '',
  `web` varchar(255) NOT NULL default '',
  `blog` varchar(255) NOT NULL default '',
  `image` varchar(70) NOT NULL default '',
  `logo_image` varchar(70) NOT NULL default '',
  `logo_image_large` varchar(70) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `ordering` int(3) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `language` char(7) NOT NULL,
  `canaddproperties` int(3) NOT NULL,
  `canaddimages` int(2) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mid` (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

INSERT INTO `#__properties_profiles` VALUES 
(1, 63, 'Patti Junger', 'patti-junger', '', 0, '', '', 0, '3650 Habersham Rd', '', 'Atlanta', '30305', 'GA', 'United States', 0, 'pjunger@mysite.com', '(404) 504-0801', '(404) 262-1658', '404-849-1183', '', '', '', '', '', '1_p.jpg', '1_l.gif', '', 1, 1, 0, '0000-00-00 00:00:00', '*', 5, 5),
(2, 64, 'B DIANE ARNOLD', 'b-diane-arnold', '', 0, '', '', 0, '79 West Paces Ferry Rd. NW', '', 'Atlanta', '30305', 'GA', 'United States', 0, 'CustomerService@mysite.com', '404-352-2010', '404-352-8063', '', '', '', '', '', '', '2_p.jpg', '', '', 1, 2, 0, '0000-00-00 00:00:00', '*', 5, 5),
(3, 65, 'DEBRA JOHNSTON', 'debra-johnston', '', 0, '', '', 0, '3290 Northside Parkway, NW', '', 'Atlanta', '30327', 'GA', 'United States', 0, 'DEBRA@mysite.com', '(404) 237-5000', '(404) 924-6807', '(404) 312-1959', '', '', '', '', '', '3_p.jpg', '', '', 1, 3, 0, '0000-00-00 00:00:00', '*', 5, 5),
(4, 66, 'Harry Norman,Buckhead', 'harry-normanbuckhead', '', 0, '', '', 0, '', '', 'Atlanta', '', '', '', 0, 'fafa@mysite.com', 'Office: (404) 233-41', '', '', '', '', '', '', '', '4_p.jpg', '4_l.gif', '', 1, 4, 0, '0000-00-00 00:00:00', '*', 5, 5),
(5, 67, 'TROY STOWE', 'troy-stowe', '', 0, '', '', 0, '3284 Northside Parkway', '', 'Atlanta', '30327', 'GA', 'United States', 0, 'troystowe@mysite.net', '(404) 890-7635', '(404) 261-6300', '(770) 314-7251', '', '', '', '', '', '5_p.jpg', '5_l.gif', '', 1, 5, 0, '0000-00-00 00:00:00', '*', 2, 5),
(6, 68, 'Luxe Estates Collection', 'luxe-estates-collection', '', 0, '', '', 0, '810 S. Durango Drive', '', 'Las Vegas', '89145', 'NV', 'United States', 0, 'team@mysite.com', '(702) 684-6100', '(702) 494-8270', '(702) 400-0645', '', '', '', '', '', '6_p.jpg', '6_l.jpg', '6_ll.jpg', 1, 6, 0, '0000-00-00 00:00:00', '*', 5, 5),
(7, 69, 'Jonathan Taylor', 'jonathan-taylor', '', 0, '', '', 0, '1206 30th St NW', '', 'Washington', '20007', 'DC', 'United States', 0, 'jonathan@mysite.com', '(202) 333-1212', '(202) 333-9396', '(202) 276-3344', '', '', '', '', '', '7_p.jpg', '7_l.gif', '', 1, 7, 0, '0000-00-00 00:00:00', '*', 5, 5),
(8, 70, 'Arnold Swatz', 'arnold-swatz', 'Agenzia Turistica Immobiliare', 0, '', '', 0, '1206 30th St NW', '', 'Atlanta', '63039', 'GA', 'United States', 0, 'agencia@agencia.com', '00 39 0735-75.33.23', '00 39 0735-44.61.19', '(202) 276-3344', '', '', '', '', '', '8_p.jpg', '8_l.jpg', '8_ll.jpg', 1, 8, 42, '2011-04-18 19:06:01', '*', 20, 5),
(9, 73, 'usuario prueba 1', 'usuario-prueba-1', 'compania', 0, '', '', 0, 'direccion1', 'direccion2', 'localidad', 'post zip', 'estado', 'pais', 0, 'usuario@prueba.com', 'telefono', 'faxim', 'celuar', '', '', '', '', '', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0),
(10, 74, 'fafafa', 'fafafa', '', 0, '', '', 0, '', '', '', '', '', '', 0, 'admin@fafafa.com', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0);

DROP TABLE IF EXISTS `#__properties_rates`;
CREATE TABLE `#__properties_rates` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` text,
  `week` int(11) NOT NULL,
  `validfrom` date default NULL,
  `validto` date default NULL,
  `rateperday` double default '0',
  `rateperweek` double NOT NULL,
  `mindays` int(11) default NULL,
  `maxdays` int(11) default NULL,
  `minpeople` int(11) default NULL,
  `maxpeople` int(11) default NULL,
  `typeid` varchar(10) default NULL,
  `weekonly` tinyint(2) NOT NULL default '0',
  `validfrom_ts` date default NULL,
  `validto_ts` date default NULL,
  `dayofweek` int(1) NOT NULL default '7',
  `productid` int(11) default NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__properties_rating`;
CREATE TABLE `#__properties_rating` (
  `product_id` int(11) NOT NULL,
  `rating_sum` int(11) NOT NULL,
  `rating_count` int(11) NOT NULL,
  `lastip` varchar(50) NOT NULL,
  PRIMARY KEY  (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__properties_rating_user`;
CREATE TABLE `#__properties_rating_user` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `lastip` varchar(50) NOT NULL,
  PRIMARY KEY  (`product_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__properties_showresults`;
CREATE TABLE `#__properties_showresults` (
  `id` int(11) NOT NULL auto_increment,
  `date` datetime NOT NULL,
  `url` varchar(1000) NOT NULL,
  `hits` int(11) NOT NULL,
  `cyid` int(6) NOT NULL,
  `sid` int(6) NOT NULL,
  `lid` int(6) NOT NULL,
  `cid` int(6) NOT NULL,
  `tid` int(6) NOT NULL,
  `capacity` int(2) NOT NULL,
  `bedrooms` tinyint(1) NOT NULL,
  `bathrooms` tinyint(1) NOT NULL,
  `garage` tinyint(1) NOT NULL,
  `minprice` int(6) NOT NULL,
  `maxprice` int(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

INSERT INTO `#__properties_showresults` VALUES 
(1, '2011-08-18 18:40:23', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=0&tid=0&bedrooms=0&bathrooms=0&parking=0&minprice=0&maxprice=0&Itemid=100&lang=en', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, '2011-08-18 18:40:35', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=0&tid=0&bedrooms=2&bathrooms=0&parking=0&minprice=0&maxprice=0&Itemid=100&lang=en', 1, 1, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0),
(3, '2011-08-18 18:41:42', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=0&tid=0&bedrooms=5&bathrooms=0&parking=0&minprice=0&maxprice=0&Itemid=100&lang=en', 1, 1, 0, 0, 0, 0, 0, 5, 0, 0, 0, 0),
(4, '2011-08-18 18:41:51', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=0&tid=0&bedrooms=1&bathrooms=0&parking=0&minprice=0&maxprice=0&Itemid=100&lang=en', 2, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(5, '2011-08-19 13:08:11', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=31&lid=0&cid=0&tid=0&bedrooms=0&bathrooms=0&parking=0&minprice=0&maxprice=0&Itemid=100&lang=es', 1, 1, 31, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, '2011-08-19 18:07:25', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=1&tid=0&bedrooms=0&bathrooms=0&parking=0&minprice=1000&maxprice=0&Itemid=100&lang=es', 4, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1000, 0),
(7, '2011-08-19 18:08:46', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=2&tid=0&bedrooms=0&bathrooms=0&parking=0&minprice=100&maxprice=0&Itemid=100&lang=es', 1, 1, 0, 0, 2, 0, 0, 0, 0, 0, 100, 0),
(8, '2011-08-19 18:11:47', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=2&tid=0&bedrooms=0&bathrooms=0&parking=0&minprice=200&maxprice=0&Itemid=100&lang=es', 1, 1, 0, 0, 2, 0, 0, 0, 0, 0, 200, 0),
(9, '2011-08-19 18:12:17', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=2&tid=0&bedrooms=0&bathrooms=0&parking=0&minprice=100000&maxprice=0&Itemid=100&lang=es', 2, 1, 0, 0, 2, 0, 0, 0, 0, 0, 100000, 0),
(10, '2011-08-19 18:17:18', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=1&tid=0&bedrooms=0&bathrooms=0&parking=0&minprice=0&maxprice=0&Itemid=100&lang=es', 2, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(11, '2011-08-20 13:34:16', '/com-property/20110820/USA/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=1&lid=6&cid=0&tid=0&bedrooms=0&bathrooms=0&parking=0&minprice=0&maxprice=0&Itemid=100&lang=en', 1, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0),
(12, '2011-08-20 18:47:39', '/com-property/20110820/USA/en/all-properties/showresults/1-united-states/0/0/0/0/0-bedrooms/0-bathrooms/0-parking/0-minprice/0-maxprice.html', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, '2011-08-20 18:47:55', '/com-property/20110820/USA/en/all-properties/showresults/1-united-states/1-washington/0/0/0/0-bedrooms/0-bathrooms/0-parking/0-minprice/0-maxprice.html', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, '2011-08-28 16:14:44', '/com-property/20110828/USA/es/propiedades/showresults/1-united-states/0/0/2-for-sale/0/0-bedrooms/0-bathrooms/0-parking/0-minprice/0-maxprice.html', 1, 1, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0),
(15, '2011-08-28 16:17:18', '/com-property/20110828/USA/es/propiedades/showresults/1-united-states/0/0/2-for-sale/0/0-bedrooms/0-bathrooms/0-parking/100000-minprice/750000-maxprice.html', 1, 1, 0, 0, 2, 0, 0, 0, 0, 0, 100000, 750000),
(16, '2011-08-31 17:46:54', '/com-property/20110828/USA/en/all-properties/showresults/1-united-states/0/0/1-for-rent/0/0-bedrooms/0-bathrooms/0-parking/0-minprice/0-maxprice.html', 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(17, '2011-09-07 11:11:02', '/com-property/20110828/USA/en/all-properties/showresults/1-united-states/0/0/0/0/0-bedrooms/0-bathrooms/0-parking/0-minprice/0-maxprice.html', 5, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, '2011-09-07 17:51:45', '/com-property/20110828/usa/index.php?option=com_properties&view=properties&task=showresults&cyid=1&sid=0&lid=0&cid=0&tid=0&bedrooms=0&bathrooms=0&parking=0&minprice=0&maxprice=0&Itemid=100&lang=en', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, '2011-09-07 17:52:22', '/com-property/20110828/USA/en/all-properties/showresults/1-united-states/31-georgia/0/0/0/0-bedrooms/0-bathrooms/0-parking/0-minprice/0-maxprice.html', 1, 1, 31, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, '2011-09-07 17:52:54', '/com-property/20110828/USA/en/all-properties/showresults/1-united-states/1-washington/0/0/0/0-bedrooms/0-bathrooms/0-parking/0-minprice/0-maxprice.html', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, '2011-09-07 17:53:56', '/com-property/20110828/USA/en/home/showresults/1-united-states/0/0/0/0/0-bedrooms/0-bathrooms/0-parking/0-minprice/0-maxprice.html', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, '2011-09-07 17:54:18', '/com-property/20110828/USA/en/home/showresults/1-united-states/1-washington/0/0/0/0-bedrooms/0-bathrooms/0-parking/0-minprice/0-maxprice.html', 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);

DROP TABLE IF EXISTS `#__properties_state`;
CREATE TABLE `#__properties_state` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `parent` int(5) NOT NULL,
  `mid` int(5) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

INSERT INTO `#__properties_state` VALUES 
(1, 'Washington', 'washington', 1, 1, 1, 0, 0, '0000-00-00 00:00:00'),
(2, 'Georgia', 'georgia', 1, 2, 1, 0, 0, '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `#__properties_translations`;
CREATE TABLE `#__properties_translations` (
  `t_id` int(5) NOT NULL auto_increment,
  `t_languageid` int(2) NOT NULL,
  `t_languagecode` varchar(5) NOT NULL,
  `t_table` varchar(100) NOT NULL,
  `t_field` varchar(100) NOT NULL,
  `t_fieldid` int(5) NOT NULL,
  `t_value` varchar(100) NOT NULL,
  `t_alias` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY  (`t_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__properties_type`;
CREATE TABLE `#__properties_type` (
  `id` int(2) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `alias` varchar(100) default NULL,
  `parent` int(2) default NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(1) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `#__properties_type` VALUES 
(1, 'Apartment', 'apartment', 0, 1, 0, 0, '0000-00-00 00:00:00'),
(2, 'House', 'house', 0, 1, 0, 0, '0000-00-00 00:00:00'),
(3, 'Oficce', 'oficce', 0, 1, 0, 0, '0000-00-00 00:00:00'),
(4, 'Land', 'land', 0, 1, 0, 0, '0000-00-00 00:00:00'),
(5, 'Condos', 'condos', 0, 1, 0, 0, '0000-00-00 00:00:00'),
(6, 'Townhouses', 'townhouses', 0, 1, 0, 0, '0000-00-00 00:00:00'),
(7, 'Waterfronts', 'waterfronts', 0, 1, 0, 0, '0000-00-00 00:00:00');


INSERT IGNORE INTO `#__users` VALUES 
(63, 'agent1', 'agent1', 'agent1@agents.com', '17aed3937f0142ccae6480377ff0104a:v0DL5ej8Wqd08kNeG5obSAFn9uxYa7Pu', 'Registered', 0, 0, 18, '2011-06-23 11:30:10', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(64, 'agent2', 'agent2', 'agent2@agents.com', '31f998fed217f2ed1fd8aebfde04e288:tjzK1swpsbtQHEVdasGcuhxyU4Gbk4Kd', 'Registered', 0, 0, 18, '2011-06-23 11:30:29', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(65, 'agent3', 'agent3', 'agent3@agents.com', 'a509df77e5ca9e4fae0348770e61bfd1:85U7URdlttHtzGtxw6cVEo6WeQBJEeNc', 'Registered', 0, 0, 18, '2011-06-23 11:30:48', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(66, 'agent4', 'agent4', 'agent4@agents.com', '251be8d7cb6f6dbd0f4c31d13fcfd5bb:VPs01RWokUxn1KXYeh06g7EfUzRyCQsA', 'Registered', 0, 0, 18, '2011-06-23 11:31:09', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(67, 'agent5', 'agent5', 'agent5@agents.com', '8aae65458776b3290087c4e4005db584:owb1gxaghnPBzmQx5CHC6l6mWfE4j4m1', 'Registered', 0, 0, 18, '2011-06-23 11:31:24', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(68, 'agent6', 'agent6', 'agent6@agents.com', '610fd2155dfdf734b4cb5cd76fac666d:D3ys2Ml2glHpRowG6EdrYIQADrQnEvmu', 'Registered', 0, 0, 18, '2011-06-23 11:31:47', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(69, 'agent7', 'agent7', 'agent7@agents.com', '14bac2df35e6e2d83c2f7d640363debb:BfMzEeFrrVWIIGiebVclVyCKWb5h5YkE', 'Registered', 0, 0, 18, '2011-06-23 11:32:01', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(70, 'agent8', 'agent8', 'agent8@agents.com', '0e6646be137fc54bf45a757ed2e5a8fe:cK3CnfKb9dNB1KtpqvOTx4GmTb0Xmoua', 'Registered', 0, 0, 18, '2011-06-23 11:38:41', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');

INSERT IGNORE INTO `#__core_acl_aro` VALUES 
(11, 'users', '63', 0, 'agent1', 0),
(12, 'users', '64', 0, 'agent2', 0),
(13, 'users', '65', 0, 'agent3', 0),
(14, 'users', '66', 0, 'agent4', 0),
(15, 'users', '67', 0, 'agent5', 0),
(16, 'users', '68', 0, 'agent6', 0),
(17, 'users', '69', 0, 'agent7', 0),
(18, 'users', '70', 0, 'agent8', 0);

INSERT IGNORE INTO `#__core_acl_groups_aro_map` VALUES 
(18, '', 11),
(18, '', 12),
(18, '', 13),
(18, '', 14),
(18, '', 15),
(18, '', 16),
(18, '', 17),
(18, '', 18);