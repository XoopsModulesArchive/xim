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

// Get sound and config from DB to make current dropdown reflect latest changes.
// Kind of backwards way to do it, but all other atemps has failed..
// Uid = current user (ie YOU)
// Uname = Your name

include 'header.php';
global $xoopsLogger;
$xoopsLogger->activated = false;

    global $xoopsUser, $xoopsModule;
	$xoopsLogger->activated = false;
    if (is_object($xoopsUser)) {
        $uid = $xoopsUser->getVar('uid');
        $uname = $xoopsUser->getVar('uname');
		$_SESSION['username'] = $uname;
	}
	$sql = "SELECT * FROM ".$xoopsDB->prefix('xim_pers_conf')." WHERE username = '".$uname."'";
	$result = $xoopsDB->query($sql);
	 while ($myrow=$xoopsDB->fetchArray($result)) {
		$id = $myrow['id'];
		$username = $myrow['username'];
		$status = $myrow['status'];
		$sound = $myrow['sound'];
	 }
     
     if ($sound == '') {
        $sound = 0;
     }
     
     if ($status == '') {
        $status = 0;
     }
    header('Content-type: application/json');
    echo "{\"myid\":$uid, \"uso\":$sound, \"uss\":$status}";

?>