CREATE TABLE `xim_chat` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `from` mediumint(8) unsigned NOT NULL,
  `to` mediumint(8) unsigned NOT NULL,
  `message` TEXT NOT NULL,
  `sent` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)ENGINE = InnoDB;

CREATE TABLE `xim_pers_conf` (
  `id` int(1) unsigned NOT NULL auto_increment,
  `username` text NOT NULL,
  `sound` int(1) NOT NULL default '1',
  `status` int(1) NOT NULL default '2',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;