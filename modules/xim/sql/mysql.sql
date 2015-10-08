--  You may not change or alter any portion of this comment or credits
--  of supporting developers from this source code or any supporting source code
--  which is considered copyrighted (c) material of the original comment or credit authors.
--  This program is distributed in the hope that it will be useful,
--  but WITHOUT ANY WARRANTY; without even the implied warranty of
--  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
-- 
--  XIM - Xoops Instant Messenger
-- 
--  A one-on-one messenger written for xoops. Inspired by Anant Garg's -(anantgarg.com | inscripts.com)-
--  2009 tutorial on jquery messenger & by the original facebook messenger and a few more. This module has
--  been adapted, written, re-written and extended heavily by Andrax & Culex.
-- 
--  @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
--  @license         http://www.fsf.org/copyleft/gpl.html GNU public license
--  @package         modules
--  @subpackage      xim
--  @since           2.4.0
--  @author          Andrax - homepage.: http://guxbrasil.org & email.: lcbc@ig.com.br
--  @author          Culex  - homepage.: http://culex.dk		& email.: culex@culex.dk

CREATE TABLE `xim_chat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from` int(8) NOT NULL,
  `to` int(8) NOT NULL,
  `message` text NOT NULL,
  `sent` datetime NOT NULL default '0000-00-00 00:00:00',
  `sys` int(1) NOT NULL default '1',
  `recd` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
)ENGINE = InnoDB;

CREATE TABLE `xim_pers_conf` (
  `id` int(1) unsigned NOT NULL auto_increment,
  `username` text NOT NULL,
  `sound` int(1) NOT NULL default '8',
  `status` int(1) NOT NULL default '2',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;