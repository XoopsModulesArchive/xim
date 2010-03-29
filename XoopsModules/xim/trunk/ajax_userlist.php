<?php

include 'header.php';
global $xoopsLogger;
$xoopsLogger->activated = false;

    global $xoopsUser, $xoopsModule;
//$xoopsLogger->activated = false;
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

		$config = im_Getconfig($onlines[$i]['online_uname']);
		$status = $config['status'];
		$userid=$onlines[$i]['online_uid'];
		$username = $onlines[$i]['online_uname'];
		$userlist .= <<<EOD
{"id":"$userid","n":"$username","a":"$avatarURL","status":"$status"},

EOD;
	    }
        }
    }
    header('Content-type: application/json');
    echo "{'users':[$userlist],'total':'$count'}";


?>