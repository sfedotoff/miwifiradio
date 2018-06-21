CREATE TABLE IF NOT EXISTS `admins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(250) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `mail` varchar(70) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `radios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `xid` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `streamurl` varchar(600) DEFAULT '',
  `country` smallint DEFAULT 0,
  `genre` smallint DEFAULT 0,
  `header` varchar(600) DEFAULT '',
  `noencode` tinyint DEFAULT 0,
  `logo` varchar(255) NOT NULL,
  `vps_id` varchar(50) DEFAULT '0',
  `vps_xid` int DEFAULT 0,
  `pid` varchar(10) DEFAULT NULL,
  `requests` int DEFAULT 0,
  `lastrequest` datetime DEFAULT NULL,
  `isPrem` tinyint DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `xid` (`xid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `dev_id` varchar(32) NOT NULL,
  `pass` varchar(50),
  `ip` varchar(15),
  `mail` varchar(50),
  `name` varchar(200) DEFAULT 'UserName',
  `type` int DEFAULT 1,
  `reg_date` date,
  `valid` date,
  `last_visit` date,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `vps` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `vps_id` varchar(32) NOT NULL,
  `vps_key` varchar(50),
  `vps_host` varchar(15),
  `last_sync` date,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `genre` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `gid` tinyint NOT NULL,
  `ru` varchar(50) NOT NULL,
  `en` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `country` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cid` tinyint NOT NULL,
  `ru` varchar(50),
  `en` varchar(50),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO genre VALUES (1, 1, "pop", "pop");
INSERT INTO genre VALUES (2, 2, "jazz", "jazz");
INSERT INTO country VALUES (1, 1, "RU", "RU");
INSERT INTO country VALUES (2, 2, "BY", "BY");