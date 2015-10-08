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


include('../../../mainfile.php');
global $xoopsDB,$xoopsLogger,$xoopsUser;
 $xoopsLogger->activated = false;
if (is_object($xoopsUser)){
	if($_POST) {
		if ($_POST['sound'] != '') {
			 $sound=$_POST['sound'];
			  $sound=mysql_real_escape_string($sound);
			 
			 $status=$_POST['status'];
			  $status=mysql_real_escape_string($status);
		}
		if ($_POST['soundf'] != '') {
			 $sound=$_POST['soundf'];
			  $sound=mysql_real_escape_string($sound);
			 
			 $status=$_POST['statusf'];
			  $status=mysql_real_escape_string($status);		  
		}
		
	 $username = $xoopsUser->uname(); 
		$sql = "UPDATE ".$xoopsDB->prefix('xim_pers_conf')." SET sound='".intval($sound)."', status='".intval($status)."' WHERE username='".addslashes($username)."'";
		 $result = $xoopsDB->queryF($sql);
	}
}
?>
<span>Saved!</span>