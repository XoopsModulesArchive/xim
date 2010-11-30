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

require_once 'admin_header.php'; 
global $xoopsDB;
$xoopsLogger->activated = false;
if(isset($_POST['AdminDDoptions'])) {

	switch($_POST['AdminDDoptions']) {
	case '0':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 1 WEEK ) AND sys != '-1' AND recd='1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	case '1':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 1 WEEK ) AND sys != '-1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	case '2':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 2 WEEK ) AND sys != '-1' AND recd='1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	case '3':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 2 WEEK ) AND sys != '-1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	case '4':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 1 MONTH ) AND sys != '-1' AND recd='1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	case '5':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 1 MONTH ) AND sys != '1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	case '6':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 1 WEEK ) AND sys != '1' AND recd='1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	case '7':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 1 WEEK ) AND sys != '1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	case '8':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 2 WEEK ) AND sys != '1' AND recd='1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	case '9':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 2 WEEK ) AND sys != '1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
		case '10':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 1 MONTH ) AND sys != '1' AND recd='1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
		case '11':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE `sent` < DATE_SUB( NOW( ) , INTERVAL 1 MONTH ) AND sys != '1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
		case '12':
	  $sql = "DELETE FROM ".$xoopsDB->prefix('xim_chat')." WHERE recd='1' AND sys != '1'";
	  $result = $xoopsDB->queryF($sql);
	  break;
	} 
} else {return false;}
?>