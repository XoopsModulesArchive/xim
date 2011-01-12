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


include 'header.php';
global $xoopsLogger;
$xoopsLogger->activated = false;

    global $xoopsUser, $xoopsModule;
	$xoopsLogger->activated = false;
	$online_handler =& xoops_gethandler('online');
    mt_srand((double)microtime()*1000000);
    // set gc probabillity to 10% for now..
    if (mt_rand(1, 100) < 11) {
        $online_handler->gc(300);
    }
    if (is_object($xoopsUser)) {
        $uid = $xoopsUser->getVar('uid');
        $uname = $xoopsUser->getVar('uname');
	$_SESSION['username'] = $uname;
	xim_setPersonalConfig (); // Function to create/check personal config (culex)
    } else {
        $uid = 0;
        $uname = '';
    }

    if (is_object($xoopsModule)) {
        $online_handler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);
    } else {
        $online_handler->write($uid, $uname, time(), 0, $_SERVER['REMOTE_ADDR']);
    }
    $onlines = $online_handler->getAll();
    $userlist='';
    if (false != $onlines) {
        $total = count($onlines);
	$count = 0;
        for ($i = 0; $i < $total; $i++) {
	    if (($onlines[$i]['online_uid'] > 0) && ($onlines[$i]['online_uid']!=$uid)) {
		$count++;
		$user = new XoopsUser($onlines[$i]['online_uid']);
		$avatar =$user->user_avatar();
		if ($avatar!='blank.gif') {
			$avatarURL = XOOPS_URL."/uploads/".$avatar;
		} else {
			$avatarURL = XOOPS_URL."/modules/xim/images/default_avatar.png";
		}
		
		// testing if avatar really exists physically on server
		if (file_exists("../../uploads/".$avatar)) {
		} else {
			$avatarURL = XOOPS_URL."/modules/xim/images/default_avatar.png";
		}
		
		
		$config = im_Getconfig($onlines[$i]['online_uname']);
		$status = $config['status'];
		$userid=$onlines[$i]['online_uid'];
		$username = $onlines[$i]['online_uname'];
		if ($status == 3) {$count = $count -1;}
		if ($status!=3){
			$userlist .= <<<EOD
{"id":"$userid","n":"$username","a":"$avatarURL","status":$status},
EOD;
		}	    
	    }
        }
$userlist = substr($userlist, 0, -1);
    }
    header('Content-type: application/json');
    echo "{\"total\":$count, \"users\":[$userlist]}";


?>