

CREATE TABLE IF NOT EXISTS `#__macgallery_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL,
  `thumbimage` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `singleimg` tinyint(1) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `albumid` int(11) NOT NULL,
  `albcover` tinyint(1) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM ;




CREATE TABLE IF NOT EXISTS `#__macgallery_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rowimg` int(11) NOT NULL,
  `rows` int(11) NOT NULL,
  `thumbimgheight` int(11) NOT NULL,
  `thumbimgwidth` int(11) NOT NULL,
  `mouseover_width` int(11) NOT NULL,
  `mediumimgheight` int(11) NOT NULL,
  `mediumimgwidth` int(11) NOT NULL,
  `fullimgheight` int(11) NOT NULL,
  `fullimgwidth` int(11) NOT NULL,
  `proximity` int(11) NOT NULL,
  `effect_direction` tinyint(1) NOT NULL DEFAULT '0',
  `imgdisplay` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `alblist` tinyint(1) NOT NULL,
  `imgdispstyle` tinyint(1) NOT NULL,
  `api_key` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  ;


CREATE TABLE IF NOT EXISTS `#__macgallery_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `albumname` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(4) NOT NULL,
  `imgcount` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;



INSERT INTO `#__macgallery_album` (`id`,`albumname`,`description`,`published`,`imgcount`,`created`) VALUES (1,'First Album','This is first album',1,0,CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE id=id ;



INSERT INTO `#__macgallery_settings` (`id`, `rowimg`, `rows`, `thumbimgheight`, `thumbimgwidth`, `mouseover_width`, `mediumimgheight`, `mediumimgwidth`, `fullimgheight`, `fullimgwidth`, `proximity`, `effect_direction`, `imgdisplay`, `published`, `alblist`, `imgdispstyle`, `api_key`) VALUES
(1, 4, 4, 50, 50, 50, 400, 500, 600, 700, 90, 1, 0, 0, 1, 1, '') ON DUPLICATE KEY UPDATE id=id;
