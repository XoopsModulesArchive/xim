<?php
/**
* You may not change or alter any portion of this comment or credits
* of supporting developers from this source code or any supporting source code
* which is considered copyrighted (c) material of the original comment or credit authors.
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
* XIM - Xoops Instant Messenger
*
* A one-on-one messenger written for xoops. Inspired by Anant Garg's -(anantgarg.com | inscripts.com)-
* 2009 tutorial on jquery messenger & by the original facebook messenger and a few more. This module has
* been adapted, written, re-written and extended heavily by Andrax & Culex.
*
* @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
* @license         http://www.fsf.org/copyleft/gpl.html GNU public license
* @package         modules
* @subpackage      xim
* @since           2.4.0
* @author          Andrax - homepage.: http://guxbrasil.org & email.: lcbc@ig.com.br
* @author          Culex  - homepage.: http://culex.dk		& email.: culex@culex.dk
**/

define('_MI_XIM_MODULE_NAME','XIM');
define('_MI_XIM_ADMENU','Administration');
define('_MI_XIM_MODULE_DESC','A block to show currently online users. Press name to open chat window');
define("_MB_XIM_BLOCK","IM");
define('_XIM_CREDIT','Original script by Anant Garg (anantgarg.com)');
define('_XIM_SHOW_FOOTER_BAR','Show footer bar?');
define('_XIM_FOOTER_BAR_STYLE','Footer bar style');
define('_XIM_FOOTER_FULL','Full');
define('_XIM_FOOTER_TINY','Tiny');

//styling for chat windows
define('_XIM_CHATWINDOWSTYLE_STYLE','Chat window skin');
define('_XIM_CHATWINDOWSTYLE_DESC','Choose here the style for your chat windows');
define('_XIM_CHATWINDOWSTYLE_DEFAULT','Default');
define('_XIM_CHATWINDOWSTYLE_WHITE','White');
define('_XIM_CHATWINDOWSTYLE_BLACK','Black');
define('_XIM_CHATWINDOWSTYLE_STIKY','Stiky');
define('_XIM_CHATWINDOWSTYLE_ALERT','Alert');

// about logs
define('_XIM_CHATDELETE_LOGS','Delete messages..');
define('_XIM_CHATDELETE_LOGS_DESC','Never delete = 0. <br/>Set a number for deleting recieved messages older than X minutes.<br/>A number bigger than 60 is adviceable.');
?>
