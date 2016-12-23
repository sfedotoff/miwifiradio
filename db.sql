CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(250) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `radios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `xid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `streamurl` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `pid` varchar(6) DEFAULT NULL,
  `lastrequest` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `xid` (`xid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;