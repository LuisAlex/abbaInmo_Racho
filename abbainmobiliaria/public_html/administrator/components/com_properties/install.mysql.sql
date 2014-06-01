CREATE TABLE IF NOT EXISTS `#__properties_available_product` (
  `id` int(11) NOT NULL auto_increment,
  `id_product` int(11) NOT NULL,
  `date` date NOT NULL,
  `available` tinyint(4) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_bookings` (
  `ob_id_order` int(5) NOT NULL auto_increment,
  `ob_id_property` int(5) NOT NULL,
  `ob_name` varchar(255) NOT NULL,
  `ob_address` varchar(255) NOT NULL,
  `ob_postcode` varchar(255) NOT NULL,
  `ob_city` varchar(255) NOT NULL,
  `ob_state` varchar(255) NOT NULL,
  `ob_country` varchar(255) NOT NULL,
  `ob_phone` varchar(255) NOT NULL,
  `ob_text` text NOT NULL,
  `ob_mail` varchar(255) NOT NULL,
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
  `ob_text_mail` text NOT NULL,
  `ob_language` varchar(255) NOT NULL,
  `ob_contract_name` varchar(255) NOT NULL,
  `ob_contract_send` date default NULL,
  PRIMARY KEY  (`ob_id_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_category` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_comments` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_contacts` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_country` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `mid` int(5) NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_currencies` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `currency` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `position` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `checked_out` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT IGNORE INTO `#__properties_currencies` VALUES
(1, '$', 's', 0, 1, 2, 0, '0000-00-00 00:00:00'),
(2, 'U$D', 'usd', 0, 1, 1, 0, '0000-00-00 00:00:00'),
(3, 'EUR', 'eur', 1, 1, 3, 0, '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `#__properties_images` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_lightbox` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `propid` int(11) NOT NULL default '0',
  `date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_locality` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_openhouse` (
  `id` int(6) NOT NULL auto_increment,
  `pid` int(6) NOT NULL,
  `publish_up` datetime NOT NULL,
  `date` date NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `text` text NOT NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(6) NOT NULL,
  `checked_out` tinyint(1) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_pdfs` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_products` (
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
  `language` char(7) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_products_translations` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_product_category` (
  `productid` int(11) NOT NULL default '0',
  `categoryid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`productid`,`categoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_profiles` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_rates` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` text,
  `validfrom` date default NULL,
  `validto` date default NULL,
  `rateperday` double default '0',
  `rateperweek` double NOT NULL,
  `weekonly` tinyint(2) NOT NULL default '0',
  `productid` int(11) default NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_rating` (
  `product_id` int(11) NOT NULL,
  `rating_sum` int(11) NOT NULL,
  `rating_count` int(11) NOT NULL,
  `lastip` varchar(50) NOT NULL,
  PRIMARY KEY  (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_rating_user` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `lastip` varchar(50) NOT NULL,
  PRIMARY KEY  (`product_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_showresults` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_state` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_translations` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__properties_type` (
  `id` int(2) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `alias` varchar(100) default NULL,
  `parent` int(2) default NULL,
  `published` tinyint(1) NOT NULL,
  `ordering` int(1) NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;