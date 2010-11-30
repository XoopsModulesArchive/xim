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
$xoopsLogger->activated = false;
if(isset($_POST['xim_admin_message'])) {
$message = mysql_real_escape_string($_POST['xim_admin_message']);
ximAdminFindall ($message);
} else {return false;}
function ximAdminFindall ($message) {
	global $xoopsDB;
	//$sql = "SELECT * FROM ".$xoopsDB->prefix('xim_chat')."";
	$sql = "SELECT `uid` FROM " . $xoopsDB->prefix('users') . "";
	$result = $xoopsDB->queryF($sql);
		$counter = 0;
		while ($sqlfetch = $xoopsDB->fetchArray($result)) {
		 $user[$counter] = $sqlfetch['uid'];
		 $counter++;
		}
		$users = array_unique(flatten($user));
		foreach ($users as $key => $value)
		{
		ximSendToAll ($value, $message);
		}
		return true;
}

function ximSendToAll ($user, $message) {
global $xoopsDB;
$sql = "insert into ".$xoopsDB->prefix('xim_chat')." (`from`,`to`,`message`,`sent`,`sys`,`recd`) values ('".mysql_real_escape_string('-1')."', '".mysql_real_escape_string($user)."','".mysql_real_escape_string($message)."',NOW(),'-1','0')";
$query = $xoopsDB->queryF($sql);
return true;
}

// flatten multidimentional arrays to one dimentional
	function flatten($array) {
		$return = array();
		while(count($array)) {
			$value = array_shift($array);
			if(is_array($value))
				foreach($value as $sub)
					$array[] = $sub;
			else
				$return[] = $value;
		}
		return $return;
	}
?>