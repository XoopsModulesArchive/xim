-- --------------------------------------------------------
-- Xoops Instant Messenger (xim)
-- Compatability (Mysql 5 & 4)
-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `xoops_xim_chat`
--
CREATE TABLE `xim_chat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from` mediumint(8) unsigned NOT NULL,
  `to` mediumint(8) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` datetime NOT NULL default '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Struktur-dump for tabellen `xoops_xim_pers_conf`
-- 
CREATE TABLE `xim_pers_conf` (
  `id` int(1) unsigned NOT NULL auto_increment,
  `username` text NOT NULL,
  `sound` int(1) NOT NULL default '1',
  `status` int(1) NOT NULL default '2',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;